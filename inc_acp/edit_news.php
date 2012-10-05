<?PHP

/**
 * =======================================
 *		E D I T   N E W S   I T E M
 * =======================================
 */
 
if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}
 
$text = new text( 
	$_POST,
	array('body'),
	array('subject', 'bb', 'html', 'smiles', 'comments')
);
$problems = array();
$baddata = false;
$USESKIN = skin_basic;
$ets_outter->main_title = $config->get('site_name') . ": " . $l['acp-editnews'];
$ets_outter->page_title = $l['acp-editnews'];

if( !isset($_GET['id']) ) {		// No news ID specified.
	jsRedirect("admincp.php?action=edit_list");
}

if( !empty( $_POST ) ) {
	/**
	 *		Check submited data
	 */
	$text->validate();
	$text->makeClean('trim', 'slash_if_needed');
	$c = $text->clean;
	if( $text->is_missing_required ) {
		$baddata = true;
	} else {

		/**
		 * 		U P D A T E   I T E M
		 */	
		 		
		// deal with options.
		$bb 	= empty( $c['bb'] ) 		? 1 : 0;
		$html 	= empty( $c['html'] ) 		? 1 : 0;
		$smiles = empty( $c['smiles'] )		? 1 : 0;

		badHtmlSecond($c['subject']);
		$update = new nlb_blog( $db );
		$update->fetchFromDB( $_GET['id'] );
		$update->setItem( "subject", 	$c['subject'] );
		$update->setItem( "body", 		$c['body'] );
		$update->setItem( "bb", 		$bb );
		$update->setItem( "html",		$html );
		$update->setItem( "smiles",		$smiles );
		if( empty( $c['comments'] ) ) {
			$update->recountComments();
		} else {
			$update->setItem( "comments", -1 );
		}
		
		$update->updateToDB();
		
		$ets->page_body = $l['goodedit'];
	}
}

/**
 *		Build input
 */

if( empty( $_POST ) || $baddata ) {
				
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
	
	// load from database or use _POST?
	if( empty( $_POST ) ) {
		// get from db...
		$id = $_GET['id'];
		$merge = $db->getArray("SELECT * FROM " . db_blogs . " WHERE blog_id = " . $id . " AND access = " . access_news . " LIMIT 1;");
		stripslashes_array( $merge );
		// check options.
		if( $merge['bb'] == 1 ) {
			unset( $merge['bb'] );
		}
		if( $merge['html'] == 1 ) {
			unset( $merge['html'] );
		}
		if( $merge['smiles'] == 1 ) {
			unset( $merge['smiles'] );
		}
		if( $merge['comments'] != -1 ) {
			unset( $merge['comments'] );
		}
	} else {
		$merge = $_POST;
	}
	
	// build input	
	$form->action = 'admincp.php?action=edit_news&id=' . $_GET['id'];
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
	
	badHtmlFirst($merge['body']);
	
	// Output.
	$ets->page_body .= $js_insert_window . "\n";
	$ets->page_body .= build_form( $f, $form, $table, $merge );
}

?>