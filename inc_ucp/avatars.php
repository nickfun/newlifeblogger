<?PHP

/**
 * =======================================
 *		A V A T A R S
 * =======================================
 */

if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}
 
$USESKIN = skin_basic;
$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-usercp'];
$ets_outter->page_title = $l['title-avatars'];
$ets->page_body = '';

if( isset($_GET['ecode']) ) {
	$ets->page_body = '<div class="error">' . $l['ucp-av-upload-error'];
	$ets->page_body .= $l['ucp-av-ecode-' . $_GET['ecode'] ] . '</div>';
}

// can we do this?
if( $user->isAllowed('av_use') ) {
	
	/**
	 * Avatar Types:
	 * 1 => Default
	 * 2 => Friends
	 * 3 => Comments
	 */
	
	// get list of users avatars
	$tmp = $db->query('SELECT * FROM ' . db_avatars . ' WHERE owner_id=' . $user->id . ' ORDER BY type ASC');
	$av = array();
	while( $row = mysql_fetch_assoc( $tmp ) ) {
		$av[] = $row;
	}
	
	$select_av_type = '<select name="type">';
	for( $i = 1; $i <= 3; $i++ ) {
		$select_av_type .= '<option value="' . $i . '">';
		$select_av_type .= $l['ucp-av-type-' . $i ] . "</option>\n";
	}
	$select_av_type .= '</select>';
	
	// build array table
	if( !empty( $av ) ) {
		$ets->page_body .= '<table class="nlb_table"><tr>
		<th>' . $l['ucp-av-type'] . '</th>
		<th>' . $l['ucp-av-image'] . '</th>
		<th>' . $l['delete'] . '</th></tr>';
		
		foreach( $av as $a ) {
			if( $a['isCustom'] == 1 ) {
				$img = 'avatars/' . $a['file'];
			} else {
				$img = 'avatars/default/' . $a['file'];
			}
			$ets->page_body .= '<tr><td>' . $l['ucp-av-type-' . $a['type'] ] . '</td>
			<td><img src="' . $img . '"></td>
			<td><a href="usercp.php?action=avatar_delete&id=' . $a['avatar_id'] . '">Delete</a>
			</td></tr>';
		}
		
		$ets->page_body .= '</table>';
	} else {
		$ets->page_body .= $l['ucp-av-none'];
	}
	
	$ets->page_body .= $l['ucp-av-describe-types'];
	
	// form for adding default avatar.
	$ext = $config->get('avatar_types');
	$ext = explode(',', strtolower($ext));			
	
	$dir = dir('./avatars/default');
	while($file = $dir->read()) {
		$fileext = getFileExt( $file );
		if( in_array( $fileext, $ext ) ) {
			$preview[] = $file;
		}
	}
	$dir->close();
	$select_av = '<select name="avatar" onchange="document.images.avatarPreview.src = \'avatars/default/\' + this[this.selectedIndex].value;">';
	foreach( $preview as $img ) {
		$name = str_replace('_', ' ', $img);
		$name = substr($name, 0, -4);
		$select_av .= '<option value="' . $img . '">' . $name . "</option>\n";
	}
	$select_av .= '</select>';

	$ets->page_body .= '<p>' . $l['ucp-av-add-default'] . '<br>
	<form method="post" action="usercp.php?action=avatar_default">
	<table><tr>
	<td><img name="avatarPreview" src="./avatars/default/' . $preview[0] . '" /></td>
	<td>' . $select_av . ' <br>' . 
	$select_av_type . '<br>
	<input type="submit" value="' . $l['submit'] . '">
	</td></tr></table></form>';
	
	if( $user->isAllowed('av_up') ) {
		// form to upload avatar
		
		$info = $l['ucp-av-restrict'];
		$info = str_replace("%HEIGHT%", $config->get('avatar_height'), $info);
		$info = str_replace("%WIDTH%", $config->get('avatar_width'), $info);
		$info = str_replace("%SIZE%", $config->get('avatar_size'), $info);
		
		$ets->page_body .= '<p>' . $l['ucp-av-upload'];
		$ets->page_body .= '
		<form enctype="multipart/form-data" method="post" action="usercp.php?action=avatar_upload">
		<input type="hidden" name="MAX_FILE_SIZE" value="' . $config->get('avatar_size') * 1000 . '">
		<input type="file" name="avatar"><br>' .
		$select_av_type . '<br><input type="submit" value="' . $l['submit'] . '">
		</form><br>' . $info;
	}
	
} else {
	$ets->page_body = $l['denied'];
}

?>