<?PHP

/**
 * =======================================
 *		D E L E T E   B L O G
 * =======================================
 */

if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}
 
$USESKIN = skin_basic;
$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-usercp'];
$ets_outter->page_title = $l['title-deleteblog'];

if( !isset( $_GET['id'] ) ) { 
	jsRedirect('index.php');
}
$id = $_GET['id'];

// make sure we are the author
$row = $db->getArray('SELECT author_id FROM ' . db_blogs . ' WHERE blog_id = ' . $id . ';');
if( $row['author_id'] != $user->id ) {
	jsRedirect('index.php');
}

if( !isset($_POST['confirm']) ) {
	$ets->page_body .= $l['confirm-delete'] . '
	<p><form method="post" action="usercp.php?action=delete_blog&id=' . $id . '">
	<input type="hidden" name="confirm" value="Delete it now!">
	<input type="submit" value="' . $l['yes'] . '"></form></p>
	<p><form method="post" action="admincp.php">
	<input type="submit" value="' . $l['no'] . '">
	</form></p>';
} else {
	// remove blog & comments
	$b->delete( $id );
	// update blog count
	$user->recountBlogs();
	$user->updateDB();
	$ets->page_body .= $l['goodedit'];
}
	
?>