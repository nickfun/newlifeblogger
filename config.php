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

/**
 * =======================================
 *		D A T A B A S E   I N F O
 * =======================================
 *
 * Change these values to let NLB3 know where MySQL
 * is and how to connect.
 */
$DB_CONFIG['username'] =	"root";			// Username
$DB_CONFIG['password'] = 	"";				// Password
$DB_CONFIG['location'] = 	"localhost";	// Location
$DB_CONFIG['database'] = 	"nlb3";			// Database

/**
 * =======================================
 *		P A T H   I N F O
 * =======================================
 *
 * Path Information about your site
 *
 * Ex: you want to install NLB3 so it looks like this:
 *			http://www.sample.com/free/journals
 *
 * then make full_url be http://www.sample.com
 * and have script_path be /free/journals/
 * MAKE SURE that script_path starts and ends with a slash!
 *
 * Another Ex: You want to install NLB3 at http://blogs.sample.com/
 * Then have full_url be http://blogs.sample.com
 * and have script_path be /
 *
 */
define( 'full_url',			'http://domain.com');			// *NO* TRAILING SLASH!
define( 'script_path',		'/nlb3/');						// YES TRAILING SLASH!!

/**
 * =======================================
 *		L I N K   T Y P E
 * =======================================
 *
 * Set to 'path' *ONLY* if your host allows for path info to be set.
 * otherwise, leave as 'get'
 *
 */
define( 'FETCH_TYPE',		'get');

/**
 * =======================================
 *		YOU CAN STOP EDITING 
 * =======================================
 */

/**
 * The names of the tables that NLB3 uses.
 */
define( 'db_prefix',	'nlb3_');	// table prefix.
define( 'db_config',	db_prefix . 'config');
define( 'db_blogs',		db_prefix . 'blogs');
define( 'db_users',		db_prefix . 'users');
define( 'db_articles',	db_prefix . 'articles');
define( 'db_smiles',	db_prefix . 'smiles');
define( 'db_comments',	db_prefix . 'comments');
define( 'db_source',	db_prefix . 'template_source');
define( 'db_cache',		db_prefix . 'template_cache');
define( 'db_validate',	db_prefix . 'validate');
define( 'db_friends',	db_prefix . 'friends');
define( 'db_avatars',	db_prefix . 'avatars');

define( 'db_banned',	db_prefix . 'banned');

/**
 * Folder with _user_ template files
 */
define( 'template_folder',	'templates/' );

/**
 * Location of skin files
 */
define( 'skin_dir',				'skin/' );
define( 'cache_dir',			'skin_cache/');
define( 'skin_header',  		'header.ets');
define( 'skin_footer',			'footer.ets');
define( 'skin_news',			'news.ets' );
define( 'skin_basic',			'basic.ets');
define( 'skin_article_list',	'article_list.ets');
define( 'skin_article_view',	'article_view.ets');
define( 'skin_members',			'members.ets');
define( 'skin_insert',			'insert.ets');
define( 'skin_blog_list',		'blog_list.ets');
define( 'skin_stats',			'stats.ets');
define( 'skin_search',			'search.ets');

/**
 * Extra Info
 */
define( 'nlb_version',			'3.3');

define( 'access_public',		1 );
define( 'access_friendsonly',	2 );
define( 'access_private',		3 );
define( 'access_news',			4 );

define( 'avatar_default',		1 );
define( 'avatar_friends',		2 );
define( 'avatar_comments',		3 );

/**
 * Do not mess with this
 * Yes it's inspiried by LDU. LDU rocks :D
 */

$js_insert_window = <<< END_JAVASCRIPT
<script type="text/javascript">
	function insertWindow( gotopage ) {
		window.open( gotopage, 'newwindow','toolbar=0,location=0,directories=0,menuBar=0,resizable=1,scrollbars=yes,width=400,height=500,left=20,top=20');
	}
</script>
END_JAVASCRIPT;

?>