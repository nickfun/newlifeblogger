<?PHP

/**
 * =======================================
 *		P O S T   N E W S
 * =======================================
 */

if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}

$text = new text( $_POST,
	array('body'),
	array('subject', 'bb', 'html', 'smiles', 'comments')
);
$problems = array();
$baddata = false;
$USESKIN = skin_basic;
$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-admincp'];
$ets_outter->page_title = $l['title-postnews'];

if( !empty( $_POST ) ) {
	/**
	 *		Check submited data
	 */
	$text->validate();
	$text->makeClean('trim', 'slash_if_needed');
	$c = $text->clean;
	if( $text->is_missing_required ) {
		$baddata = true;
	}
	
	// deal with options.
	$bb 	= empty( $c['bb'] ) 		? 1 : 0;
	$html 	= empty( $c['html'] ) 		? 1 : 0;
	$smiles = empty( $c['smiles'] )		? 1 : 0;
	$comments = empty( $c['comments'] )	? 0 : -1;

	/**
	 * 		A D D   N E W S
	 */
	if( !$baddata ) {
		$new = array(
			'author_id'	=> $user->id,
			'date'		=> time(),
			'subject'	=> $c['subject'],
			'body'		=> $c['body'],
			'custom'	=> null,
			'mood'		=> null,
			'comments'	=> $comments,
			'html'		=> $html,
			'smiles'	=> $smiles,
			'bb'		=> $bb,
			'access'	=> access_news,
			'views'		=> 0
		);
		$b->newBlog( $new );
		$ets->page_body = $l['ucp-new-blog'];
	}
}

if( empty( $_POST ) || $baddata ) {
	
	/**
	 *		Build input
	 */
	
	// check for problems.
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
	
	// build input	
	$form->action = 'admincp.php?action=news';
	$form->method = 'post';
	$form->class = 'nlb_form';
	$form->name = 'new_entry';
	$table->class = 'nlb_table';
	$table->width = "100%";
	
	// SUBJECT
	$i = 0;
	$f[$i]->type = 'text';
	$f[$i]->name = 'subject';
	$f[$i]->desc = $l['ucp-subject'];
	
	// BODY
	$i++;
	$f[$i]->type = 'textarea';
	$f[$i]->name = 'body';
	$f[$i]->desc = $l['ucp-blog'];
	
	// INSERT
	$i++;
	$f[$i]->type = 'data';
	$f[$i]->desc = $l['ucp-insert'];
	$f[$i]->value = '	<a href="javascript:insertWindow(\'bbcode.php\');">' . $l['ucp-ins-bbcode'] . '</a>  
						<a href="javascript:insertWindow(\'smiles.php\');">' . $l['ucp-ins-smiles'] . '</a>';
	
	// OPTIONS
	$i++;
	$options = array(
		array(
			'name' => 'bb',
			'value' => 'x',
			'desc' => $l['ucp-opt-bb']
		),
		array(
			'name' => 'html',
			'value' => 'x',
			'desc' => $l['ucp-opt-html']
		),
		array(
			'name' => 'smiles',
			'value' => 'x',
			'desc' => $l['ucp-opt-smiles']
		),
		array(
			'name' => 'comments',
			'value' => 'x',
			'desc' => $l['ucp-opt-comments']
		)
	);
	$f[$i]->type = 'checkboxes';
	$f[$i]->desc = $l['ucp-options'];
	$f[$i]->value = $options;
	
	// SUBMIT
	$i++;
	$f[$i]->type = 'submit';
	$f[$i]->desc = $l['submit'];
	$f[$i]->value = $l['submit'];
	
	// Output.
	$ets->page_body .= $js_insert_window . "\n";
	$ets->page_body .= build_form( $f, $form, $table, $_POST );
	
}

?>