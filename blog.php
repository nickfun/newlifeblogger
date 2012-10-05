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

require_once 'config.php';
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

if( isset( $path['id']) ) {
	
	/**
	 * =======================================
	 *		Show single blog & Comments
	 * =======================================
	 */
	 
	$blog_id = $path['id'];
	if( !is_numeric($blog_id) ) {
		jsRedirect( script_path . 'index.php' );
	}
	
	// blog exists?
	$test = $db->getArray('SELECT count(blog_id) as c FROM ' . db_blogs . ' WHERE blog_id="' . $blog_id . '";');
	if( $test['c'] == 0 ) {
		// bad blog id
		jsRedirect( script_path . 'index.php' );
	}
	
	$q = '# GET BLOG
	SELECT b.blog_id, b.author_id, b.date, b.subject, b.body, b.access, b.mood, b.custom AS custom_text, b.comments, b.html, b.smiles, b.bb, u.username AS author, u.custom AS custom_title, u.date_format
	FROM ' . db_blogs . ' AS b, ' . db_users . ' AS u
	WHERE b.author_id = u.user_id AND b.blog_id = "' . $blog_id . '"
	ORDER BY b.date DESC
	LIMIT 1 ;';
	
	$thisblog = $db->getArray( $q );
	
	if( $thisblog['access'] == access_news ) {
		jsRedirect( build_link('index.php', array('action'=>'comment', 'id'=>$blog_id)) );
	}
	
	if( $thisblog['access'] == access_private && !$user->isLogedIn ) {
		jsRedirect( script_path . 'index.php' );
	}
	
	if( $thisblog['access'] == access_private && $user->isLogedIn && $user->id != $thisblog['author_id'] ) {
		jsRedirect( script_path . 'index.php' );
	}
	
	if( $thisblog['access'] == access_friendsonly && !$user->isLogedIn ) {
		jsRedirect( script_path . 'index.php' );
	}

	if( $thisblog['access'] == access_friendsonly && $user->isLogedIn ) {
		$isAFriend = false;
		// get list of blog owners' friends
		// This should probally be a method of nlb_users, but I only have to do this once...
		$f = $db->query('SELECT friend_id FROM ' . db_friends . ' WHERE owner_id=' . $thisblog['author_id'] . ';');
		while( $row = mysql_fetch_assoc( $f ) ) {
			if( $row['friend_id'] == $user->id ) {
				$isAFriend = true;
				break;
			}
		}
		if( !$isAFriend ) {
			// Can't see this blog :(
			jsRedirect( script_path . 'index.php' );
		}
	}
	
	
	$blog->setData( $thisblog );
	$blog->setDate( $thisblog['date_format'] );
	if( $user->isLogedIn ) {
		$blog->setDateOffset( $config->get('server_timezone'), $user->get('timezone') );
	}
	
	$USERID = $blog->data['author_id'];
	
	// check for avatars
	$avatar = $db->getArray('SELECT file, isCustom FROM ' . db_avatars . ' WHERE owner_id=' . $USERID . ' AND type=1;');
	if( !empty( $avatar ) ) {
		if( $avatar['isCustom'] == 1 ) {
			$file = 'avatars/';
		} else {
			$file = 'avatars/default/';
		}
		$file .= $avatar['file'];
		$ets->avatar_url = script_path . $file;
		$ets->avatar = '<img src="' . script_path . $file . '" />';
	}
		
	$ets->username = $thisblog['author'];
	$ets->blog = $blog->format( false, $user, $l['edit']);
	$ets->list_comments = $blog->getComments( $blog_id, $config->get('comment_date_format'), $l['guest'], $user, $l['edit'] );
	
	if( $blog->data['comments'] != -1 ) {
		$ets->view_comments = true;
	} else {
		$ets->view_comments = false;
	}
	
	// form to add comment
	if( $user->isAllowed('comment') || !$user->isLogedIn ) {
		$name = $user->isLogedIn ? $user->get('username') : $l['guest'];
		$submit_text = sprintf($l['comment_submit'], $name);
		$ets->add_comment = '
<script type="text/javascript">
	function insertWindow( gotopage ) {
		window.open( gotopage, \'newwindow\',\'toolbar=0,location=0,directories=0,menuBar=0,resizable=1,scrollbars=yes,width=400,height=500,left=20,top=20\');
	}
</script>
		<form method="post" action="' . script_path . 'addcomment.php" name="new_entry">
		<input type="hidden" name="parent" value="' . $blog->data['blog_id'] . '">
		<textarea name="body" class="nlb_add_comment"></textarea> <br>
		<input class="nlb_add_comment" type="submit" value="' . $submit_text . '">
		</form>';
		$ets->link_smiles = $l['link_smiles'];
		$ets->link_bbcode = $l['link_bbcode'];
	} else {
		$ets->add_comment = $l['disallow-comments'];
	}
	
	$ets->USER_TEMPLATE = serialize( array( 'type' => 'blog', 'user_id' => $blog->data['author_id'] ) );
	$OUTTER = serialize( array( 'type' => 'outter' ) );

} else if( isset( $path['user'] ) ) {
	
	/**
	 * =======================================
	 *		Show page of blogs
	 * =======================================
	 */
	$USERID = $path['user'];
	if( !is_numeric($USERID) ) {
		jsRedirect( script_path . 'index.php' );
	}
	
	// user exists?
	$test = $db->getArray('SELECT count(user_id) as c FROM ' . db_users . ' WHERE user_id="' . $USERID . '";');
	if( $test['c'] == 0 ) {
		// bad user id
		jsRedirect( script_path . 'index.php' );
	}
	
	$u = new nlb_user( $db, $USERID );
	$page = 0;
	if( isset( $path['page']) ) {
		$page = $path['page'];
	}
	$perpage = $u->get('perpage');
	$page_start = $page * $perpage;
	
	// get count of all the blogs
	$total = $u->get('blog_count');
	
	// setup some vars for the query
	$limit = $page_start . ', ' . $perpage;
	// check to see what blogs we can view
	$access_in = access_public;	 // default is public blogs only.
	if( $user->isLogedIn ) {
		// if we are the author, we can see all
		if( $user->id == $u->id ) {
			$access_in = access_public . ', ' . access_private . ', ' . access_friendsonly;
		}
		// are we a friend?
		if( $u->areFriends( $user->id ) ) {
			$access_in = access_public . ', ' . access_friendsonly;
		}
	}
	
	// get the blogs
	$all = $db->getAllArray('# Get page of blogs
	SELECT b.blog_id, b.author_id, b.date, b.subject, b.body, b.access, 
		b.mood, b.custom AS custom_text, b.comments, b.html, b.smiles, 
		b.bb, u.username AS author, u.custom AS custom_title, u.date_format
	FROM ' . db_blogs . ' AS b, ' . db_users . ' AS u
	WHERE u.user_id = ' . $USERID . ' AND b.author_id = u.user_id AND b.access IN(' . $access_in . ')
	ORDER BY b.date DESC
	LIMIT ' . $limit . ';');
	
	// timezone settings
	if( $user->isLogedIn ) {
		$blog->setDateOffset( $config->get('server_timezone'), $user->get('timezone') );
	}
	
	// check for avatars
	$avatar = $db->getArray('SELECT file, isCustom FROM ' . db_avatars . ' WHERE owner_id=' . $USERID . ' AND type=1;');
	if( !empty( $avatar ) ) {
		if( $avatar['isCustom'] == 1 ) {
			$file = 'avatars/';
		} else {
			$file = 'avatars/default/';
		}
		$file .= $avatar['file'];
		$ets->avatar_url = script_path . $file;
		$ets->avatar = '<img src="' . script_path . $file . '" />';
	}
	
	// parse the blogs
	$blog->setDate( $u->get('date_format') );
	foreach( $all as $item ) {
		$ets->blog[] = $blog->format( $item, $user, $l['edit'] );
	}
	
	// setup tags for next/prev pages.
	if( $page > 0 ) {
		$ets->url_page_prev = build_link('blog.php', array('page'=>($page-1), 'user'=>$USERID));
	}
	if( $total > ($page_start + $perpage) ) {
		$ets->url_page_next = build_link('blog.php', array('page'=>($page+1), 'user'=>$USERID));
	}
	
	$ets->username = $u->get('username');
	$ets->USER_TEMPLATE = serialize( array( 'type' => 'blog', 'user_id' => $USERID ) );
	$OUTTER = serialize( array( 'type' => 'outter' ) );
	 
} else {
	
	/**
	 * =======================================
	 *		Deal with missing data
	 * =======================================
	 */

	if( $user->isLogedIn ) {
		// no data specified, redirecting to users blog
		jsRedirect( build_link('blog.php', array('user'=>$this->id)) );
	} else {
		// no data & not loged in, return to homepage
		jsRedirect( script_path . 'index.php');
	}
}

// setup some standard tags
$uid_array 			= array('user'=>$USERID);
$ets->url_home 		= build_link('blog.php', $uid_array);
$ets->url_profile	= build_link('profile.php', $uid_array);
$ets->url_friends	= build_link('friends.php', $uid_array);
$ets->rss_url		= build_link('rss.php', array('id'=>$USERID));
$ets->rss_img		= '<a href="' . $ets->rss_url . '"><img src="' . script_path . 'xml.gif" border="0" /></a>';

printt( $ets, $OUTTER );

?>