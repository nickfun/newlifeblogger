<?PHP

/**
 * =======================================
 *		E D I T   U S E R   (part 1)
 * =======================================
 */

if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}

// just prompt for username
$USESKIN = skin_basic;
$ets->page_body = '';
$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-admincp'];
$ets_outter->page_title = $l['title-edituser'];
$badname = false;

if( isset($_POST['name']) ) {
	$getid = $db->getArray('SELECT user_id FROM ' . db_users . ' WHERE username="' . $_POST['name'] . '" limit 1;');
	if( empty( $getid ) ) {
		$badname = true;
	} else {
		jsRedirect('admincp.php?action=edit_user_id&id=' . $getid['user_id'] );
	}
}

if( $badname ) {
	$ets->page_body .= '<div class="error">' . $l['acp-bad-username'] . '</div>';
}

if( !isset($_POST['name']) || $badname ) {
	$ets->page_body .= '<form method="post" action="admincp.php?action=edit_user">
	' . $l['username:'] . '<input type="text" name="name"><br>
	<input type="submit" value="' . $l['submit'] . '"></form>';
}

?>