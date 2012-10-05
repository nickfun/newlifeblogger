<?PHP

/**
 * =======================================
 *		P R E   A V A T A R
 * =======================================
 */

if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}

if( empty($_POST['type']) || empty($_POST['avatar']) ) {
	jsRedirect('usercp.php?action=avatars');
}

$w = array(
	'owner_id' => $user->id,
	'type' => $_POST['type']
);

remove_avatar( $db, $w );

$id = $user->id;
$file = $_POST['avatar'];
$type = $_POST['type'];
$db->query('INSERT INTO ' . db_avatars . " VALUES (
'', '$id', '$file', '0', '$type'
);");

jsRedirect('usercp.php?action=avatars');

?>