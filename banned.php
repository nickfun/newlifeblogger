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

require_once 'ets.php';					// Sweet template library

$start = mymicrotime();

$db = new sqldb2( $DB_CONFIG );
$config = new nlb_config( $db );
$user = new nlb_user( $db );

//$user->checklogin();		DONT CHECK FOR LOGIN ON THIS PAGE!

include $config->langfile();		// include lang file

if( !isset( $_GET['id'] ) ) {
	jsRedirect('index.php');
}

$id = addslashes($_GET['id']);

$row = $db->getArray('SELECT reason, expires FROM ' . db_banned . ' WHERE banned_id="' . $id . '";');
if( empty( $row ) ) {
	die("empty");
}

$body = $l['banned_msg'];
$body = str_replace("%REASON%", $row['reason'], $body);
$body = str_replace("%DATE%", date('r', $row['expires']), $body);

$ets->page_body = $body;

$ets_outter->sitenav = buildMainNav( $l, $user );

$ets_outter->query_count = $db->getquerycount();
$ets_outter->script_path = script_path;
$ets_outter->gen_time = mymicrotime( $start, 5 );

$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-arebanned'];
$ets_outter->page_title = $l['title-arebanned'];

$ets_outter->welcome[] = $user->getWelcomeTags();

printt($ets_outter, 	skin_header);
printt($ets, 			skin_basic);
$ets_outter->gen_time = mymicrotime( $start, 5 );
printt($ets_outter, 	skin_footer);

?>