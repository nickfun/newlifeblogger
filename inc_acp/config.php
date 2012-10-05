<?PHP

/**
 * =======================================
 *		C O N F I G
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

// these config options need a <textarea>.
// all others get <input type="text">.
$textarea = array('moods',);

// these configs should not be edited by humans.
$hide = array(
	/* Outter template options */
	'outter_template_source', 
	'outter_template_source_time',
	'outter_template_cache',
	'outter_template_cache_time',
	
	/* mail options */
	'mail_type',
	'mail_from',
	'smtp_username',
	'smtp_password',
	'smtp_host',
	'sendmail_path'			
);

// remove hidden fields.
$getconfig = $config->config;
foreach( $hide as $item ) {
	unset( $getconfig[$item] );
}
		
$required = array_keys( $getconfig );
		
$text = new text( $_POST, $required );
$text->validate();

// dealing with input?
if( !empty( $_POST ) ) {
	if( $text->is_missing_required ) {
		$baddata = true;
	}
	
	if( !$baddata ) {
		$text->makeClean('slash_if_needed');
		$clean = $text->clean;
		$oldconfig = $config->config;
		$diff = array();
		foreach( $clean as $key => $val ) {
			if( $oldconfig[$key] != $val ) {
				$diff[$key] = $val;
			}
		}
		if( empty( $diff ) ) {
			$ets->page_body .= $l['acp-nochange'];
		} else {
			$q = "";
			foreach( $diff as $key => $val ) {
				$db->query("UPDATE " . db_config . " SET value='" . $val . "' WHERE name='" . $key . "' LIMIT 1;");
			}
			// Remind admin what was just changed.
			$ets->page_body .= $l['acp-configchanged'] . " \n<ul>\n";
			foreach( $diff as $key => $temp ) {
				$ets->page_body .= '<li>' . $l['site-cfg-field-' . $key] . "</li>\n";
			}
			$ets->page_body .= "</ul>";
		}

	}
}

// displaying form?
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
	$form->action = 'admincp.php?action=config';
	$form->method = 'post';
	$form->class = 'nlb_config_form';
	$table->class = 'nlb_table';
	$table->width = "100%";
	
	// Main form body
	$i = 0;
	foreach( $config->config as $key => $value) {
		if( in_array( $key, $hide ) ) {
			continue;
		}		
		if( in_array( $key, $textarea ) ) {
			$f[$i]->type = 'textarea';
		} else {
			$f[$i]->type = 'text';
		}
		$f[$i]->name = $key;
		$f[$i]->value = stripslashes($value);
		$f[$i]->desc = $l['cfg-' . $key];
		$f[$i]->class = "nlb_config_input";
		$i++;
	}
	
	$f[$i]->type = "submit";
	$f[$i]->desc = $l['submit'];
	$f[$i]->value = $l['submit'];
	
	$ets->page_body .= build_form( $f, $form, $table, $_POST );
}

?>