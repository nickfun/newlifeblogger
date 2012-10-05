<?PHP

/**
 * =======================================
 *		E D I T   U S E R
 * =======================================
 */

if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}

$ets->page_body = '';
$baddata = false;

if( !isset($_GET['id']) ) {
	jsRedirect('admincp.php?action=edit_user');
} else {
	$USERID = $_GET['id'];
	$edituser = new nlb_user( $db, $USERID );			
}

$text = new text(
	$_POST,
	array('username', 'email', 'blog_count', 'timezone', 'access'),
	array('bio', 'custom')
);
$text->validate();
$text->makeClean( 'trim', 'slash_if_needed' );

if( !empty($_POST) ) {
	// check data
	if( $text->is_missing_required ) {
		$baddata = true;
	} else {
		$c = $text->clean;
		$c['timezone'] -= 13;
		
		foreach( $c as $key => $value ) {
			$edituser->set($key, $value);
		}
		
		$per = '';
		foreach( $c['access'] as $key => $val ) {
			$per .= $key . ':';
		}
		$per = substr($per, 0, -1);
		
		$edituser->setPermissions( explode(':', $per) );
		
		$edituser->updateDb();
		
		$ets->page_body = $l['goodedit'];
	}
}

// decide what data to use.
if( empty($_POST) ) {
	$merge = $db->getArray('SELECT * FROM ' . db_users . ' WHERE user_id=' . $USERID );
} else {
	$merge = $_POST;
}
		
if( empty($_POST) || $baddata ) {

	if( $baddata ) {
		$ets->page_body .= '<div class="error">' . $l['data-problems'] . '<br />';
		foreach( $text->missing_fields as $f ) {
			$ets->page_body .= '<li>' . $l['missing-field'] . $f . "</li>\n";
		}
		$ets->page_body .= '</div><br>';
	}
	
	// build form
	$form->action = 'admincp.php?action=edit_user_id&id=' . $USERID;
	$form->method = 'post';
	$form->class = 'nlb_config_form';
	$table->class = 'nlb_table';
	$table->width = "100%";
	
	$f = array();			
	
	$i = 0;			
	$f[$i]->name = 'username';
	$f[$i]->type = 'text';
	$f[$i]->desc = $l['edit-user-username'];
	
	$i++;
	$f[$i]->name = 'email';
	$f[$i]->type = 'text';
	$f[$i]->desc = $l['edit-user-email'];
	
	$i++;
	$f[$i]->name = 'blog_count';
	$f[$i]->type = 'text';
	$f[$i]->desc = $l['edit-user-blog_count'];
	
	$i++;
	$f[$i]->name = 'timezone';
	$f[$i]->type = 'select';
	$f[$i]->value = build_timezone_list( $config->get('server_timezone') );
	$f[$i]->desc = $l['reg-timezone'];
	if( empty($_POST) ) {
		$merge['timezone'] += 13;
	}
	
	$i++;
	$f[$i]->name = 'bio';
	$f[$i]->type = 'textarea';
	$f[$i]->desc = $l['edit-user-bio'];
	
	$i++;
	$f[$i]->name = 'custom';
	$f[$i]->type = 'text';
	$f[$i]->desc = $l['edit-user-custom'];
	
	// build access checkbox's
	$j = 0;
	foreach( $USER_PERMISSIONS as $official ) {
		$per[$j]['name'] = 'access[' . $official . ']';
		$per[$j]['desc'] = $l['acp-access-' . $official];
		$per[$j]['value'] = 'x';
		if( empty($_POST) ) {
			if( $edituser->isAllowed( $official ) ) {
				$merge['access[' . $official . ']'] = 'x';
			}
		}
		$j++;
	}
	
	$i++;
	$f[$i]->desc = 'access';
	$f[$i]->type = 'checkboxes';
	$f[$i]->value = $per;
	
	$i++;
	$f[$i]->type = 'submit';
	$f[$i]->value = $l['submit'];			
	
	$ets->page_body .= build_form( $f, $form, $table, $merge );
}

$USESKIN = skin_basic;
$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-admincp'];
$ets_outter->page_title = $l['title-edituser'];

?>