<?PHP

/**
 * =======================================
 *	N E W   B L O G
 * =======================================
 */

if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}

$text = new text( $_POST,
	array('body'),
	array('subject', 'mood_list', 'mood', 'custom', 'access', 'bb', 'html', 'smiles', 'comments')
);
$problems = array();
$baddata = false;
$USESKIN = skin_basic;
$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-usercp'];
$ets_outter->page_title = $l['title-newblog'];

if( $user->isAllowed('blog') ) {

	// list of moods..
	$moods = $config->get("moods");
	$moods = str_replace("\r\n", "\n", $moods);
	$moods = trim( $moods );
	$moods = explode("\n", $moods);
	foreach( $moods as $key => $val ) {
		if( empty($moods[$key]) ) unset($moods[$key]);
	}
	sort( $moods );
	$moods['x'] = $l['ucp-null-mood'];

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
		
		// determin what mood to use.
		$mood = null;
		if( $c['mood_list'] != 'x' ) {
			$mood = $moods[ $c['mood_list'] ];
		}
		if( !empty( $c['mood'] ) ) {
			$mood = $c['mood'];
		}
		
		
		// deal with options.
		$bb 	= empty( $c['bb'] ) 		? 1 : 0;
		$html 	= empty( $c['html'] ) 		? 1 : 0;
		$smiles = empty( $c['smiles'] )		? 1 : 0;
		$comments = empty($c['comments'])	? 0 : -1;
		if( !in_array( $c['access'], range(1, 3) ) ) {
			$c['access'] = 1;
		}
					
		/**
		 * 		A D D   B L O G
		 */
		if( !$baddata ) {
			$new = array(
				'author_id'	=> $user->id,
				'date'		=> time(),
				'subject'	=> $c['subject'],
				'body'		=> $c['body'],
				'custom'	=> $c['custom'],
				'mood'		=> $mood,
				'comments'	=> $comments,
				'html'		=> $html,
				'smiles'	=> $smiles,
				'bb'		=> $bb,
				'access'	=> $c['access'],
				'views'		=> 0
			);
			$b->newBlog( $new );	// REMEBER: this will also add to blog count!
			
			// link to view blogs
			$url = build_link('blog.php', array('user' => $user->id));
			$link = '<a href="' . $url . '">' . $l['ucp-new-blog'] . '</a>';
			
			$ets->page_body = $link;
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
		$form->action = 'usercp.php?action=new_blog';
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
		
		// MOOD LIST
		$i++;
		$f[$i]->type = 'select';
		$f[$i]->name = 'mood_list';
		$f[$i]->desc = $l['ucp-moodlist'];
		$f[$i]->selected = rand(0, (count($moods)-1));
		$f[$i]->value = $moods ;
		
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
		
		// SUBMIT
		$i++;
		$f[$i]->type = 'submit';
		$f[$i]->desc = $l['submit'];
		$f[$i]->value = $l['submit'];
		
		// Output.
		$ets->page_body .= $js_insert_window . "\n";
		$ets->page_body .= build_form( $f, $form, $table, $_POST );
	}
} else {
	$ets->page_body = $l['denied'];
}

?>