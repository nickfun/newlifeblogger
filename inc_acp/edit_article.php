<?PHP

/**
 * =======================================
 * 		E D I T   A R T I C L E
 * =======================================
 */
 
if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}

if( !isset( $_GET['id'] ) ) {
	jsRedirect('admincp.php?action=list_article');
}
$USESKIN = skin_basic;
$text = new text(
	$_POST,
	array('subject', 'body')
);
$text->validate();
$text->makeClean('slash_if_needed', 'trim');
$baddata = false;
$problems = array();
$ets->page_body = '';
$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-art-edit'];
$ets_outter->page_title = $l['title-art-edit'];

if( !empty($_POST) ) {
	// check data
	if( $text->is_missing_required ) {
		$baddata = true;
	} else {
		$subject = $text->clean['subject'];
		$body = $text->clean['body'];
		badHtmlSecond($body);
		$db->query('UPDATE ' . db_articles . '
		SET subject="' . $subject . '", body="' . $body . '"
		where article_id="' . $_GET['id'] . '"
		LIMIT 1;');
		$ets->page_body .= $l['goodedit'];
	}
}

if( empty( $_POST ) || $baddata ) {
	if( $baddata ) {
		// the only thing that can go wrong is missing fields.
		$ets->page_body .= '<div class="error">';
		foreach( $text->missing_fields as $f ) {
			$ets->page_body .= '<li>' . $l['missing-field'] . $f . '</li>';
		}
		$ets->page_body .= '</div>';
	}
	
	// use submited data or data from db?
	if( empty( $_POST ) ) {
		$merge = $db->getArray('SELECT subject, body FROM ' . db_articles . ' WHERE article_id=' . $_GET['id'] . ' LIMIT 1;');
	} else {
		$merge = $_POST;
	}
	
	// build form
	$form->action = 'admincp.php?action=edit_article&id=' . $_GET['id'];
	$form->method = 'post';
	$form->class = 'nlb_config_form';
	$table->class = 'nlb_table';
	$table->width = "100%";
	$f = array();
	
	$i=0;
	$f[$i]->name = 'subject';
	$f[$i]->type = 'text';
	$f[$i]->desc = $l['ucp-subject'];
	
	$i++;
	$f[$i]->name = 'body';
	$f[$i]->type = 'textarea';
	$f[$i]->desc = $l['acp-article'];
	
	$i++;
	$f[$i]->type = 'submit';
	$f[$i]->value = $l['submit'];
	$f[$i]->desc = $l['submit'];
	
	badHtmlFirst($merge['body']);
	
	$ets->page_body .= build_form( $f, $form, $table, $merge );
	
}

?>