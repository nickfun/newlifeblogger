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

$db = new sqldb2( $DB_CONFIG );
$user = new nlb_user( $db );
$config = new nlb_config( $db );
$blog = new nlb_blog( $db );
$user->checkLogin();

// check for loged in user.
if( $user->isLogedIn ) {
	jsRedirect("index.php");
}

include $config->langfile();

$start = mymicrotime();

$text = new Text( $_POST,
	array('username', 'password', 'confirm-password', 'email', 'template', 'timezone'),
	array('custom')
);
$text->validate();
$clean = $text->clean;

$baddata = false;
$problems = array();

if( !empty( $_POST )  ) {
	if( $text->is_missing_required ) {
		$baddata = true;
	}
	// if there was good submitted data...
	if( $clean['password'] != $clean['confirm-password'] ) {
		$baddata = true;
		$problems[] = $l['reg-badpassword'];
	}
	// valid email?
	if( !pear_check_email( $clean['email'] ) ) {
		$baddata = true;
		$problems[] = $l['reg-bademail'];
	}
	// check if username exists
	if( $user->userExists($clean['username']) ) {
		$baddata = true;
		$problems[] = $l['reg-badusername'];
	}
	// email in use?
	$echeck = $db->getArray("SELECT count(*) as c FROM " . db_users . " WHERE email = '" . slash_if_needed( $clean['email'] ) . "';");
	if( $echeck['c'] >= 1 ) {
		$baddata = true;
		$problems[] = $l['reg-usedemail'];
	}
	
	// see if template files exist & we have access to them.
	if( !nlb_user::templateExists( $clean['template'] ) ) {
		$baddata = true;
		$problems[] = $l['reg-badtemplatechoice'];
	}
	
	if( !$baddata ) {

		/**
		 *      A D D   U S E R
		 */
		
		$text->makeClean( 'slash_if_needed', 'trim' );
		$c = $text->clean;
		$timezone = $c['timezone'] - 13;
				
		$new = array(
			'username'			=> $c['username'],
			'password'			=> md5( $c['password'] ),
			'email'				=> $c['email'],
			'access'			=> $config->get('default_access'),
			'registered'		=> time(),
			'last_login'		=> time(),
			'ip'				=> $_SERVER['REMOTE_ADDR'],
			'blog_count'		=> 0,
			'timezone'			=> $timezone,
			'bio'				=> "",
			'custom'			=> $c['custom'],
			'date_format'		=> $config->get('default_date_format'),
			'birthday'			=> "",
			'perpage'			=> 10,
			'gender'			=> 0
		);
		
		$check_email = $config->get('validate_email');
		if( $check_email == "true" ) {
			// include mail class thing.
			$new['valid'] = 0;
		} else {
			$new['valid'] = 1;
		}
		
		$id = $user->newUser( $new );
		unset( $user);
		$user = new nlb_user( $db, $id );
			
		// add template into DB.
		
		$date = 1000000;	// make the cache in the past so ETS will update it.
		
		$db->query( 'INSERT INTO ' . db_source . " ( 
		`owner_id` , `blog` , `blog_updated` , `friends` , `friends_updated` , `profile` , `profile_updated` )
		VALUES (
		'$id', 'empty', '$date', 'empty', '$date', 'empty', '$date'
		);" );
		
		$db->query( 'INSERT INTO ' . db_cache . " ( 
		`owner_id` , `blog` , `blog_updated` , `friends` , `friends_updated` , `profile` , `profile_updated` )
		VALUES (
		'$id', 'empty', '$date', 'empty', '$date', 'empty', '$date'
		);" );
		
		$user->setTemplateSource( $clean['template'], $config->get('home_text') );
		
		// did the first user just register?
		if( $id == 1 ) {
			$user->grant('admin');
			$user->updateDB();
		}
		
		$sent = $user->validateEmail( $config );
					
		$ets->page_body = $l['reg-done'];
		if( $sent ) {
			$ets->page_body .= $l['reg-checkmail'];
		}
	}
}

if( empty( $_POST ) || $baddata ) {
	if( (!empty($_POST) && $text->is_missing_required ) ) {
		foreach( $text->missing_fields as $miss ) {
			$problems[] = $l['missing-field'] . $miss;
		}
		$baddata = true;
	}
	
	// build timezone options.
	$timezone = build_timezone_list( $config->get('server_timezone') );
	
	// build template preview <select> data
	$dir = dir( template_folder );
	while($file = $dir->read()) {
		if( strtolower( getFileExt($file) ) == 'gif') {
			$preview[] = $file;
		}
	}
	$dir->close();
	$st = '<select name="template" onchange="document.images.temlpatePreview.src = \'templates/\' + this[this.selectedIndex].value + \'.gif\';">';
	$st .= "\n";
	foreach( $preview as $img ) {
		$name = str_replace('_', ' ', $img);
		$name = substr($name, 0, -4);	// to remove .gif
		$img = substr( $img, 0, -4);
		$st .= '<option value="' . $img . '">' . $name . '</option>' . "\n";
		//$st .= '<option value="./templates/' . $img . '">' . $name . "</option>\n";
	}
	$st .= "\n</select>\n";
	$st .= '<br /><img name="temlpatePreview" src="./templates/' . $preview[0] . '" />';
	
	// build form.
	$form->action = 'register.php';
	$form->method = 'post';
	$form->class = 'nlb_form';
	$table->class = 'nlb_table';
	
	$i = 1;
	$t[$i]->name = 'username';
	$t[$i]->type = 'text';
	$t[$i]->desc = $l['username:'];

	$i++;
	$t[$i]->name = 'password';
	$t[$i]->type = 'password';
	$t[$i]->desc = $l['password:'];
	
	$i++;
	$t[$i]->name = 'confirm-password';
	$t[$i]->type = 'password';
	$t[$i]->desc = $l['reg-pass-confirm'];
	
	$i++;
	$t[$i]->name = 'email';
	$t[$i]->type = 'text';
	$t[$i]->desc = $l['reg-email'];
	
	$i++;
	$t[$i]->name = 'custom';
	$t[$i]->type = 'text';
	$t[$i]->desc = $l['reg-custom-field'];
	
	$i++;
	$t[$i]->name = 'timezone';
	$t[$i]->desc = $l['reg-timezone'];
	$t[$i]->value = $timezone;
	$t[$i]->type = "select";
	
	$i++;
	$t[$i]->type = 'data';
	$t[$i]->desc = $l['reg-template'];
	$t[$i]->value = $st;
	
	$i++;
	$t[$i]->type = 'submit';
	$t[$i]->value = $l['submit'];
	$t[$i]->center = true;
	//$t[$i]->desc = " ";
	// check for errors
	$errors = '';
	if( $baddata ) {
		$errors = '<div class="error">' . $l['data-problems'] . '<br />';
		foreach( $problems as $p ) $errors .= '<li>' . $p . "</li>\n";
		$errors .= "</div> \n";
	}
	$ets->page_body = $errors . build_form( $t, $form, $table, $clean );
}

$ets_outter->main_title = $config->get('site_name') . ': ' . $l['title-newuser'];
$ets_outter->page_title = $l['title-newuser'];
$ets_outter->sitenav = buildMainNav( $l, $user );
$ets_outter->script_path = script_path;
$ets_outter->recent_blogs = $blog->getRecent( $config );
$ets_outter->query_count = $db->getQueryCount();
$ets_outter->gen_time = mymicrotime( $start, 5 );
$ets_outter->welcome[] = $user->getWelcomeTags();

printt( $ets_outter, 	skin_header );
printt( $ets, 			skin_basic );
printt( $ets_outter, 	skin_footer );

?>