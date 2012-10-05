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

require_once 'config.php';				// include this before others!
require_once 'system/functions.php';
require_once 'system/ets_file.php';

require_once 'system/sqldb2.class.php';	// NLB Class library
require_once 'system/nlb_blog.class.php';
require_once 'system/nlb_user.class.php';
require_once 'system/nlb_config.class.php';

require_once 'ets.php';					// Sweet template library

$start = mymicrotime();

$db = new sqldb2( $DB_CONFIG );
$config = new nlb_config( $db );
$user = new nlb_user( $db );

// is someone trying to access a persons blog 
$_SERVER['QUERY_STRING'] = urldecode($_SERVER['QUERY_STRING']);
if( !empty($_SERVER['QUERY_STRING']) && ($id = $user->getIdByName($_SERVER['QUERY_STRING'])) > -1 ) {
// 	die($id);
	//jsRedirect( script_path . 'blog.php/user/' . $id );
	jsRedirect( build_link('blog.php', array('user'=>$id)));
}

$user->checklogin();

require_once $config->langfile();		// include lang file

$b = new nlb_blog( $db );
if( $user->isLogedIn ) {
	// timezone settings
	$b->setDateOffset( $config->get('server_timezone'), $user->get('timezone') );
}

$script_path = script_path;
$_PATH = fetch_url_data();

$action = 'news';
if( isset( $_PATH['action'] ) ) {
	$action = $_PATH['action'];
}

$ets = new stdClass();

switch( $action ) {
	
	// Display Recent News news
	default:
	case 'news':
	
		/**
		 * =======================================
		 *	S H O W   N E W S
		 * =======================================
		 */
	
		$ets_outter->main_title = $config->get('site_name') . ': ' . $l['title-news'];
		$ets_outter->page_title = $l['title-news'];
		
		$page = 0;
		if( isset($_PATH['page']) ) {
			$page = $_PATH['page'];
		}
		
		$q = '# GET NEWS POSTS
		SELECT t1.blog_id, t1.author_id, t1.date, t1.subject, t1.body, t1.access, t1.custom AS custom_text, t1.comments, t1.html, t1.smiles, t1.bb, t2.username AS author, t2.custom AS custom_title
		FROM ' . db_blogs . ' AS t1, ' . db_users . ' AS t2
		WHERE t1.author_id = t2.user_id AND t1.access = ' . access_news . '
		ORDER BY t1.date DESC
		LIMIT ' . $page . ' , ' . $config->get('news_per_page') . ' ;';
		$newsitems = $db->getAllArray( $q );
		$b->setDate( $config->get('news_date_format') );
		foreach( $newsitems as $news ) {
			$b->setData( $news );
			$ets->news[] = $b->format(false, $user, $l['edit']);
		}
		$USESKIN = skin_news;
	break;
	
	case 'comment':
	
		/**
		 * =======================================
		 *	N E W S   C O M M E N T S
		 * =======================================
		 */
		
		$USESKIN = skin_news;
		$ets_outter->main_title = $config->get('site_name') . ': ' . $l['title-news'];
		$ets_outter->page_title = $l['title-news'];
		if( !isset($_PATH['id']) ) {
			jsRedirect('index.php');
		}
		$id = $_PATH['id'];
		if( !is_numeric($id) ) {
			jsRedirect( script_path . 'index.php' );
		}
		$data = $db->getArray(' # Get one news post
		SELECT t1.blog_id, t1.author_id, t1.date, t1.subject, t1.body, t1.access, t1.custom AS custom_text, t1.comments, t1.html, t1.smiles, t1.bb, t2.username AS author, t2.custom AS custom_title
		FROM ' . db_blogs . ' AS t1, ' . db_users . ' AS t2
		WHERE t1.blog_id = "' . $id . '" AND t1.author_id = t2.user_id
		LIMIT 1;');
		$b->setDate( $config->get('news_date_format') );
		$ets->news[0] = $b->format( $data, $user, $l['edit'] );

		// get comments.
		$ets->list_comments = $b->getComments( $id, $config->get('comment_date_format'), $l['guest'], $user, $l['edit'] );

		// form to add comment
		$name = $user->isLogedIn ? $user->get('username') : $l['guest'];
		$submit_text = sprintf($l['comment_submit'], $name);
		$ets->add_comment = '
		<script type="text/javascript">
			function insertWindow( gotopage ) {
				window.open( gotopage, \'newwindow\',\'toolbar=0,location=0,directories=0,menuBar=0,resizable=1,scrollbars=yes,width=400,height=500,left=20,top=20\');
			}
		</script>
		<form method="post" action="' . script_path . 'addcomment.php" name="new_entry">
		<input type="hidden" name="parent" value="' . $data['blog_id'] . '">
		<textarea name="body" class="nlb_add_comment"></textarea> <br>
		<input class="nlb_add_comment" type="submit" value="' . $submit_text . '">
		</form>';
		$ets->link_smiles = $l['link_smiles'];
		$ets->link_bbcode = $l['link_bbcode'];
		$ets->link_bbcode = $l['link_bbcode'];
		$ets->link_smiles = $l['link_smiles'];
		if( $b->data['comments'] != -1 ) {
			$ets->view_comments = true;
		} else {
			$ets->view_comments = true;
		}
		
	break;
	
	case 'article':
	
		/**
		 * =======================================
		 *	V I E W   A R T I C L E
		 * =======================================
		 */
	
		if( !isset($_PATH['id']) ) {
			jsredirect('index.php/action/list_articles');	// no id specified, redirect to list of articles.
		} else {
			$id = (int) $_PATH['id'];
		}
		
		$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-art-view'];
		$ets_outter->page_title = $l['title-art-view'];
		
		$USESKIN = skin_article_view;
		$a = $db->getArray("# GETTING A ARTICLE
		SELECT a. * , u.user_id, u.username
		FROM " . db_articles . " AS a, " . db_users . " AS u
		WHERE a.article_id = " . $id . " AND a.author_id = u.user_id
		LIMIT 1;");
		foreach( $a as $key => $val ) {
			$a[$key] = stripslashes( $val );
		}
		$ets->subject 				= $a['subject'];
		$ets->body 					= nl2br( $a['body'] );
		$ets->author 				= $a['username'];
		$ets->author_url_blogs		= build_link('blog.php', array('user'=>$a['user_id']));
		$ets->author_url_profile	= build_link('profile.php', array('user'=>$a['user_id']));
		$ets->date					= date( $config->get('art_date_view'), $a['date']);
				
	break;
	
	case 'list_articles':
	
		/**
		 * =======================================
		 *	L I S T   A R T I C L E S
		 * =======================================
		 */		
	
		$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-art-list'];
		$ets_outter->page_title = $l['title-art-list'];
	
		$USESKIN = skin_article_list;
		$all = $db->getAllArray("# GETTING ALL ARTICLES
		SELECT a.article_id, a.subject, a.date, u.user_id, u.username
		FROM " . db_articles . " AS a, " . db_users . " AS u
		WHERE a.author_id = u.user_id
		ORDER BY a.date DESC;");
		$i = 0;
		$ets->articles = array();
		foreach( $all as $a ) {
			stripslashes_array( $a );
			$ets->articles[$i]->subject 			= $a['subject'];
			$ets->articles[$i]->date				= date( $config->get('art_date_list'), $a['date'] );
			$ets->articles[$i]->author 				= $a['username'];
			$ets->articles[$i]->url_article			= build_link('index.php', array('action'=>'article', 'id'=>$a['article_id']));
			$ets->articles[$i]->author_url_profile	= build_link('profile.php', array('user'=>$a['user_id']));
			$ets->articles[$i]->author_url_blogs	= build_link('blog.php', array('user'=>$a['user_id']));
			$i++;
		}
	break;
	
	case 'validate':
	
		/**
		 * =======================================
		 *	V A L I D A T E   U S E R
		 * =======================================
		 */	
	
		// validate a users email address.
		$ets->page_body = "";
		$USESKIN = skin_basic;
		if( $user->isLogedIn || !isset($_PATH['code']) ) {
			$ets->page_body .= $l['validate_failed'];
		} else {
			$code = $_PATH['code'];
			$info = $db->getArray('SELECT * FROM ' . db_validate . ' WHERE code="' . $code . '" LIMIT 1;');
			if( empty( $info ) ) {
				$ets->page_body .= $l['validate_failed'];
			} else {
				// validate the user & remove the row.
				$db->query('UPDATE ' . db_users . ' SET valid=1 WHERE user_id=' . $info['owner_id'] . ' LIMIT 1;');
				$db->query('DELETE FROM ' . db_validate . ' WHERE validate_id=' . $info['validate_id'] . ' LIMIT 1;');
				$ets->page_body .= $l['validate_good'];
			}
		}
		$ets_outter->main_title = $config->get('site_name') . ': ' . $l['title-validate'];
		$ets_outter->page_title = $l['title-validate'];
		
	break;

}

$ets_outter->sitenav = buildMainNav( $l, $user );
$ets_outter->recent_blogs = $b->getRecent( $config );
$ets_outter->query_count = $db->getquerycount();
$ets_outter->script_path = $script_path;
$ets_outter->gen_time = mymicrotime( $start, 5 );
$ets_outter->welcome[] = $user->getWelcomeTags();

printt($ets_outter, 	skin_header);
printt($ets, 			$USESKIN );
$ets_outter->gen_time = mymicrotime( $start, 5 );
printt($ets_outter, 	skin_footer);

?>