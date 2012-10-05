<?PHP

/**
 * =======================================
 * 		E D I T   C O M M E N T
 * =======================================
 */
 
if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}

if( !isset($_GET['id']) ) {
	jsRedirect( script_path . 'admincp.php' );
} else {
	$comment_id = $_GET['id'] + 0;
}

// comment exists?
$comment = $db->getArray('SELECT * FROM ' . db_comments . ' WHERE comment_id=' . $comment_id . ' LIMIT 1;');
if( empty($comment) ) {
	jsRedirect(script_path . 'admincp.php');
}

$USESKIN = skin_basic;
$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-editcomment'];
$ets_outter->page_title = $l['title-editcomment'];

$text = new text(
	$_POST,
	array('body'),
	array('delete')
);

$missing = false;

if( !empty($_POST) ) {
	$text->validate();
	if( $text->is_missing_required ) {
		$missing = true;
	} else {
		$text->makeClean('trim', 'slash_if_needed');
		$clean = $text->clean;
		if( $clean['delete'] == 'x' ) {
			// remove comment
			$db->query('DELETE FROM ' . db_comments . ' WHERE comment_id="' . $comment_id . '" LIMIT 1;');

			$updatecount = new nlb_blog( $db );
			$updatecount->fetchFromDB( $comment['parent_id'] );
			$updatecount->recountComments();
			$updatecount->updateToDB();
			
			$ets->page_body .= $l['acp-com-deleted'];
			
		} else {
			// just update the comment
			badHtmlSecond($clean['body']);
			$db->query('UPDATE ' . db_comments . ' SET body="' . $clean['body'] . '" WHERE comment_id="' . $comment_id . '" LIMIT 1;');
			$ets->page_body .= $l['goodedit'];
		}
	}
}

if( empty($_POST) || $missing ) {
	
	if( $missing ) {
		$ets->page_body = '<div class="error">' . $l['data-problems'] . "\n";
		$ets->page_body .= '<li>' . $l['all-fields-required'] . '</li></div>';
	}
	
	// get username?
	if( $comment['author_id'] != -1 ) {
		$get = $db->getArray('SELECT username FROM ' . db_users . ' WHERE user_id=' . $comment['author_id'] . ' LIMIT 1;');
		$username = $get['username'];
		
		// anti html pass 1
		badHtmlFirst($comment['body']);
	} else {
		$username = $l['guest'];
	}
	
	// build form
	$form->action = 'admincp.php?action=edit_comment&id=' . $comment_id;
	$form->method = 'post';
	$form->class = 'nlb_form';
	$form->name = 'new_entry';
	$table->class = 'nlb_table';
	$table->width = "100%";
	
	// USERNAME
	$i = 0;
	$f[$i]->type = 'data';
	$f[$i]->desc = $l['username:'];
	$f[$i]->value = $username;
	
	// IP
	$i++;
	$f[$i]->type = 'data';
	$f[$i]->desc = $l['ip'];
	$f[$i]->value = $comment['ip'];
	
	// BODY
	$i++;
	$f[$i]->type = 'textarea';
	$f[$i]->desc = $l['body:'];
	$f[$i]->name = 'body';
	$f[$i]->value = $comment['body'];
	
	// DELETE OPTION
	$i++;
	$f[$i]->type = 'checkboxes';
	$f[$i]->desc = $l['ucp-options'];
	$f[$i]->value = array(
		array(
			'name' => 'delete',
			'value' => 'x',
			'desc' => $l['delete']
		)
	);
	
	// SUBMIT
	$i++;
	$f[$i]->type = 'submit';
	$f[$i]->value = $l['submit'];
	
	$ets->page_body .= build_form( $f, $form, $table, $_POST );
	
}

?>