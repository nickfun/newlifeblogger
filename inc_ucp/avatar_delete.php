<?PHP

/**
 * =======================================
 *		D E L E T E   A V A T A R
 * =======================================
 */

if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}

if( isset( $_GET['id'] ) ) {
	$w = array(
		'owner_id' => $user->id,
		'avatar_id' => $_GET['id']
	);
	remove_avatar( $db, $w );
}
jsRedirect('usercp.php?action=avatars');

?>