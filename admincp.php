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

require_once 'system/sqldb2.class.php';	// NLB Class library
require_once 'system/nlb_blog.class.php';
require_once 'system/nlb_user.class.php';
require_once 'system/nlb_config.class.php';
require_once 'system/text.class.php';

require_once 'ets.php';					// Sweet template library

define('IN_NLB3', 'true');

$start = mymicrotime();

$db = new sqldb2( $DB_CONFIG );
$config = new nlb_config( $db );
$user = new nlb_user( $db );
$user->checklogin();

require_once $config->langfile();		// require_once lang file

$b = new nlb_blog( $db );

if( !$user->isLogedIn ) {
	jsRedirect("login.php");
} else {
	$b->setDateOffset( $config->get('server_timezone'), $user->get('timezone') );
}

if( !$user->isAllowed('admin') ) {
	jsRedirect('index.php');
}
$ets_outter->sitenav = buildMainNav( $l, $user );
$ets->page_body = "";

//		N A V   L I N K S
$ets_outter->navtype = $l['acp-nav-admincp'];
$i=0;
$ets_outter->usernav[$i]->text = $l['acp-nav-news'];
$ets_outter->usernav[$i]->link = script_path . 'admincp.php';
$i++;
$ets_outter->usernav[$i]->text = $l['acp-nav-editnews'];
$ets_outter->usernav[$i]->link = script_path . 'admincp.php?action=edit_list';
$i++;
$ets_outter->usernav[$i]->text = $l['acp-nav-smiles'];
$ets_outter->usernav[$i]->link = script_path . 'admincp.php?action=smiles';
$i++;
$ets_outter->usernav[$i]->text = $l['acp-nav-outter'];
$ets_outter->usernav[$i]->link = script_path . 'admincp.php?action=outter_template';
$i++;
$ets_outter->usernav[$i]->text = $l['acp-nav-config'];
$ets_outter->usernav[$i]->link = script_path . 'admincp.php?action=config';
$i++;
$ets_outter->usernav[$i]->text = $l['acp-nav-mail'];
$ets_outter->usernav[$i]->link = script_path . 'admincp.php?action=mail_config';
$i++;
$ets_outter->usernav[$i]->text = $l['acp-nav-massmail'];
$ets_outter->usernav[$i]->link = script_path . 'admincp.php?action=mass_mail';
$i++;
$ets_outter->usernav[$i]->text = $l['acp-nav-edit-user'];
$ets_outter->usernav[$i]->link = script_path . 'admincp.php?action=edit_user';
$i++;
$ets_outter->usernav[$i]->text = $l['acp-nav-ban-user'];
$ets_outter->usernav[$i]->link = script_path . 'admincp.php?action=ban_user';
$i++;
$ets_outter->usernav[$i]->text = $l['acp-nav-val-user'];
$ets_outter->usernav[$i]->link = script_path . 'admincp.php?action=validate_users';
$i++;
$ets_outter->usernav[$i]->text = $l['acp-nav-new-art'];
$ets_outter->usernav[$i]->link = script_path . 'admincp.php?action=new_article';
$i++;
$ets_outter->usernav[$i]->text = $l['acp-nav-edit-art'];
$ets_outter->usernav[$i]->link = script_path . 'admincp.php?action=list_article';

$action = 'news';
if( isset($_GET['action']) ) {
	$action = $_GET['action'];
}

// ---------------------
// List of valid actions
// ---------------------

$good_actions = array(
	'news', 'edit_list', 'edit_news', 'delete_news', 'smiles', 
	'new_smile', 'edit_smile', 'config', 'outter_template', 
	'mail_config', 'new_article', 'list_article', 'edit_article',
	'delete_article', 'edit_user', 'edit_user_id', 'ban_user',
	'edit_comment', 'edit_blog', 'validate_users',
	'mass_mail',
);

if( in_array( $action, $good_actions ) ) {
	require 'inc_acp/' . $action . '.php';
} else {
	jsRedirect('index.php');
}

// Print Output

$ets_outter->recent_blogs = $b->getRecent( $config );
$ets_outter->query_count = $db->getquerycount();
$ets_outter->script_path = script_path;
$ets_outter->gen_time = mymicrotime( $start, 5 );
$ets_outter->welcome[] = $user->getWelcomeTags();

printt($ets_outter, 	skin_header);
printt($ets, 			$USESKIN );
printt($ets_outter, 	skin_footer);

?>