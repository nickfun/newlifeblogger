<?PHP

/**
 * =======================================
 * 		E D I T   A R T I C L E   L I S T
 * =======================================
 */

if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}

$USESKIN = skin_blog_list;
$ets->list = array();
$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-art-edit'];
$ets_outter->page_title = $l['title-art-edit'];
$dateformat = $config->get('memlist_date_format');
// fetch items from db...

// pages?
$per_page = 15;
$page = 0;
if( isset($_GET['page']) ) {
	$page = $_GET['page'];
}
$page_start = $page * $per_page;
$limit = $page_start . ', ' . $per_page;

//$list = $db->getAllArray( "SELECT blog_id as id, subject, date FROM " . db_blogs . " WHERE author_id='" . $user->id . "' AND access != " . access_news . " ORDER BY date DESC LIMIT 0, 10;" );
$list = $db->getAllArray( 'SELECT article_id as id, subject, date FROM ' . db_articles . ' WHERE author_id=' . $user->id . ' ORDER BY date DESC LIMIT ' . $limit . ';');
foreach( $list as $item ) {
	if( empty( $item['subject'] ) ) {
		$row->subject = '<i>No Subject</i>';
	} else {
		$row->subject = stripslashes( $item['subject'] );
	}
	$row->date = date( $dateformat, $item['date'] );
	$row->url_edit = script_path . 'admincp.php?action=edit_article&id=' . $item['id'];
	$row->url_delete = script_path . 'admincp.php?action=delete_article&id=' . $item['id'];
	$row->url_view = build_link('index.php', array('action'=>'article', 'id'=>$item['id']));
	$ets->list[] = $row;
}

// setup page tags
if( $page > 0 ) {
	$ets->url_page_prev = script_path . 'admincp.php?action=list_article&page=' . ($page-1);
}
// next page?
$c = $db->getArray('SELECT count(article_id) as c FROM ' . db_articles . ' WHERE author_id = ' . $user->id . ';');
if( $c['c'] > ($page_start + $per_page) ) {
	// there are more pages...
	$ets->url_page_next = script_path . 'admincp.php?action=list_article&page=' . ($page+1);
}

?>