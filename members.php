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
require_once 'system/ets_file.php';

require_once 'system/sqldb2.class.php';
require_once 'system/nlb_config.class.php';
require_once 'system/nlb_blog.class.php';
require_once 'system/nlb_user.class.php';
require_once 'ets.php';

$timer_start = mymicrotime();

$db = new sqldb2($DB_CONFIG);
$user = new nlb_user($db);
$config = new nlb_config($db);
include $config->langfile();
$user->checkLogin();

$b = new nlb_blog( $db );

if( $user->isLogedIn ) {
	$b->setDateOffset( $config->get('server_timezone'), $user->get('timezone') );
}

$perpage = $config->get('memlist_per_page');
$date_format = $config->get('memlist_date_format');

// Not really path info anymore...
$_PATH = fetch_url_data();

$sort = 'username';
$allowed_sort = array('username', 'blog_count', 'registered');
if( isset($_PATH['sort']) && in_array($_PATH['sort'], $allowed_sort) ) {
	$sort = $_PATH['sort'];
}
$way = 'asc';
if( isset( $_PATH['way'] ) && ($_PATH['way'] == 'asc' || $_PATH['way'] == 'desc' ) ) {
	$way = $_PATH['way'];
}

$page = 0;
if( isset($_PATH['page']) ) {
	$page = $_PATH['page'];
}
$start = $page * $perpage;

// get and process a page of members
$i = 0;
$all = $db->getAllArray("SELECT user_id, username, blog_count, registered FROM " . db_users . " WHERE valid = 1 ORDER BY $sort $way LIMIT $start, $perpage ;");
foreach( $all as $row ) {
	stripslashes_array( $row );
	$ets->members[$i]->username 	= $row['username'];
	$ets->members[$i]->blog_count	= $row['blog_count'];
	$ets->members[$i]->url_blogs	= build_link('blog.php', array('user'=>$row['user_id']));
	$ets->members[$i]->url_profile  = build_link('profile.php', array('user'=>$row['user_id']));
	$ets->members[$i]->registered   = date( $date_format, $row['registered'] );
	$i++;
}

// setup next/prev links
$total = $db->getArray("SELECT count(*) as c FROM " . db_users . ";");
$total = $total['c'];

if( $page > 0 ) {
	$ets->url_page_prev = build_link('members.php', array('page'=>($page-1), 'sort'=>$sort, 'way'=>$way));
}
if( $total > ($perpage * ($page+1)) ) {
	$ets->url_page_next = build_link('members.php', array('page'=>($page+1), 'sort'=>$sort, 'way'=>$way));
}

// build sort links
$i = 0;
foreach( $allowed_sort as $item ) {
	$ets->sort[$i]->item 	= $l['mem-sort-' . $item ];
	$ets->sort[$i]->asc 	= $l['mem-asc'];
	$ets->sort[$i]->desc 	= $l['mem-desc'];
	$ets->sort[$i]->url_asc	= build_link('members.php', array('sort'=>$item, 'way'=>'asc'));
	$ets->sort[$i]->url_desc = build_link('members.php', array('sort'=>$item, 'way'=>'desc'));
	$i++;
}

$ets_outter->recent_blogs = $b->getRecent( $config );
$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-memlist'];
$ets_outter->page_title = $l['title-memlist'];
$ets_outter->sitenav = buildMainNav( $l, $user );
$ets_outter->query_count = $db->getquerycount();
$ets_outter->script_path = script_path;
$ets_outter->gen_time = mymicrotime( $timer_start, 5 );
$ets_outter->welcome[] = $user->getWelcomeTags();

printt( $ets_outter, 	skin_header );
printt( $ets,			skin_members );
printt( $ets_outter,	skin_footer );

?>