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
require_once 'system/nlb_config.class.php';
require_once 'system/nlb_user.class.php';
require_once 'system/nlb_blog.class.php';
require_once 'ets.php';

$start = mymicrotime();

$db = new sqldb2($DB_CONFIG);
$blog = new nlb_blog($db);
$user = new nlb_user($db);
$config = new nlb_config($db);

include $config->langfile();
$user->checkLogin();

if( $user->isLogedIn ) {
	// timezone
	$blog->setDateOffset( $config->get('server_timezone'), $user->get('timezone') );
}

//
// T O T A L S
//

// public blogs
$tmp = $db->getArray('SELECT COUNT(blog_id) AS c FROM ' . db_blogs . ' WHERE access="' . access_public . '";');
$total_public = $tmp['c'];

// private blogs
$tmp = $db->getArray('SELECT COUNT(blog_id) AS c FROM ' . db_blogs . ' WHERE access="' . access_private . '";');
$total_private = $tmp['c'];

// valid users
$tmp = $db->getArray('SELECT COUNT(user_id) AS c FROM ' . db_users . ' WHERE valid=1;');
$total_users = $tmp['c'];

// comments
$tmp = $db->getArray('SELECT COUNT(comment_id) AS c FROM ' . db_comments . ' ;');
$total_comments = $tmp['c'];

//
// R E C E N T   (last 24 hours).
//

$past = strtotime('-1 day');

// comments 
$tmp = $db->getArray('SELECT COUNT(comment_id) AS c FROM ' . db_comments . ' WHERE date >= ' . $past . ';');
$recent_comments = $tmp['c'];

// blogs
$tmp = $db->getArray('SELECT COUNT(blog_id) AS c FROM ' . db_blogs . ' WHERE date >= ' . $past . ' AND access="' . access_public . '";');
$recent_blogs = $tmp['c'];

// users
$tmp = $db->getArray('SELECT COUNT(user_id) AS c FROM ' . db_users . ' WHERE registered >= ' . $past . ' AND valid=1');
$recent_users = $tmp['c'];

//
// N E W E S T
//

// user
$new_user = $db->getArray('SELECT username, user_id FROM ' . db_users . ' WHERE valid=1 ORDER BY registered DESC LIMIT 1;');

// blog
$new_blog = $db->getArray('SELECT b.blog_id, b.subject, u.username, u.user_id
FROM ' . db_blogs . ' AS b, ' . db_users . ' AS u
WHERE b.author_id = u.user_id AND b.access = ' . access_public . '
ORDER BY b.date DESC
LIMIT 1;');

// comment
$new_comment = $db->getArray('SELECT u.user_id, u.username, c.parent_id
FROM ' . db_users . ' AS u, ' . db_comments . ' as c
WHERE u.user_id != -1 AND u.user_id = c.author_id
ORDER BY c.date DESC
LIMIT 1;');

$ets->total_public 		= $total_public;
$ets->total_private 	= $total_private;
$ets->total_users 		= $total_users;
$ets->total_comments 	= $total_comments;

$ets->recent_blogs 		= $recent_blogs;
$ets->recent_comments 	= $recent_comments;
$ets->recent_users 		= $recent_users;

$ets->new_user_url		= build_link('profile.php', array('user'=>$new_user['user_id']));
$ets->new_user_username	= $new_user['username'];

$ets->new_blog_url		= build_link('blog.php', array('id'=>$new_blog['blog_id']));
$ets->new_blog_subject	= $new_blog['subject'];
$ets->new_blog_user_url	= build_link('profile.php', array('user'=>$new_blog['user_id']));
$ets->new_blog_username	= $new_blog['username'];

$ets->new_comment_url		= build_link('blog.php', array('id'=>$new_comment['parent_id']));
$ets->new_comment_user_url	= build_link('profile.php', array('id'=>$new_comment['user_id']));
$ets->new_comment_username	= $new_comment['username'];

//
// Default 24 hour stats template:
//
// {set:new_user_username}
// Newest user is <a href="{new_user_url}">{new_user_username}</a>.<br />
// {/set}
//
// {set:new_blog_username}
// Newest Blog is <a href="{new_blog_url}">{new_blog_subject}</a> Posted by
// 	<a href="{new_blog_user_url}">{new_blog_username}"></a>. <br />		
// {/set}
//
// {set:new_comment_username}
// <a href="{new_comment_url}">Newest Comment</a> Was posted by
// <a href="{new_comment_user_url}">{new_comment_username}</a>
// {/set}
//

// Outer template setup
$ets_outter->main_title = $config->get('site_name') . ': ' . $l['title-stats'];
$ets_outter->page_title = $l['title-stats'];

$ets_outter->sitenav = buildMainNav( $l, $user );
$ets_outter->recent_blogs = $blog->getRecent( $config );
$ets_outter->query_count = $db->getquerycount();
$ets_outter->script_path = script_path;
$ets_outter->gen_time = mymicrotime( $start, 5 );
$ets_outter->welcome[] = $user->getWelcomeTags();

printt( $ets_outter, skin_header );
printt( $ets,		 skin_stats );
printt( $ets_outter, skin_footer );

?>