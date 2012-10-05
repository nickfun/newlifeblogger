<?PHP

/**
 * =======================================
 *		F R I E N D S
 * =======================================
 */

if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}

$USESKIN = skin_basic;
$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-usercp'];
$ets_outter->page_title = $l['title-friends'];
$ets->page_body = '';

// we get friends?
if( !$user->isAllowed('friends') ) {
	$ets->page_body = $l['denied'];	// nope.
} else {	// yep.
	// are we deleting a friend?
	if( isset($_GET['delete']) ) {
		$delid = $_GET['delete'];
		$db->query('DELETE FROM ' . db_friends . ' WHERE friend_id = ' . $delid . ' AND owner_id = ' . $user->id . ' LIMIT 1;');
	}
	$user->fetchFriends();
	// are we adding a friend?
	if( isset( $_POST['name'] ) ) {
		// add friend if exists & not already is a friend.
		$friendid = $db->getArray('SELECT user_id FROM ' . db_users . ' WHERE username="' . $_POST['name'] . '" LIMIT 1;');
		if( empty( $friendid ) ) {
			$ets->page_body = '<div class="error">' . $l['ucp-fri-badname'] . '</div>';;
		} else {
			// are already friends?
			$fid = $friendid['user_id'];
			if( $user->areFriends( $fid ) ) {
				$ets->page_body = '<div class="error">' . $l['ucp-fri-exists'] . '</div>';
			} else {
				// add the friend
				$uid = $user->id;
				$now = time();
				$db->query('INSERT INTO `' . db_friends . "` ( `owner_id` , `friend_id` , `date` )
				VALUES (
				'$uid', '$fid', '$now'
				);");
				// friend is added, send back to list of friends page.
				jsRedirect('usercp.php?action=friends');
			}
		}
	}
	// Show list of friends
	if( count( $user->friends ) > 0 ) {
		$ets->page_body .= '<table class="nlb_table"><tr>
		<th>' . $l['username:'] . '</th>
		<th>' . $l['ucp-fri-profile'] . '</th><th>' . $l['ucp-fri-blog'] . '</th>
		<th>' . $l['ucp-fri-added'] . '</th>
		<th>' . $l['ucp-fri-del'] . '</th></tr>';
		// get info on friends.
		$friends = $db->getAllArray('SELECT f.date, u.username, u.blog_count, u.user_id
		FROM ' . db_users . ' as u, ' . db_friends . ' as f
		WHERE f.owner_id = ' . $user->id . ' AND u.user_id = f.friend_id
		ORDER BY f.date DESC;');
		foreach( $friends as $f ) {
			$id = $f['user_id'];
			$ets->page_body .= '<tr><td>' . $f['username'] . '</td>';
			$ets->page_body .= '<td><a href="' . script_path . 'profile.php/user/' . $id . '">Profile</a></td>';
			$ets->page_body .= '<td><a href="' . script_path . 'blog.php/user/' . $id . '">' . $f['blog_count'] . '</a></td>';
			$ets->page_body .= '<td>' . date('M jS, Y g:i a', $f['date']) . '</td>';
			$ets->page_body .= '<td><a href="usercp.php?action=friends&delete=' . $id . '">Delete</a></td></tr>';
			$ets->page_body .= "\n";
		}
		$ets->page_body .= '</table><p>';
	}
	// let user add a friend
	$ets->page_body .= '<b>' . $l['ucp-fri-addfriend'] . '</b>
	<form method="post" action="usercp.php?action=friends">
	<input type="text" name="name" class="nlb_input">
	<input type="submit" value="' . $l['submit'] . '"></form><p>';
	
	// list people who have us as a friend.
	$asfriend = $db->getAllArray('SELECT u.username, u.user_id, u.blog_count, f.date 
	FROM ' . db_users . ' as u, ' . db_friends . ' as f
	WHERE f.friend_id = ' . $user->id . ' AND f.owner_id = u.user_id
	ORDER BY f.date DESC;');

	if( $db->getRowCount() != 0 ) {
		$ets->page_body .= $l['ucp-fri-asfriend'] . '<br>';
		$ets->page_body .= '<table class="nlb_table"><tr>
			<th>' . $l['username:'] . '</th>
			<th>' . $l['ucp-fri-profile'] . '</th><th>' . $l['ucp-fri-blog'] . '</th>
			<th>' . $l['ucp-fri-added'] . '</th></tr>';
		foreach( $asfriend as $f ) {
			$id = $f['user_id'];
			$ets->page_body .= '<tr><td>' . $f['username'] . '</td>';
			$ets->page_body .= '<td><a href="' . script_path . 'profile.php/user/' . $id . '">Profile</a></td>';
			$ets->page_body .= '<td><a href="' . script_path . 'blog.php/user/' . $id . '">' . $f['blog_count'] . '</a></td>';
			$ets->page_body .= '<td>' . date('M jS, Y g:i a', $f['date']) . "</td></tr> \n";
		}
		$ets->page_body .= '</table><p>';
	}
}

?>