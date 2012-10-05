<?PHP

/*
	-----------------------------------------
		NewLife Blogging System Version 3
	-----------------------------------------
	Nick F <nick@sevengraff.com>
	www.sevengraff.com
	-----------------------------------------
	This product is distributed under the GNU
	GPL liscense. A copy of that liscense 
	should be packaged with this product.
	-----------------------------------------
*/

require_once 'config.php';				
require_once 'system/functions.php';
require_once 'system/ets_file.php';

require_once 'system/sqldb2.class.php';	
require_once 'system/nlb_blog.class.php';
require_once 'system/nlb_user.class.php';
require_once 'system/nlb_config.class.php';
require_once 'system/text.class.php';

require_once 'ets.php';					

$start = mymicrotime();

$db = new sqldb2( $DB_CONFIG );
$config = new nlb_config( $db );
$blog = new nlb_blog( $db );

$user = new nlb_user( $db );
$user->checklogin();

if( !isset($_POST['parent']) || empty($_POST['parent']) ) {
	jsRedirect('index.php');
}

$parent = $_POST['parent'];

// get some info about this blog
$info = $db->getArray('SELECT access, comments FROM ' . db_blogs . ' WHERE blog_id="' . $parent . '" LIMIT 1;');

// if anything goes wrong, decide where we will go.
if( $info['access'] == access_news ) {
	$go = build_link('index.php', array('action'=>'comment', 'id'=>$parent));
} else {
	$go = build_link('blog.php', array('id'=>$parent));
}

// are we alowed to blog here?
if( $info['comments'] == -1 ) {
	jsRedirect( $go );
}

// do we have any data to submit?
if( !isset( $_POST['body'] ) || empty( $_POST['body'] ) ) {
	jsRedirect( $go );
}

$body = slash_if_needed( $_POST['body'] );

// add to db.
$ip = $_SERVER['REMOTE_ADDR'];
$date = time();
if( $user->isLogedIn ) {
	$userid = $user->id;
} else {
	$userid = -1;
}
$db->query("INSERT INTO `" . db_comments . "` ( `comment_id` , `parent_id` , `author_id` , `date` , `body` , `ip` )
VALUES (
'', '$parent', '$userid', '$date', '$body', '$ip'
);");

$db->query('UPDATE ' . db_blogs . ' SET comments = comments + 1 WHERE blog_id = ' . $parent . ';');

// we are done.
jsRedirect( $go );

?>