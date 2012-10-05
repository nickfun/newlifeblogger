<?PHP

	/********************************
	 *  v2 to v3 converter          *
	 *  Feb 2004                    *
	 *  By Sevengraff               *
	 *  <nick@sevengraff.com>       *
	 ********************************/
	 
//
// v2 DATABASE INFO (old database)
//
$DB_CONFIG_v2['username']	= 'root';
$DB_CONFIG_v2['password']	= '';
$DB_CONFIG_v2['location']	= 'localhost';
$DB_CONFIG_v2['database']	= 'nlb';

//
// v3 DATABASE INFO (new database)
//
$DB_CONFIG_v3['username']	= 'root';
$DB_CONFIG_v3['password']	= '';
$DB_CONFIG_v3['location']	= 'localhost';
$DB_CONFIG_v3['database']	= 'nlb3';

//
// Text to replace %HOME% with in template
//

$HOME_TEXT = 'Home';

//
// Access Permissions for users:
//

$users_access = 'blog:comment:av_use:av_up:friends:tpl_change:tpl_custom';

//
// You can stop editing
// ---------------------------------------------------

function mymicrotime( $start = FALSE, $place = FALSE)
{
	list($usec, $sec) = explode(" ",microtime());
	if(!$start) {
		return ((float)$usec + (float)$sec);
	} else {
		if($place) {
			return round( ( (float)$usec + (float)$sec ) - $start, $place);
		}
		return (((float)$usec + (float)$sec) - $start);
	}
}

if( !isset($_GET['a']) ) {
	$f = $_SERVER['PHP_SELF'];
	echo '<font size="+2" color="blue">Read:</font> You <b>must</b> edit this file so that it can access you database!<br>
	Realize that this process can take a lot of resources. It is best to run this when your website has few visitors.<p>';
	echo '<a href="' . $f . '?a=GO">Click to start</a><br>';
	echo 'If you have been running since a very old version of NLB and the link above gave you an error, then DROP the nlb3 tables, run new_install.sql again, and 	<a href="' . $f . '?a=GO&old=true">use this link</a>';
	echo '<p>Things that will be converted:<ul>
	<li>Users (no one will be admin after convert. See readme.txt to make someone an admin)</li>
	<li>Blogs</li>
	<li>Comments</li></ul>
	Things that will NOT be converted:
	<ul>
	<li>Avatar</li>
	<li>Friends</li>
	<li>Templates</li>
	<li>Any and all modifications to the original NLB</li></ul>
	';
	die();
}

$START = mymicrotime();

include 'system/sqldb2.class.php';
include 'config.php';

// get salem template
$tpl_file = 'templates/i_hate_salem.blog.ets';

$fp = fopen($tpl_file, 'rb');
$tpl_blog = fread($fp, filesize($tpl_file));
fclose($fp);

$tpl_file = str_replace('.blog.', '.profile.', $tpl_file);
$fp = fopen($tpl_file, 'rb');
$tpl_profile = fread($fp, filesize($tpl_file));
fclose($fp);

$tpl_file = str_replace('.profile.', '.friends.', $tpl_file);
$fp = fopen($tpl_file, 'rb');
$tpl_friends = fread($fp, filesize($tpl_file));
fclose($fp);

$linkurl = script_path . 'index.php';

$tpl_blog 		= addslashes($tpl_blog);
$tpl_blog		= str_replace("%HOME%", $HOME_TEXT, $tpl_blog);
$tpl_blog		= str_replace("%HOME_LINK%", $linkurl, $tpl_blog);

$tpl_profile 	= addslashes($tpl_profile);
$tpl_profile	= str_replace("%HOME%", $HOME_TEXT, $tpl_profile);
$tpl_profile	= str_replace("%HOME_LINK%", $linkurl, $tpl_profile);

$tpl_friends	= addslashes($tpl_friends);
$tpl_friends	= str_replace("%HOME%", $HOME_TEXT, $tpl_friends);
$tpl_friends	= str_replace("%HOME_LINK%", $linkurl, $tpl_friends);


$db = new sqldb2( $DB_CONFIG_v2 );

// get users
$name_id = array();
$all_users = array();

$t = $db->query('SELECT * FROM nlb_users;');
while( $row = mysql_fetch_assoc( $t ) ) {
	$all_users[] = $row;
	$name_id[ $row['username'] ] = $row['id'];
}

// get blogs
$all_blogs = $db->getAllArray('SELECT * FROM nlb_blogs;');
// get comments
$all_com = $db->getAllArray('SELECT * FROM nlb_comments;');

$db->clear();

$db->setConfig( $DB_CONFIG_v3 );
$db->connect();

$now = time();
$past = 458895600;

//
//	INSERT USERS
//
foreach( $all_users as $u ) {
	if( isset($_GET['old']) && $_GET['old'] == 'true' ) {
		$u['bio'] 		= addslashes($u['bio']);
		$u['custom_title']	= addslashes($u['custom_title']);
		$u['username']	= addslashes($u['username']);
	}
	$db->query('INSERT INTO `nlb3_users` ( `user_id` , `username` , `password` , `email` , `access` , `registered` , `last_login` , `ip` , `blog_count` , `timezone` , `bio` , `custom` , `date_format` , `birthday` , `perpage` , `gender` , `valid` )
	VALUES (' . "
	'{$u['id']}', 
	'{$u['username']}', 
	'{$u['password']}', 
	'{$u['email']}', 
	'{$users_access}', 
	'{$u['registered']}', 
	'{$u['last_seen']}', 
	'{$u['ip_address']}', 
	'0', 
	'0', 
	'{$u['bio']}', 
	'{$u['custom_title']}', 
	'{$u['date_format']}', 
	'', 
	'{$u['blogs_per_page']}', 
	'{$u['gender']}', 
	'{$u['status']}'
	);");
	// Template Source
	$id = $u['id'];
	$db->query( 'INSERT INTO ' . db_source . " ( 
		`owner_id` , `blog` , `blog_updated` , `friends` , `friends_updated` , `profile` , `profile_updated` )
		VALUES (
		'$id', '$tpl_blog', '$now', '$tpl_friends', '$now', '$tpl_profile', '$now'
		);");
		
	// Template Cache
	$db->query( 'INSERT INTO ' . db_cache . " ( 
		`owner_id` , `blog` , `blog_updated` , `friends` , `friends_updated` , `profile` , `profile_updated` )
		VALUES (
		'$id', 'empty', '$past', 'empty', '$past', 'empty', '$past'
		);");
}
unset( $all_users );

// status => access
$access_2_3 = array(
	4 => 1,
	3 => 3,
	2 => 2,
	1 => 4
);

//
//	INSERT BLOGS
//
foreach( $all_blogs as $b ) {
	if( !isset($name_id[ $b['author'] ]) ) {
		continue;
	}
	if( isset($_GET['old']) && $_GET['old'] == 'true' ) {
		$b['subject']		= addslashes($b['subject']);
		$b['blog']			= addslashes($b['blog']);
		$b['custom']		= addslashes($b['custom']);
		$b['mood']			= addslashes($b['mood']);
	}
	$a_id = $name_id[ $b['author'] ];	// get author's ID number
	$access = $access_2_3[ $b['status'] ];
	$db->query('INSERT INTO `nlb3_blogs` ( `blog_id` , `author_id` , `date` , `subject` , `body` , `custom` , `mood` , `comments` , `html` , `smiles` , `bb` , `access` , `views` )
	VALUES (' . "
	'{$b['id']}', 
	'{$a_id}', 
	'{$b['date']}', 
	'{$b['subject']}', 
	'{$b['blog']}', 
	'{$b['custom']}', 
	'{$b['mood']}', 
	'{$b['comments']}',  
	'{$b['html']}', 
	'{$b['smiles']}', 
	'{$b['bb']}', 
	'{$access}', 
	'0');");
}
unset( $all_blogs );

//
//	INSERT COMMENTS
//
foreach( $all_com as $c ) {
	if( !isset( $name_id[ $c['author'] ] ) ) {
		$a_id = -1;
	} else {
		$a_id = $name_id[ $c['author'] ];
	}
	if( isset($_GET['old']) && $_GET['old'] == 'true' ) {
		$c['comment'] = addslashes($c['comment']);
	}
	$db->query('INSERT INTO `nlb3_comments` ( `comment_id` , `parent_id` , `author_id` , `date` , `body` , `ip` )
	VALUES (' . "
	'{$c['id']}', 
	'{$c['parent']}', 
	'{$a_id}', 
	'{$c['date']}', 
	'{$c['comment']}', 
	'127.0.0.1'
	);");
}
unset( $all_com );

echo "Done.";
echo "<br>Took " . mymicrotime( $START, 5 ) . " seconds and " . $db->getQueryCount() . " querys.";
echo '<p><font size="+5" color="red">DELETE THIS FILE <B><U>NOW</U></B></FONT>';

?>