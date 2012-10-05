<?PHP

/**
 * =======================================
 *		E D I T   B L O G
 * =======================================
 */

if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}

$USESKIN = skin_basic;
$text = new text( $_POST,
	array('body'),
	array('subject', 'mood', 'custom', 'access', 'bb', 'html', 'smiles', 'comments')
);
$problems = array();
$baddata = false;
$USESKIN = skin_basic;
$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-usercp'];
$ets_outter->page_title = $l['title-editblog'];

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

		// deal with options.
		$c['bb'] 		= empty( $c['bb'] ) 		? 1 : 0;
		$c['html'] 		= empty( $c['html'] ) 		? 1 : 0;
		$c['smiles']	= empty( $c['smiles'] )		? 1 : 0;
		
		badHtmlSecond($c['body']);

		// make the updates				
		$update = new nlb_blog( $db );
		$update->fetchFromDB( $_GET['id'] );
		foreach( array('subject', 'custom', 'body', 'bb', 'html', 'smiles', 'access') as $item ) {
			$update->setItem( $item, $c[$item] );
		}
		
		// deal with comments.
		if( empty( $c['comments'] ) ) {
			// comments are allowed
			$update->recountComments();
		} else {
			// no comments
			$update->setItem( 'comments', -1 );
		}
		
		// deal with blog count
		$user->recountBlogs();
		
		// set it in stone
		$update->updateToDB();
		$user->updateDB();
		
		$ets->page_body = $l['goodedit'];
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
	
	// use submitted data or grab from db?
	if( empty( $_POST ) ) {
		// get from db!
		$merge = $db->getArray('SELECT * FROM ' . db_blogs . ' WHERE blog_id=' . $_GET['id'] . ';');
		if( empty( $merge ) || $merge['author_id'] != $user->id ) {
			// if we are not the author,
			// or if this blog doesn't exist,
			// then throw back to homepage.
			jsRedirect('index.php');
		}
		// put editable info into $merge.
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
	$form->action = 'usercp.php?action=edit_blog&id=' . $_GET['id'];
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
	
	// MOOD
	$i++;
	$f[$i]->type = 'text';
	$f[$i]->name = 'mood';
	$f[$i]->desc = $l['ucp-mood'];

	// CUSTOM ?
	if( !empty( $user->data['custom'] ) ) {
		$i++;
		$f[$i]->type = 'text';
		$f[$i]->name = 'custom';
		$f[$i]->desc = $user->data['custom'];
	}
	
	// ACCESS
	$i++;
	$f[$i]->type = 'select';
	$f[$i]->name = 'access';
	$f[$i]->desc = $l['ucp-access'];
	$f[$i]->value = array(
		1 => $l['access-public'],		// public
		2 => $l['access-friends'],		// friends only
		3 => $l['access-private']		// private
	);
	
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
	
	badHtmlFirst($merge['body']);
	
	// SUBMIT
	$i++;
	$f[$i]->type = 'submit';
	$f[$i]->desc = $l['submit'];
	$f[$i]->value = $l['submit'];
	
	// Output.
	$ets->page_body .= $js_insert_window . "\n";
	$ets->page_body .= build_form( $f, $form, $table, $merge);
	
}

?>