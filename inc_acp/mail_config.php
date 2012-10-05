<?PHP

/**
 * =======================================
 *		M A I L   C O N F I G
 * =======================================
 */

if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}

// grab mail config...
$result = $db->getAllArray(" # Getting mail config
SELECT name, value FROM " . db_config . " 
WHERE name='mail_type' OR 
name='mail_from' OR
name='smtp_host' OR
name='smtp_username' OR
name='smtp_password' OR
name='sendmail_path';");

// load into a more managable array
$info = array();
foreach( $result as $row ) {
	if( strtolower($row['value']) == 'smtp_auth' ) {
		$row['value'] = str_replace('_', '-', $row['value']);
	}
	$info[ $row['name'] ] = $row['value'];
}

// other options
$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-config'];
$ets_outter->page_title = $l['acp-nav-mail'];
$USESKIN = skin_basic;
$ets->page_body	= "";
$baddata = false;
$problems = array();
$text = new text(
	$_POST,
	array('mail_type'),
	array('mail_from', 'smtp_host', 'smtp_username', 'smtp_password', 'sendmail_path')
);

// process data?
if( !empty( $_POST ) ) {
	
	$text->validate();
	$text->makeClean('slash_if_needed', 'trim');
	$c = $text->clean;
	
	if( $text->is_missing_required ) {
		$baddata = true;
	}
	
	if( !in_array( strtolower($c['mail_type']), array('none', 'mail', 'sendmail', 'smtp', 'smtp-auth') ) ) {
		$baddata = true;
		$problems[] = $l['acp-bad-mail-type'];
	}
	
	if( $c['mail_type'] != 'none' && empty( $c['mail_from'] ) ) {
		$baddata = true;
		$problems[] = $l['acp-mail-from'];
	}
	
	switch( strtolower( $c['mail_type'] ) ) {
		case 'smtp-auth':
			if( empty( $c['smtp_host'] ) || empty( $c['smtp_username'] ) || empty( $c['smtp_password'] ) ) {
				$baddata = true;
				$problems[] = $l['acp-missing-smtp'];
			} else {
				if( !$baddata ) {
					// put info into db.
					$db->query('UPDATE ' . db_config . ' SET value = "smtp_auth" WHERE name = "mail_type"; ');
					$db->query('UPDATE ' . db_config . ' SET value = "' . $c['mail_from'] . '" WHERE name = "mail_from"; ');
					$db->query('UPDATE ' . db_config . ' SET value = "' . $c['smtp_host'] . '" WHERE name = "smtp_host"; ');
					$db->query('UPDATE ' . db_config . ' SET value = "' . $c['smtp_username'] . '" WHERE name = "smtp_username"; ');
					$db->query('UPDATE ' . db_config . ' SET value = "' . $c['smtp_password'] . '" WHERE name = "smtp_password"; ');
					
					$ets->page_body .= $l['goodedit'];
				}
			}
		break;
		
		case 'smtp':
			if( empty( $c['smtp_host'] ) ) {
				$baddata = true;
				$problems[] = $l['acp-smtp-host'];
			}
			if( !$baddata ) {
				$db->query('UPDATE ' . db_config . ' SET value = "smtp" WHERE name = "mail_type"; ');
				$db->query('UPDATE ' . db_config . ' SET value = "' . $c['mail_from'] . '" WHERE name = "mail_from"; ');
				$db->query('UPDATE ' . db_config . ' SET value = "' . $c['smtp_host'] . '" WHERE name = "smtp_host"; ');
				
				$ets->page_body .= $l['goodedit'];
			}
		break;
		
		case 'sendmail':
			if( empty( $c['sendmail_path'] ) ) {
				$baddata = true;
				$problems[] = $l['acp-sendmail-path'];
			}
			if( !$baddata ) {
				$db->query('UPDATE ' . db_config . ' SET value = "sendmail" WHERE name = "mail_type";');
				$db->query('UPDATE ' . db_config . ' SET value = "' . $c['mail_from'] . '" WHERE name = "mail_from"; ');
				
				$ets->page_body .= $l['goodedit'];
			}
		break;
		
		case 'mail':
			if( empty( $c['mail_from'] ) ) {
				$baddata = true;
				$problems[] = $l['acp-no-email'];
			}
			if( !$baddata ) {
				$db->query('UPDATE ' . db_config . ' SET value = "mail" WHERE name = "mail_type";');
				$db->query('UPDATE ' . db_config . ' SET value = "' . $c['mail_from'] . '" WHERE name = "mail_from";');
				
				$ets->page_body .= $l['goodedit'];
			}
		break;
		
		case 'none':
			$db->query('UPDATE ' . db_config . ' SET value = "none" WHERE name = "mail_type";');
			$ets->page_body .= $l['acp-no-email'];
		break;
	}	
}

// build form?
if( empty($_POST) || $baddata ) {
	// check for missing fields
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
	
	// build the form.
	$form->action = 'admincp.php?action=mail_config';
	$form->method = 'post';
	$form->class = 'nlb_config_form';
	$table->class = 'nlb_table';
	$table->width = "100%";
	
	$i = 0;
	
	foreach( $info as $key => $value ) {
		$f[$i]->name = $key;
		$f[$i]->value = $value;
		$f[$i]->desc = $l['cfg-mail-' . $key ];
		if( $key == 'smtp_password' ) {
			$f[$i]->type = 'password';
		} else {
			$f[$i]->type = 'text';
		}
		$i++;
	}
	
	$i++;
	$f[$i]->type = 'submit';
	$f[$i]->desc = $l['submit'];
	$f[$i]->value = $l['submit'];
	
	$ets->page_body .= build_form( $f, $form, $table, $_POST );
}

?>