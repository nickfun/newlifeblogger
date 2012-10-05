<?PHP

/**
 * =======================================
 * 		N E W   A R T I C L E
 * =======================================
 */

if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
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
$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-config'];
$ets_outter->page_title = $l['title-art-new'];

if( !empty($_POST) ) {
	// check data
	if( $text->is_missing_required ) {
		$baddata = true;
	} else {
		$subject = $text->clean['subject'];
		$body = $text->clean['body'];
		$now = time();
		$uid = $user->id;
		$db->query('INSERT INTO `' . db_articles . "` VALUES (
		'', '$uid', '$subject', '$now', '$body'
		);");
		$ets->page_body .= $l['acp-newarticle'];
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
	
	// build form
	$form->action = 'admincp.php?action=new_article';
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
	
	$ets->page_body .= build_form( $f, $form, $table, $_POST );
	
}

?>