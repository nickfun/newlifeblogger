<?PHP

/*
	------------------------------------------------		
			NewLife Blogging System Version 3		
	------------------------------------------------
		Developed by sevengraff
		Nick Fun <nick@sevengraff.com>
		Jan-March 2004
		Liscensed under the GNU GPL
	------------------------------------------------
*/

header("Content-type: text/xml");

require_once 'config.php';
require_once 'system/functions.php';
require_once 'system/sqldb2.class.php';

$path = fetch_url_data();

if( !isset($path['id']) ) {
	jsRedirect( script_path . 'index.php' );
	// I'm not sure if re-directing is the best option since RSS should be used by 
	// client apps, but if there is something wrong with the path info, then chances
	// are that someone is just trying to make an error appear.
}
$userid = addslashes($path['id']);
$home_url = full_url . build_link('blog.php', array('user' => $userid));

$db = new sqldb2( $DB_CONFIG );

// user exists?
$user_check = $db->getArray('SELECT count(user_id) AS c FROM ' . db_users . ' WHERE user_id="' . $userid . '";');
if( $user_check['c'] != 1 ) {
// 	die('Invalid User');
	jsRedirect( script_path . 'index.php' );
}

$user = $db->getArray('SELECT username FROM ' . db_users . ' WHERE user_id="' . $userid . '";');
$USER = $user['username'];

$blogs = $db->query('SELECT u.username AS author, b.*
FROM ' . db_users . ' AS u, ' . db_blogs . ' AS b
WHERE b.author_id = ' . $userid . ' AND b.author_id = u.user_id AND b.access = ' . access_public . '
ORDER BY b.date DESC
LIMIT 0, 10');

// print first part of rss

echo '<rss version="2.0">
<channel>
<title>Public blogs posted by ' . $USER . '</title>
<link>' . $home_url . '</link>
<description>The 10 most recent public blogs by ' . $USER . '</description>
<pubDate>' . date('r', time()) . '</pubDate>
<generator>NewLife Blogger v' . nlb_version . '</generator>';

// now print blog items
while($blog = mysql_fetch_assoc($blogs)) {
	foreach($blog as $key => $val) {
		$val = stripslashes($val);
		$val = htmlspecialchars($val);
		$blog[$key] = $val;
		$body = $blog['body'];
		if( $blog['bb'] == 1 ) {
			$body = insertBBCode($body);
			$body = htmlSpecialChars($body);	// we can not have HTML inside of a RSS feed.
		}
	}
	$url = build_link('blog.php',array('id'=>$blog['blog_id']));
	echo '
	<item>
	<title>' . $blog['subject'] . '</title>
	<link>' . full_url . $url . '</link>
	<description>' . $body . '</description>
	<comments>' . full_url . $url . '</comments>
	<pubDate>' . date('r', $blog['date']) . '</pubDate>
	</item>
	';
}

// print last part
echo '
</channel>
</rss>';

?>