<?PHP

/**
 * =======================================
 * 		E D I T   S M I L E
 * =======================================
 */
 
if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}

$text = new text( $_POST, array('smile_id', 'image', 'code', 'desc'), array("delete") );
$text->validate();
if( $text->is_missing_required ) {
	jsRedirect("admincp.php?action=smiles");
	die();
}
$text->makeClean("slash_if_needed");
$c = $text->clean;
// delete or update?
if( empty( $c['delete'] ) ) {
	$db->query("UPDATE `" . db_smiles . "`
	SET `code` = '" . $c['code'] . "', 
	`image` = '" . $c['image'] . "', 
	`desc` = '" . $c['desc'] . "' 
	WHERE `smile_id` = " . $c['smile_id'] . "
	LIMIT 1;");
} else {
	$db->query("DELETE FROM " . db_smiles . "
	WHERE `smile_id` = " . $c['smile_id'] . "
	LIMIT 1;");
}
// done here, back to manager...
jsRedirect("admincp.php?action=smiles");

?>