<?PHP

/**
 * =======================================
 *		O U T T E R   T E M P L A T E
 * =======================================
 */

if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}

$baddata = false;
$problems = array();
$USESKIN = skin_basic;
$ets->page_body = "";
$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-config'];
$ets_outter->page_title = $l['title-config'];

$text = new text( $_POST, array('source') );
$text->validate();

if( !empty( $_POST ) ) {
	if( $text->is_missing_required ) {
		$baddata = true;
	}
	
	if( !$baddata ) {
		$newsource = slash_if_needed( $_POST['source'] );
		$now = time();
		$db->query(' # Update Outter Template SOURCE
		UPDATE ' . db_config . '
		SET value = "' . $newsource . '"
		WHERE name = "outter_template_source";');
		
		$db->query(' # Update outter template TIME
		UPDATE ' . db_config . '
		SET value = "' . $now . '"
		WHERE name = "outter_template_source_time";');
		
		// talk to user.
		$ets->page_body .= $l['goodedit'];
	}
}

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
	
	// get source from database
	$get = $db->getArray('SELECT value FROM ' . db_config . ' WHERE name="outter_template_source" LIMIT 1;');
	$oldsource = stripslashes( $get['value'] );
	
	// build form
	$form->action 	= 'admincp.php?action=outter_template';
	$form->method 	= 'post';
	$table->class 	= 'nlb_table';
	$table->width 	= "100%";
	
	$i = 0;
	$f[$i]->name 	= 'source';
	$f[$i]->type 	= 'textarea';
	$f[$i]->value 	= $oldsource;
	$f[$i]->desc 	= $l['acp-outter-tpl-info'];
	
	$i++;
	$f[$i]->type 	= 'submit';
	$f[$i]->value 	= $l['submit'];
	$f[$i]->desc 	= $l['submit'];
	
	$ets->page_body .= build_form( $f, $form, $table, $_POST );
}

?>