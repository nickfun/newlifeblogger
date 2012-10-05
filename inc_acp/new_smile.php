<?PHP

/**
 * =======================================
 * 		A D D   S M I L E
 * =======================================
 */
 
if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}

$text = new text( $_POST, array('image', 'code', 'desc') );
$text->validate();
if( $text->is_missing_required ) {
	jsRedirect("admincp.php?action=smiles");
	die();
}
$text->makeClean('slash_if_needed');
$db->query("INSERT INTO `" . db_smiles . "` 
(`smile_id`, `code`, `image`, `desc`)
VALUES ('', '" . $text->clean['code'] . "', '" . $text->clean['image'] . "', '" . $text->clean['desc'] . "');");
// send back to manager...
jsRedirect("admincp.php?action=smiles");

?>