<?PHP

/**
 * =======================================
 *		C H A N G E   P A S S W O R D
 * =======================================
 */
 
//
// Just for the heck of it, I coded this file
// using c-style indenting. I think it's a bit
// easier to read, but I'll stick to the faster
// java-style :-)
//
// -- Nick on March 13 2004
//

if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}

$USESKIN = skin_basic;
$problems = array();
$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-password'];
$ets_outter->page_title = $l['title-password'];

$text = new text(
	$_POST,
	array('old', 'new1', 'new2')
);

if( !empty($_POST) ) 
{
	// process input
	$text->validate();
	if( $text->is_missing_required )
	{
		$problems[] = $l['all-fields-required'];
	}
	else 
	{
		$text->makeClean('slash_if_needed', 'trim');
		$clean = $text->clean;
		$hashed = $user->get('password');
		if( md5($clean['old']) != $hashed )
		{
			// incorect old password!
			$problems[] = $l['ucp-pass-bad-old'];
		} 
		else
		{
			if( $clean['new1'] != $clean['new2'] )
			{
				$problems[] = $l['ucp-pass-not-same'];
			}
			else
			{
				// insert new password to database.
				$new = md5($clean['new1']);
				$user->set('password', $new);
				$user->updateDb();
				$user->logout();
				$user->login( $config->get('login_time') );
				
				$ets->page_body = $l['ucp-pass-good'];
			}
		}
	}
}

if( empty($_POST) || !empty($problems) ) {
	
	if( !empty($problems) )
	{
		$ets->page_body = '<div class="error">' . $l['data-problems'] . "\n";
		foreach( $problems as $err )
		{
			$ets->page_body .= '<li>' . $err . "</li>\n";
		}
		$ets->page_body .= "\n</div>\n\n";
	}
	
	// build form
	$form->action = 'usercp.php?action=password';
	$form->method = 'post';
	$form->class = 'nlb_form';
	$table->class = 'nlb_table';
	$table->width = "100%";
	
	// SUBJECT
	$i = 0;
	$f[$i]->type = 'password';
	$f[$i]->name = 'old';
	$f[$i]->desc = $l['ucp-pass-fld-old'];
	
	$i++;
	$f[$i]->type = 'password';
	$f[$i]->name = 'new1';
	$f[$i]->desc = $l['ucp-pass-fld-new1'];
	
	$i++;
	$f[$i]->type = 'password';
	$f[$i]->name = 'new2';
	$f[$i]->desc = $l['ucp-pass-fld-new2'];
	
	$i++;
	$f[$i]->type = 'submit';
	$f[$i]->value = $l['submit'];
	
	$ets->page_body .= build_form( $f, $form, $table, $_POST );
	
}

?>