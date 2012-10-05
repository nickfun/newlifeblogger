<?PHP

/**
 * =======================================
 * 		E D I T   B L O G   L I S T
 * =======================================
 */
 
if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}

$USESKIN = skin_blog_list;
$ets->list = array();

$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-usercp'];
$ets_outter->page_title = $l['title-editblog'];

$dateformat = $config->get('memlist_date_format');

// page setup
$page = 0;
if( isset($_GET['page']) ) {
	$page = addslashes($_GET['page']);
}
$perpage = 15;
$page_start = ($page * $perpage);
$limit = $page_start . ', ' . $perpage;

// fetch items from db...
$list = $db->getAllArray('SELECT blog_id as id, subject, date, access 
FROM ' . db_blogs . ' 
WHERE author_id=' . $user->id . ' AND access != ' . access_news . ' 
ORDER BY date DESC 
LIMIT ' . $limit . ';');
foreach( $list as $item ) {
	if( empty( $item['subject'] ) ) {
		$row->subject = '<i>No Subject</i>';
	} else {
		$row->subject = stripslashes( $item['subject'] );
	}
	
	if( $item['access'] == access_private ) {
		$row->subject .= ' <i>(' . $l['access-private'] . ')</i>';
	} elseif( $item['access'] == access_friendsonly ) {
		$row->subject .= ' (' . $l['access-friends'] . ')';
	}
	
	$row->date = date( $dateformat, $item['date'] );
	$row->url_edit = script_path . 'usercp.php?action=edit_blog&id=' . $item['id'];
	$row->url_delete = script_path . 'usercp.php?action=delete_blog&id=' . $item['id'];
	$row->url_view = build_link('blog.php', array('id'=>$item['id']));
	$ets->list[] = $row;
}

// setup page tags
if( $page > 0 ) {
	$ets->url_page_prev = script_path . 'usercp.php?action=edit_list&page=' . ($page-1);
}
// next page?
$c = $db->getArray('SELECT count(blog_id) as c FROM ' . db_blogs . ' WHERE author_id = ' . $user->id . ' AND access != ' . access_news . ';');
if( $c['c'] > ($page_start + $perpage) ) {
	// there are more pages...
	$ets->url_page_next = script_path . 'usercp.php?action=edit_list&page=' . ($page+1);
}

?>