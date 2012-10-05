<?PHP

/**
 * =======================================
 *		E D I T   T E M P L A T E
 * =======================================
 */

if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}

$USESKIN = skin_basic;
$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-usercp'];
$ets_outter->page_title = $l['title-template'];
$ets->page_body = "";

// can we change our template?
if( !$user->isAllowed('tpl_change') && !$user->isAllowed('tpl_custom') ) {
	$ets->page_body = $l['denied'];
	break;
}
if( !isset( $_GET['sub'] ) ) {
	// can we edit our templates?
	if( $user->isAllowed('tpl_custom') ) {
		// ask user which template to edit.
		$body = $l['ucp-choose-template'];
		$body = str_replace("%BLOG%", script_path . 'usercp.php?action=template&sub=blog', $body);
		$body = str_replace("%FRIENDS%", script_path . 'usercp.php?action=template&sub=friends', $body);
		$body = str_replace("%PROFILE%", script_path . 'usercp.php?action=template&sub=profile', $body);
		$ets->page_body .= $body;
	}
	// use pre-made templates?
	if( $user->isAllowed('tpl_change') ) {
		if( isset( $_POST['template'] ) && nlb_user::templateExists( $_POST['template'] ) ) {
			// Set the template
			$user->setTemplateSource( $_POST['template'] , $config->get('home_text') );
			$ets->page_body = $l['goodedit'];
		} else {
			$ets->page_body .= $l['ucp-tpl-change'];
			// direct from register.php:
			// build template preview <select> data
			$dir = dir( template_folder );
			while($file = $dir->read()) {
				if( strtolower( getFileExt($file) ) == 'gif') {
					$preview[] = $file;
				}
			}
			$dir->close();
			$st = '<select name="template" onchange="document.images.temlpatePreview.src = \'templates/\' + this[this.selectedIndex].value + \'.gif\';">';
			$st .= "\n";
			foreach( $preview as $img ) {
				$name 	= str_replace('_', ' ', $img);
				$name 	= substr($name, 0, -4);	// to remove .gif
				$img 	= substr($img, 0, -4);
				$st 	.= '<option value="' . $img . '">' . $name . '</option>' . "\n";
			}
			$st .= "\n</select>\n";
			$st .= '<br /><img name="temlpatePreview" src="./templates/' . $preview[0] . '" />';
			
			$ets->page_body .= '<form method="post" action="usercp.php?action=template">';
			$ets->page_body .= $st;
			$ets->page_body .= '<br><input type="submit" value="' . $l['submit'] . '"></form>';
		}
	}
	
} else {
	$type = $_GET['sub'];
	// allowed to do this?
	if( $user->isAllowed('tpl_custom') ) {
		// are we editing the template, or updating?
		if( isset( $_POST['tpl-body'] ) ) {
			// update to db
			$body = slash_if_needed( $_POST['tpl-body'] );
			$time = time();
			$db->query('UPDATE ' . db_source . '
			SET ' . $type . ' = "' . $body . '",
			' . $type . '_updated = "' . $time . '"
			WHERE owner_id = "' . $user->id . '"
			LIMIT 1;');
			$ets->page_body = $l['goodedit'];
		} else {
			// let user edit template
			$body = $db->getArray('SELECT ' . $type . ' FROM ' . db_source . ' WHERE owner_id = "' . $user->id . '";');
			$body = stripslashes( $body[$type] );
			$ets->page_body = $l['ucp-tpl-edit-' . $type] . '<p>
			<form method="post" action="' . script_path . 'usercp.php?action=template&sub=' . $type . '">
			<textarea name="tpl-body" class="nlb_edit_template">' . $body . '</textarea><br>
			<input type="submit" value="' . $l['submit'] . '">
			</form></p>
			<p><a href="usercp.php?action=template">' . $l['back'] . '</a></p>';
		}
	} else {
		$ets->page_body = $l['denied'];
	}
}

?>