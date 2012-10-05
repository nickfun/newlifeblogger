<?PHP

/**
 * =======================================
 *		M A S S   M A I L
 * =======================================
 */
 
if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}

$ets->page_body = '';
$USESKIN = skin_basic;
$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-acp-massmail'];
$ets_outter->page_title = $l['title-acp-massmail'];

include_once('system/nlb_mail.class.php');

$mail = new nlb_mail($db);
$text = new text($_POST, array('subject', 'message'));

if( !$mail->Active ) {
	
	// can't send emails!
	$ets->page_body = $l['acp-mail-disabled'];
	
} else {
	
	$baddata = false;

	if( !empty($_POST) ) {
		
		$text->validate();
		if( $text->is_missing_required ) {
		
			$baddata = true;
		
		} else {
			
			$text->MakeClean('trim', 'slash_if_needed');
			$c = $text->clean;
			
			$message = stripslashes($c['message']);
			$subject = stripslashes($c['subject']);		
			
			$mail->SMTPKeepAlive = true;	// in case we are using smtp, 
											// will improve performance

			// get all the user names...
			$names = $db->getAllArray('SELECT username, email FROM ' . db_users . ' WHERE email != "";');
			$number_sent = count($names);
			$mail->Subject = $subject;
			foreach( $names as $row ) {
				
				$mail->addAddress($row['email'], $row['username']);
				$mail->Body = str_replace('%USER%', $row['username'], $message);
				if( !$mail->Send() ) {
					echo 'ERROR:<HR>';
					echo $mail->Body;
					exit;
				}
				$mail->ClearAddresses();
				
			}
			
			$mail->SMTPClose();		// must call this when we use SMTPKeepAlive
			
			$ets->page_body = $l['acp-mail-success'] . $number_sent;
		}
		
	} else {
		
		if( $baddata ) {
			$ets->page_body = input_error_box(array($l['all-fields-required']));
		}
		
		$ets->page_body .= $l['acp-mail-intro'];
		
		// build form
		$form->action = 'admincp.php?action=mass_mail';
		$form->method = 'post';
		$form->class = 'nlb_form';
		$table->class = 'nlb_table';
		$table->width = "100%";
		
		$f = array();
		
		$i=0;
		$f[$i]->desc = $l['acp-mail-subject'];
		$f[$i]->type = 'text';
		$f[$i]->name = 'subject';
		$f[$i]->value = $config->get('site_name');
		
		$i++;
		$f[$i]->desc = $l['acp-mail-message'];
		$f[$i]->type = 'textarea';
		$f[$i]->name = 'message';
		
	
		$i++;
		$f[$i]->type = 'submit';
		$f[$i]->value = $l['submit'];			
		
		$ets->page_body .= build_form( $f, $form, $table );
	}
}

?>