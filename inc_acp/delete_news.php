<?PHP

/**
 * =======================================
 *		D E L E T E   N E W S
 * =======================================
 */
 
if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}

if( !isset($_GET['id']) ) {
	jsRedirect("admincp.php");
}
$ets_outter->main_title = $config->get('site_name') . ": " . $l['acp-editnews'];
$ets_outter->page_title = $l['acp-editnews'];
$id = $_GET['id'];
$USESKIN = skin_basic;
$ets->page_body = "";
if( !isset($_POST['confirm']) ) {
	$ets->page_body .= $l['confirm-delete'] . '
	<p><form method="post" action="admincp.php?action=delete_news&id=' . $id . '">
	<input type="hidden" name="confirm" value="Delete it now!">
	<input type="submit" value="' . $l['yes'] . '"></form></p>
	<p><form method="post" action="admincp.php">
	<input type="submit" value="' . $l['no'] . '">
	</form></p>';
} else {
	// remove comments & news
	$b->delete( $id );
	$ets->page_body .= $l['goodedit'];
}

?>