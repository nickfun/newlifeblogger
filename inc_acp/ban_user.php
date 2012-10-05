<?PHP

/**
 * =======================================
 *		B A N   U S E R
 * =======================================
 */	

if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}

$baddata = false;
$problems = array();
$ets->page_body = '';
$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-admincp'];
$ets_outter->page_title = $l['title-banuser'];
$USESKIN = skin_basic;
$text = new text( $_POST, array('name', 'reason', 'until') );
$text->validate();
$text->makeClean('trim', 'slash_if_needed');

if( !empty($_POST) ) {
	if( $text->is_missing_required ) {
		$baddata = true;
	} else {
		$c = $text->clean;
		// get userid
		$user_data = $db->getArray('SELECT user_id, ip FROM ' . db_users . ' WHERE username="' . $c['name'] . '";');
		if( $db->getRowCount() == 0 ) {
			$baddata = true;
			$problems[] = $l['acp-ban-err-user'];
		} else {
			// time okay?
			$until = strtotime( $c['until'] );
			if( $until == -1 ) {
				$baddata = true;
				$problems[] = $l['acp-ban-err-until'];
			} else {
				// insert into database
				$db->query('INSERT INTO ' . db_banned . "
				VALUES (
				'', '{$user_data['user_id']}', '{$user_data['ip']}', '{$c['reason']}', '$until'
				);");
				
				$ets->page_body = $l['acp-ban-good'];
			}
		}
	}
}
				

if( empty($_POST) || $baddata ) {
	if( $baddata ) {
		if( $text->is_missing_required ) {
			foreach( $text->missing_fields as $f ) {
				$problems[] = $l['missing_field'] . ' ' . $l['acp-ban-err-' . $f];
			}
		}
	}
	if( !empty( $problems ) ) {
		$ets->page_body .= '<div class="error">' . $l['data-problems'] . '<br />';
		foreach( $problems as $p ) {
			$ets->page_body .= "<li>$p</li>\n";
		}
		$ets->page_body .= '</div>';
	}
	
	$form->action = 'admincp.php?action=ban_user';
	$form->method = 'post';
	$form->class = 'nlb_config_form';
	$table->class = 'nlb_table';
	$table->width = "100%";
	
	$f = array();			
	
	$i = 0;			
	$f[$i]->name = 'name';
	$f[$i]->type = 'text';
	$f[$i]->desc = $l['acp-ban-fld-name'];
	
	$i++;
	$f[$i]->name = 'reason';
	$f[$i]->type = 'text';
	$f[$i]->desc = $l['acp-ban-fld-reason'];
	
	$i++;
	$f[$i]->name = 'until';
	$f[$i]->type = 'text';
	$f[$i]->desc = $l['acp-ban-fld-until'];
	
	$i++;
	$f[$i]->type = 'submit';
	$f[$i]->value = $l['submit'];
	$f[$i]->desc = $l['submit'];
	
	$ets->page_body .= build_form( $f, $form, $table, $_POST );
}

?>