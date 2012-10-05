<?PHP

/*
	-----------------------------------------
		NewLife Blogging System Version 3
	-----------------------------------------
	Nick F <nick@sevengraff.com>
	www.sevengraff.com
	-----------------------------------------
	This product is distributed under the GNU
	GPL liscense. A copy of that liscense 
	should be packaged with this product.
	-----------------------------------------
*/

require_once 'config.php';				// require_once this before others!
require_once 'system/functions.php';
require_once 'system/ets_sql.php';

require_once 'system/sqldb2.class.php';	
require_once 'system/nlb_blog.class.php';
require_once 'system/nlb_user.class.php';
require_once 'system/nlb_config.class.php';
require_once 'system/text.class.php';

require_once 'ets.php';	

$path = fetch_url_data();

$db = new sqldb2( $DB_CONFIG );
$blog = new nlb_blog( $db );
$config = new nlb_config( $db );
require_once $config->langfile();
$user = new nlb_user( $db );

$user->checkLogin();

if( isset( $path['user'] ) ) {
	
	/**
	 *		Show page of blogs for user
	 */
	$USERID = $path['user'];
	if( !is_numeric($USERID) ) {
		jsRedirect( script_path . 'index.php' );
	}
	$u = new nlb_user( $db, $USERID );	// $u is the user who's friends page we are viewing
	$page = 0;
	if( isset( $path['page']) ) {
		$page = $path['page'];
	}
	$perpage = $u->get('perpage');

	$page_start = $page * $perpage;
	
	// get avatar for this user
	$av = $db->getArray('SELECT file, isCustom FROM ' . db_avatars . ' WHERE owner_id=' . $USERID . ' AND type=1;');

	if( !empty( $av ) ) {
		if( $av['isCustom'] == 1 ) {
			$file = 'avatars/';
		} else {
			$file = 'avatars/default/';
		}
		$file .= $av['file'];
		$ets->avatar_url = script_path . $file;
		$ets->avatar = '<img src="' . script_path . $file . '" />';
	}
	
	// get list of friends
	$list = $db->getAllArray('SELECT friend_id FROM ' . db_friends . ' WHERE owner_id = ' . $USERID . ';');
	if( $db->getRowCount() == 0 ) {
		
		// This user has no friends.
		$ets->blog[0]->body = $l['no-friends'];
		$ets->blog[0]->comments = false;
		$ets->blog[0]->author = $u->get('username');
		$ets->blog[0]->date = date('M jS, Y g:i a');
				
	} else {
		
		// this user does have friends.
		
		// build it into an IN() paramater
		$in = '';
		foreach( $list as $row ) {
			$in .= $row['friend_id'] . ', ';
		}
		$in = substr( $in, 0, -2 );
		
		// get avatars of friends.
		$results = $db->query('SELECT owner_id, file, isCustom, type FROM ' . db_avatars . ' WHERE owner_id IN(' . $in . ') AND type IN(2,1);');
		$avatars = array();
		while( $row = mysql_fetch_assoc( $results ) ) {
			// do we already have an avatar for this user?
			$id = $row['owner_id'];
			if( isset($avatars[$id]) && $avatars[$id]['type'] != 2 ) {
				$avatars[$id] = $row;
			}
			if( !isset($avatars[$id]) ) {
				$avatars[$id] = $row;
			}
		}
		
		// list of user names for linking
		$results = $db->query('SELECT user_id, username FROM ' . db_users . ' WHERE user_id IN(' . $in . ');');
		$i = 0;
		while( $row = mysql_fetch_assoc($results) ) {
			$ets->friend_list[$i]->name = $row['username'];
			$ets->friend_list[$i]->url_blogs = build_link('blog.php', array('user'=>$row['user_id']));
			$ets->friend_list[$i]->url_profile = build_link('profile.php', array('user'=>$row['user_id']));
			$i++;
		}
		
		// get total blogs we may be showing
		$total = $db->getArray('SELECT COUNT(blog_id) as c FROM ' . db_blogs . ' WHERE author_id IN(' . $in . ') AND access=' . access_public );
		$total = $total['c'];
		
		// setup some vars for the query
		$limit = $page_start . ', ' . $perpage;
		
		// get the blogs
		$all = $db->getAllArray('# Get page of blogs
		SELECT b.blog_id, b.author_id, b.date, b.subject, b.body, b.access, b.mood, b.custom AS custom_text, b.comments, b.html, b.smiles, b.bb, u.username AS author, u.custom AS custom_title, u.date_format
		FROM ' . db_blogs . ' as b, ' . db_users . ' as u
		WHERE b.access = ' . access_public . ' AND b.author_id IN(' . $in . ') AND b.author_id = u.user_id
		ORDER BY b.date DESC
		LIMIT ' . $limit . ';');
		
		// timezone settings
		if( $user->isLogedIn ) {
			$blog->setDateOffset( $config->get('server_timezone'), $user->get('timezone') );
		}
		
		// parse the blogs
		$blog->setDate( $u->get('date_format') );
		$i = 0;
		foreach( $all as $item ) {
			$ets->blog[$i] = $blog->format( $item, $user, $l['edit'] );
			// check for avatar
			if( isset( $avatars[ $item['author_id'] ] ) ) {
				$id = $item['author_id'];
				if( $avatars[$id]['isCustom'] == 1 ) {
					$av_file = script_path . 'avatars/';
				} else {
					$av_file = script_path . 'avatars/default/';
				}
				$av_file .= $avatars[$id]['file'];
				$ets->blog[$i]->avatar_url = $av_file;
				$ets->blog[$i]->avatar = '<img src="' . $av_file . '" />';
			}
			$i++;
		}
		
		// setup tags for next/prev pages.
		if( $page > 0 ) {
			$ets->url_page_prev = build_link('friends.php', array('page'=>($page-1), 'user'=>$USERID));
		}
		if( $total > ($page_start + $perpage) ) {
			$ets->url_page_next = build_link('friends.php', array('page'=>($page+1), 'user'=>$USERID));
		}
	}
	
	$ets->username = $u->get('username');
	$ets->USER_TEMPLATE = serialize( array( 'type' => 'friends', 'user_id' => $USERID ) );	
	$OUTTER = serialize( array( 'type' => 'outter' ) );
	 
} else {

	if( $user->isLogedIn ) {
		jsRedirect( script_path . 'friends.php/user/' . $this->id );
	} else {
		jsRedirect( script_path . 'index.php');

	}
}

// debug( $ets ); exit;

// setup some standard tags
$uid_array 			= array('user'=>$USERID);
$ets->url_home 		= build_link('blog.php', $uid_array);
$ets->url_profile	= build_link('profile.php', $uid_array);
$ets->url_friends	= build_link('friends.php', $uid_array);
$ets->rss_url		= build_link('rss.php', array('id'=>$USERID));
$ets->rss_img		= '<a href="' . $ets->rss_url . '"><img src="' . script_path . 'xml.gif" border="0" /></a>';

printt( $ets, $OUTTER );

?>