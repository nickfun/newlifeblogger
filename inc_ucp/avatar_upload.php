<?PHP

/**
 * =======================================
 *		U P L O A D   A V A T A R
 * =======================================
 */

if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}

if( !$user->isAllowed('av_up') ) {
	jsRedirect('usercp.php?action=avatars');
}

if( !isset($_POST['type']) || !isset($_FILES['avatar']) ) {
	jsRedirect('usercp.php?action=avatars');
}

$tmp = $_FILES['avatar']['tmp_name'];
$ecode = 0;

// check filesize
if( filesize($tmp) > ($config->get('avatar_size') * 1000) ) {
	$ecode = 1;
}

// check height & width
$size = getimagesize($tmp);
if( $size[0] > $config->get('avatar_height') ) {
	$ecode = 2;
}

if( $size[1] > $config->get('avatar_width') ) {
	$ecode = 3;
}

// check filetype
$ext = getFileExt($_FILES['avatar']['name']);
$ext = strtolower($ext);
$validExt = strtolower($config->get('avatar_types'));
$validExt = explode(',', $validExt);
if( !in_array( $ext, $validExt ) ) {
	$ecode = 4;
}

if( $ecode > 0 ) {
	unlink( $tmp );
	jsRedirect('usercp.php?action=avatars&ecode=' . $ecode);
}

// everything is good, add the avatar
		$file = time() . '-' . $user->id . '.' . $ext;
move_uploaded_file( $tmp, './avatars/' . $file );
$id = $user->id;
$type = $_POST['type'];
remove_avatar( $db, array('owner_id' => $user->id, 'type' => $type) );

$db->query('INSERT INTO ' . db_avatars . " VALUES (
'', '$id', '$file', '1', '$type'
);");

jsRedirect('usercp.php?action=avatars');

?>