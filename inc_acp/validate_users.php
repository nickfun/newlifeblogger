<?PHP

/**
 * =======================================
 * 		V A L I D A T E   U S E R S
 * =======================================
 */

if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}

$USESKIN = skin_basic;
$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-acp-validate'];
$ets_outter->page_title = $l['title-acp-validate'];
$dateformat = $config->get('memlist_date_format');

if( !isset($_POST['users']) ) {
	
	// List un-validated users
	
	$ets->page_body = $l['acp-val-users']
	. '<form method="post" action="' . script_path 
	. 'admincp.php?action=validate_users">';
	
	$users = $db->getAllArray('SELECT v.validate_id, u.user_id, u.username '
	. 'FROM ' . db_validate . ' as v, ' . db_users . ' as u '
	. 'WHERE v.owner_id = u.user_id '
	. 'ORDER BY v.date DESC;');
	
	foreach( $users as $row ) {
		$ets->page_body .= '<input type="checkbox" name="users[]" value="'
		. $row['user_id'] . '"> ' . $row['username'] . "<br />\n";
	}
	
	$ets->page_body .= '<br /><input type="submit" value="'
	. $l['submit'] . '"> </form>';
	
} else {
	
	// process the users.
	
	$users = $_POST['users'];
	
	if( is_array($users) && !empty($users) ) {
		// good data.
		
		$ids = implode(', ', $users);
	
		// delete the rows in db_validate
		$db->query('DELETE FROM ' . db_validate
		. ' WHERE owner_id IN(' . $ids . ');');
		
		// set the users to be valid so they can log in.
		$db->query('UPDATE ' . db_users . ' SET valid=1 '
		. 'WHERE user_id IN(' . $ids . ');');
		
		$ets->page_body = $l['acp-val-good'];
		
	} else {
		// not good data.
		jsRedirect(script_path . 'admincp.php?action=validate_users');
	}
	
}
		
?>