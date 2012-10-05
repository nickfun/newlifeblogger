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
require_once 'system/ets_file.php';

require_once 'system/sqldb2.class.php';
require_once 'system/nlb_mail.class.php';
require_once 'system/nlb_blog.class.php';
require_once 'system/nlb_user.class.php';
require_once 'system/nlb_config.class.php';
require_once 'system/text.class.php';

require_once 'ets.php';	

define('IN_NLB3', 'true');

$start = mymicrotime();

$db = new sqldb2( $DB_CONFIG );
$config = new nlb_config( $db );
$user = new nlb_user( $db );
$user->checklogin();

include $config->langfile();		// include lang file

$b = new nlb_blog( $db );

if( !$user->isLogedIn ) {
	jsRedirect("login.php");
} else {
	// timezone setting
	$b->setDateOffset( $config->get('server_timezone'), $user->get('timezone') );
}

$ets_outter->sitenav = buildMainNav( $l, $user );
$ets->page_body = "";

//		N A V   L I N K S
$ets_outter->navtype = $l['ucp-nav-usercp'];
$i=0;
$ets_outter->usernav[$i]->text = $l['ucp-nav-newblog'];
$ets_outter->usernav[$i]->link = script_path . 'usercp.php?action=new_blog';
$i++;
$ets_outter->usernav[$i]->text = $l['ucp-nav-editblog'];
$ets_outter->usernav[$i]->link = script_path . 'usercp.php?action=edit_list';
$i++;
$ets_outter->usernav[$i]->text = $l['ucp-nav-view'];
$ets_outter->usernav[$i]->link = script_path . 'usercp.php?action=view';
$i++;
$ets_outter->usernav[$i]->text = $l['ucp-nav-profile'];
$ets_outter->usernav[$i]->link = script_path . 'usercp.php?action=profile';
$i++;
$ets_outter->usernav[$i]->text = $l['ucp-nav-avatars'];
$ets_outter->usernav[$i]->link = script_path . 'usercp.php?action=avatars';
$i++;
$ets_outter->usernav[$i]->text = $l['ucp-nav-friends'];
$ets_outter->usernav[$i]->link = script_path . 'usercp.php?action=friends';
$i++;
$ets_outter->usernav[$i]->text = $l['ucp-nav-templates'];
$ets_outter->usernav[$i]->link = script_path . 'usercp.php?action=template';
$i++;
$ets_outter->usernav[$i]->text = $l['ucp-nav-password'];
$ets_outter->usernav[$i]->link = script_path . 'usercp.php?action=password';

// 		B O D Y 

if( isset($_GET['action']) ) {
	$action = $_GET['action'];
} else {
	if( !$user->isAllowed('blog') ) {
		$action = 'view';
	} else {
		$action = 'new_blog';
	}
}

// ---------------------
// List of valid actions
// ---------------------

$good_actions = array(
	'new_blog', 'edit_blog', 'edit_list', 'delete_blog',
	'view', 'profile', 'avatars', 'avatar_upload', 
	'avatar_default', 'avatar_delete', 'friends', 'template',
	'password',
);

if( !in_array( $action, $good_actions ) ) {
	jsRedirect('index.php');
} else {
	require 'inc_ucp/' . $action . '.php';
}

// Build output

$ets_outter->recent_blogs = $b->getRecent( $config );
$ets_outter->query_count = $db->getquerycount();
$ets_outter->script_path = script_path;
$ets_outter->gen_time = mymicrotime( $start, 5 );
$ets_outter->welcome[] = $user->getWelcomeTags();

printt($ets_outter, 	skin_header);
printt($ets, 			$USESKIN );
printt($ets_outter, 	skin_footer);

?>