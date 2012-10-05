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
include $config->langfile();
$user = new nlb_user( $db );

$user->checkLogin();

if( !isset($path['user']) ) {

	jsRedirect( script_path . 'index.php');	// need a user id!!

} else {
	
	$USERID = $path['user'];
	
	if( !is_numeric($USERID) ) {
		jsRedirect( script_path . 'index.php' );
	}
	
	// get info on user
	$info = $db->getArray('
	SELECT username, email, blog_count, birthday, gender, registered, bio 
	FROM ' . db_users . ' 
	WHERE user_id="' . $USERID . '" 
	LIMIT 1;');
	
	if( empty( $info ) ) {
		jsRedirect( script_path . 'index.php');	// not valid userid
	}
	// comment count
	$tmp = $db->getArray('SELECT COUNT(comment_id) AS count FROM ' . db_comments . ' WHERE author_id="' . $USERID . '";');
	$info['comment_count'] = $tmp['count'];
	
	// friends count
	$tmp = $db->getArray('SELECT COUNT(*) AS count FROM ' . db_friends . ' WHERE owner_id="' . $USERID . '";');
	$info['num_friends'] = $tmp['count'];
	
	// as friend count
	$tmp = $db->getArray('SELECT COUNT(*) AS count FROM ' . db_friends . ' WHERE friend_id = ' . $USERID . ' ;');
	$info['num_as_friend'] = $tmp['count'];
	
	// little cleanup before parsing
	if( empty($info['birthday']) ) {
		$info['birthday'] = $l['na'];
	} else {
		$info['birthday'] = date('dS of F Y', $info['birthday']);
	}
	
	$info['registered'] = date('M jS, Y g:i a', $info['registered']);
	
	if( $info['gender'] == 1 ) {
		$info['gender'] = $l['gender-male'];
	} else if( $info['gender'] == 2 ) {
		$info['gender'] = $l['gender-female'];
	} else {
		$info['gender'] = $l['na'];
	}
	
	if( !$user->isLogedIn ) {
		$e = $info['email'];
		$e = str_replace('@', ' at ', $e);
		$e = str_replace('.', ' dot ', $e);
		$info['email'] = $e;
	}
	
	// loop through the array and assign template tags
	foreach( $info as $key => $val ) {
		$ets->$key = $val;
	}
	
	// setup other template tags
	$ets->username = $info['username'];
	$ets->url_home = build_link('blog.php', array('user'=>$USERID));
	$ets->url_profile = build_link('profile.php', array('user'=>$USERID));
	$ets->url_friends = build_link('friends.php', array('user'=>$USERID));
	
	// check for avatar
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
	
	// rss bit
	$ets->rss_url = build_link('rss.php', array('id'=>$USERID));
	$ets->rss_img = '<a href="' . $ets->rss_url . '"><img border="0" src="' . script_path . 'xml.gif" /></a>';

	$ets->USER_TEMPLATE = serialize( array( 'type' => 'profile', 'user_id' => $USERID ) );
	$OUTTER = serialize( array( 'type' => 'outter' ) );

	printt( $ets, $OUTTER );
	
}

?>