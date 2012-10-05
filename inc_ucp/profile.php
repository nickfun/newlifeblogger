<?PHP

/**
 * =======================================
 *		E D I T   P R O F I L E
 * =======================================
 */

if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}

$USESKIN = skin_basic;
$ets->page_body = "";
$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-usercp'];
$ets_outter->page_title = $l['title-profile'];
$text = new text( 
	$_POST,
	array('email', 'date_format', 'perpage', 'timezone'),
	array('custom', 'gender', 'birthday', 'bio')
);
$text->validate();
$text->makeClean('slash_if_needed', 'trim');
$baddata = false;
$problems = array();

if( !empty( $_POST ) ) {
	// process data
	if( $text->is_missing_required ) {
		$baddata = true;
	}
	$c = $text->clean;
	// good email?
	if( !pear_check_email( $c['email'] ) ) {
		$baddata = true;
		$problems[] = $l['reg-bademail'];
	}
	// blogs per page
	if( abs( $c['perpage'] ) == 0 ) {
		$c['perpage'] = 10;
	}
	// now we can update if nothing went wrong.
	if( !$baddata ) {
		// check birthday
		if( empty($c['birthday']) || ( $bday = strtotime($c['birthday']) ) == -1 ) {
			$c['birthday'] = "";
		} else {
			$c['birthday'] = $bday;
		}
		// timezone
		$c['timezone'] -= 13;
		// did the email change?
		$VALIDATE = false;
		if( $c['email'] != $user->get('email') ) {
			$VALIDATE = true;
		}
		foreach( $c as $key => $val ) {
			$user->set( $key, $val );
		}
		$user->updateDB();
		$ets->page_body .= $l['goodedit'];
		if( $config->get('validate_email') == "true" && $VALIDATE ) {
			$user->validateEmail( $config );
			$ets->page_body .= $l['ucp-revalidate'];
			$user->logout();
		}
		
	}
}

if( empty( $_POST ) || $baddata ) {
	if( !empty($_POST) && $text->is_missing_required ) {
		$baddata = true;
		foreach( $text->missing_fields as $miss ) {
			$problems[] = $l['missing-field'] . $miss;
		}
	}
	
	// display problems if they exist
	if( $baddata ) {
		$ets->page_body .= '<div class="error">' . $l['data-problems'] . '<br />';
		foreach( $problems as $p ) {
			$ets->page_body .= '<li>' . $p . "</li>\n";
		}
		$ets->page_body .= '</div><br>';
	}
	
	// use what data?
	if( empty( $_POST ) ) {
		$merge = $user->data;
		$merge['timezone'] += 13;
	} else {
		$merge = $_POST;
	}
	
	// build form
	$form->action = 'usercp.php?action=profile';
	$form->method = 'post';
	$form->class = 'nlb_form';
	$table->class = 'nlb_table';
	$table->width = "100%";
	
	$i=0;
	$f[$i]->name = 'email';
	$f[$i]->type = 'text';
	$f[$i]->desc = $l['field-email'];
	
	$i++;
	$f[$i]->name = 'date_format';
	$f[$i]->type = 'text';
	$f[$i]->desc = $l['field-date_format'];
	
	$i++;
	$f[$i]->name = 'perpage';
	$f[$i]->type = 'text';
	$f[$i]->desc = $l['field-perpage'];
	
	$i++;
	$f[$i]->name = 'timezone';
	$f[$i]->type = 'select';
	$f[$i]->value = build_timezone_list( $config->get('server_timezone') );
	$f[$i]->desc = $l['reg-timezone'];
	
	$i++;
	$f[$i]->name = 'custom';
	$f[$i]->type = 'text';
	$f[$i]->desc = $l['field-custom'];
	
	$i++;
	$f[$i]->name = 'gender';
	$f[$i]->type = 'select';
	$f[$i]->desc = $l['field-gender'];
	$f[$i]->value = array(
		0	=> $l['na'],
		1	=> $l['gender-male'],
		2	=> $l['gender-female']
	);
	
	$i++;
	$f[$i]->name = 'birthday';
	$f[$i]->type = 'text';
	$f[$i]->desc = $l['field-birthday'];
	$f[$i]->call = 'bday_format';
	
	$i++;
	$f[$i]->name = 'bio';
	$f[$i]->type = 'textarea';
	$f[$i]->desc = $l['field-bio'];
	
	$i++;
	$f[$i]->name = 'submit';
	$f[$i]->type = 'submit';
	$f[$i]->desc = $l['submit'];
	$f[$i]->value = $l['submit'];
	
	$ets->page_body .= build_form( $f, $form, $table, $merge );
	
}

?>