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
require_once 'system/nlb_user.class.php';
require_once 'system/nlb_config.class.php';
require_once 'system/nlb_blog.class.php';
require_once 'system/nlb_mail.class.php';
require_once 'system/text.class.php';
require_once 'ets.php';

session_start();

$db = new sqldb2( $DB_CONFIG );
$user = new nlb_user( $db );
$config = new nlb_config( $db );
$blog = new nlb_blog( $db );
$user->checkLogin();

include $config->langfile();

$start = mymicrotime();

$ets = new stdclass;

/**
 * =======================================
 *	S E A R C H   B L O G S
 * =======================================
 */	
 

/*		===== QUERY TEMPLATE ======
SELECT u.username, b.blog_id, b.author_id, b.date, b.subject, b.body, b.comments, b.html, b.smiles, b.bb,
FROM nlb3_blogs AS b, nlb3_users AS u
WHERE u.user_id = b.author_id AND b.access = public AND b.body LIKE "%text%" AND 
LIMIT 0 , 10
END_Q;
*/

if( isset($_GET['page']) && isset( $_SESSION['results'] ) && isset($_SESSION['query']) ) {
	
	//------------------------
	//		PRINT RESULTS
	//------------------------
	
	$mask = 'results';
	$page = $_GET['page'] + 0;	// easy cast to int
	
	$start = $page * 10;
	$end = $start + 10;
	
	$url = build_link('search.php?page=%d');
	
	
	if( $page > 0 ) {
		$ets->url_prev = sprintf($url, $page-1);
	}
	if( $end < $_SESSION['results'] ) {
		$ets->url_next = sprintf($url, $page+1);
	}
	
	
	
	$ets->matches = $_SESSION['results'];
	
	$q = $_SESSION['query'];
	$q .= " \nORDER BY b.date DESC \nLIMIT $start, $end;";
	
	$page = $db->getAllArray($q);
	
	$i = 0;
	foreach( $page as $b ) {
		stripslashes_array($b);
		$ets->entries[$i]->author = $b['username'];
		$ets->entries[$i]->url = build_link('blog.php',array('id'=>$b['blog_id']));
		$ets->entries[$i]->subject = $b['subject'];
		$ets->entries[$i]->comments = $b['comments'];
		
		if( $b['html'] == 0 ) {
			$b['body'] = htmlspecialchars($b['body']);
		}
		if( $b['bb'] == 1 ) {
			$b['body'] = insertBBCode($b['body']);
		}
		$b['body'] = nl2br($b['body']);
		
		$ets->entries[$i]->body = truncate($b['body'], 800);
		$ets->entries[$i]->date = date($config->get('recent_blog_date',$b['date']));
		
		$i++;
	}
	
//  	debug($q,"THE QUERY");
//  	debug($ets,'ETS Data');
//  	debug($_SESSION,'_SESSION');
//  	die();
	
} else {
	
	if( isset($_POST['q']) ) {
		
		//------------------------
		//		BUILD QUERY AND OTHER PRE-QUERY TASKS
		//------------------------
		
		$mask = 'redirect';
		
		$q = slash_if_needed($_POST['q']);
		
		// build the query!
		$searchBody = isset($_POST['body']);
		$searchSubject = isset($_POST['subject']);
		if( !$searchBody && !$searchSubject ) $serachBody = true;
		
		$query = 'SELECT u.username, b.blog_id, b.author_id, b.date, b.subject, b.body, b.comments, b.html, b.smiles, b.bb
FROM nlb3_blogs AS b, nlb3_users AS u
WHERE u.user_id = b.author_id AND b.access = ' . access_public;
		
		$rquery = 'SELECT count(b.blog_id) as results
FROM nlb3_blogs AS b, nlb3_users AS u
WHERE u.user_id = b.author_id AND b.access = ' . access_public;

		if( $searchBody ) {
			$query .= ' AND b.body LIKE "%' . $q . '%"';
			$rquery .= ' AND b.body LIKE "%' . $q . '%"';
		}
		if( $searchSubject ) {
			$query .= ' AND b.subject LIKE "%' . $q . '%"';
			$rquery .= ' AND b.subject LIKE "%' . $q . '%"';
		}
		
		if( isset($_POST['author']) && $_POST['author'] != "" ) {
			$authorid = $user->getIdByName(slash_if_needed($_POST['author']));
			if( $authorid != -1 ) {
				$query .= ' AND b.author_id = ' . $authorid;
				$rquery .= ' AND b.author_id = ' . $authorid;
			}
		}
		
		$count = $db->getArray($rquery);
		if( $count['results'] == 0 ) {
			
			//------------------------
			//		NO RESULTS TO SHOW
			//------------------------
			
			$mask = 'form';
			$ets->noresults = 1;
			
		} else {
			
			//------------------------
			//		WORK IS DONE, REDIRECT USER
			//------------------------
			
			$_SESSION['results'] = $count['results'];
			$_SESSION['query'] = $query;
			$mask = 'redirect';
			$ets->url = build_link('search.php?page=0');
			

		}
	} else {
		
		//------------------------
		//			PRINT INPUT FORM
		//------------------------
		$mask = 'form';
		$ets->url_search = build_link('search.php');
	}
	
}

$ets_outter->main_title = $config->get('site_name') . ': ' . $l['title-search'];
$ets_outter->page_title = $l['title-search'];
$ets_outter->sitenav = buildMainNav( $l, $user );
$ets_outter->script_path = script_path;
$ets_outter->recent_blogs = $blog->getRecent( $config );
$ets_outter->query_count = $db->getQueryCount();
$ets_outter->gen_time = mymicrotime( $start, 5 );
$ets_outter->welcome[] = $user->getWelcomeTags();

printt( $ets_outter, 	skin_header );
printt( $ets, 			skin_search,	$mask );
printt( $ets_outter, 	skin_footer );

?>