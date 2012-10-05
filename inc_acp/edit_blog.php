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

	$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-admincp'];
	$ets_outter->page_title = $l['title-editblog'];

	$problems = array();
	$baddata = false;

	$text = new text( $_POST,
		array('body'),
		array('subject', 'mood', 'custom', 'bb', 'html', 'smiles', 'comments', 'delete')
	);

	// blog id is good?
	if( !isset($_GET['id']) ) {
		jsRedirect(script_path . 'admincp.php');
	} else {
		$blog_id = $_GET['id'] + 0;
	}

	$blog_data = $db->getArray('SELECT b.*, u.username
	FROM ' . db_blogs . ' as b, ' . db_users . ' as u
	WHERE b.blog_id=' . $blog_id . ' AND b.author_id=u.user_id
	LIMIT 1;');

	if( empty($blog_data) ) {
		// blog doesn't exit
		jsRedirect(script_path . 'admincp.php');
	}

	// admins can only edit public blogs
	if( $blog_data['access'] != access_public ) {
		jsredirect(script_path . 'admincp.php');
	}
	
	$author = new nlb_user($db, $blog_data['author_id']);

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
			
			// delete the blog?
			if( $c['delete'] == 'x' ) {
				$db->query('DELETE FROM ' . db_blogs . ' WHERE blog_id=' . $blog_id . ' LIMIT 1;');
				$author->recountBlogs();
				$author->updatedb();
				
				$ets->page_body = $l['item-deleted'];
			
			} else {

				// deal with options.
				$c['bb'] 		= empty( $c['bb'] ) 		? 1 : 0;
				$c['html'] 		= empty( $c['html'] ) 		? 1 : 0;
				$c['smiles']	= empty( $c['smiles'] )		? 1 : 0;
				
				// anti bad html
				badHtmlSecond($c['body']);

				// make the updates				
				$update = new nlb_blog( $db );
				$update->fetchFromDB( $blog_id );
				foreach( array('subject', 'custom', 'body', 'mood', 'bb', 'html', 'smiles') as $item ) {
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
				$author->recountBlogs();
					
				// set it in stone
				$update->updateToDB();
				$author->updateDB();
				
				$ets->page_body = $l['goodedit'];
			}
			
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
			stripslashes_array( $blog_data );
			// check options.
			if( $blog_data['bb'] == 1 ) {
				unset( $blog_data['bb'] );
			}
			if( $blog_data['html'] == 1 ) {
				unset( $blog_data['html'] );
			}
			if( $blog_data['smiles'] == 1 ) {
				unset( $blog_data['smiles'] );
			}
			if( $blog_data['comments'] != -1 ) {
				unset( $blog_data['comments'] );
			}
			$merge = $blog_data;
		} else {
			$merge = $_POST;
		}
		
		// build input	
		$form->action = 'admincp.php?action=edit_blog&id=' . $blog_id;
		$form->method = 'post';
		$form->class = 'nlb_form';
		$form->name = 'new_entry';
		$table->class = 'nlb_table';
		$table->width = "100%";
		
		// USERNAME
		$i = 0;
		$f[$i]->type = 'data';
		$f[$i]->desc = $l['username:'];
		$f[$i]->value = $blog_data['username'];
		
		// SUBJECT
		$i++;
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
		if( !empty( $author->data['custom'] ) ) {
			$i++;
			$f[$i]->type = 'text';
			$f[$i]->name = 'custom';
			$f[$i]->desc = $author->data['custom'];
		}
		
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
		
		// DELETE
		$i++;
		$f[$i]->type = 'checkboxes';
		$f[$i]->desc = $l['ucp-options'];
		$f[$i]->value = array(
			array(
				'name'	=> 'delete',
				'value'	=> 'x',
				'desc'	=> $l['delete']
			)
		);
		
		// counter bad html
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