<?PHP

/**
 * =======================================
 * 		D E L E T E   A R T I C L E
 * =======================================
 */
 
if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}

if( !isset( $_GET['id'] ) ) {
	jsRedirect('admincp.php?action=list_article');
}
$USESKIN = skin_basic;
$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-config'];
$ets_outter->page_title = $l['title-art-delete'];

if( !isset($_POST['confirm']) ) {
	$ets->page_body = $l['confirm-delete'] . '
	<p><form method="post" action="admincp.php?action=delete_article&id=' . $_GET['id'] . '">
	<input type="hidden" name="confirm" value="Delete it now!">
	<input type="submit" value="' . $l['yes'] . '"></form></p>
	<p><form method="post" action="admincp.php">
	<input type="submit" value="' . $l['no'] . '">
	</form></p>';
} else {
	// remove comments & news
	$db->query('DELETE FROM ' . db_articles . ' WHERE article_id="' . $_GET['id'] . '" LIMIT 1;');
	$ets->page_body = $l['goodedit'];
}

?>