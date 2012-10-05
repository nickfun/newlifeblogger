<?PHP


/**
 * =======================================
 *		V I E W
 * =======================================
 */	
 
if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}

 
$USESKIN = skin_basic;
$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-usercp'];
$ets_outter->page_title = $l['title-view'];

$name = $user->get('username');

// get number of private blogs
$private = $db->getArray('SELECT COUNT(blog_id) AS c 
FROM ' . db_blogs . ' 
WHERE access=' . access_private . '
AND author_id="' . $user->get('user_id') . '";');
$private = $private['c'];

$body = $l['ucp-view-blogs'];
$body = str_replace("%PUBLIC%", $user->get('blog_count'), $body);
$body = str_replace("%PRIVATE%", $private, $body);
$body = str_replace("%USER%", $user->get('username'), $body);
$body = str_replace("%LINK%", build_link('blog.php', array('user'=>$user->id)), $body);

$ets->page_body = $body;

?>