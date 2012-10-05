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

require_once 'ets.php';
require_once 'system/text.class.php';
require_once 'system/sqldb2.class.php';
require_once 'system/nlb_user.class.php';
require_once 'system/nlb_blog.class.php';
require_once 'system/nlb_mail.class.php';
require_once 'system/nlb_config.class.php';

$start = mymicrotime();

$db = new sqldb2( $DB_CONFIG );
$config = new nlb_config( $db );
$user = new nlb_user( $db );
$b = new nlb_blog( $db );

include $config->langfile();

if( $user->isLogedIn ) {
	$b->setDateOffset( $config->get('server_timezone'), $user->get('timezone') );
}

$action = 'login';
if( isset($_GET['action']) ) {
	$action = $_GET['action'];
}

switch( $action ) {
	
	// build login form.
	default:
	case 'login':
	
		$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-login'];
		$ets_outter->page_title = $l['title-login'];
	
		$logedin = $user->checklogin();
		
		if( $logedin ) {
			jsRedirect('index.php');	// we are already loged in.
		}
		
		$text = new text( $_POST, array('username', 'password') );
		$text->validate();
		$text->makeClean('slash_if_needed', 'trim');
		$clean = $text->clean;
		
		$errors = array();
		$baddata = false;
		
		if( !empty( $_POST ) ) {
			// data was submitted, check to see if it's good
			$clean = $text->clean;
			
			if( $text->is_missing_required ) 
				$baddata = true;

			// username exists?
			if( !$baddata && !$user->userExists( $clean['username'] ) ) {
				$baddata = true;
				$errors[] = $l['log-bad-user'];
			}
			// password works for username?
			if( !$baddata && !$user->checkPass( $clean['password'], $clean['username'] ) ) {
				$baddata = true;
				$errors[] = $l['log-bad-pass'];
			}
			// login user?
			if( !$baddata ) {
				$user->setIdByName( $clean['username'] );
				if( $user->get('valid') == 1 ) {
					// user is valid
					$user->login( $config->get('login_time') );
					$ets->page_body = $l['log-good'];
				} else {
					$ets->page_body = $l['log-check-email'];
				}
			}
		}			
			
		if( empty( $_POST ) || $baddata ) {
			
			if( !empty($_POST) && $text->is_missing_required ) {
				$baddata = true;
				foreach( $text->missing_fields as $miss ) {
					$errors[] = $l['missing-field'] . $miss;
				}
			}
			$form->action = "login.php";
			$form->method = "post";
			$form->class = "nlb_form";
			$table->class = "nlb_table";
			
			$i = 0;
			$t[$i]->desc = $l['username:'];
			$t[$i]->name = 'username';
			$t[$i]->type = 'text';
			
			$i++;
			$t[$i]->desc = $l['password:'];
			$t[$i]->name = 'password';
			$t[$i]->type = 'password';
			
			$i++;
			$t[$i]->type = 'submit';
			$t[$i]->value = $l['submit'];
			
			$input_form = build_form( $t, $form, $table, $clean );
			$ets->page_body = '';
			if( $baddata ) {
				$ets->page_body .= '<div class="error">' . $l['data-problems'] . '<br />';
				foreach( $errors as $p ) $ets->page_body .= '<li>' . $p . "</li>\n";
				$ets->page_body .= '</div><br>';
			}
			$ets->page_body .= $input_form;	
			
			$ets->page_body .= '<p><a href="' . script_path . 'login.php?action=forgot">';
			$ets->page_body .= $l['log-forgot-text'] . '</a></p>';
		}
	break;
	
	case 'logout':
		$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-logout'];
		$ets_outter->page_title = $l['title-logout'];
		$user->logout();
		$ets->page_body = $l['log-out'];
	break;
	
	case 'forgot':
	
		$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-forgot'];
		$ets_outter->page_title = $l['title-forgot'];
		$ets->page_body = '';
	
		$mail = new nlb_mail( $db );
		if( !$mail->Active ) {
			$ets->page_body = $l['log-forgot-off'];
			break;	// exit the big switch()
		}
	
		$err = array();
		
		if( !empty($_POST) ) {
			
			if( !isset($_POST['username']) || empty($_POST['username']) ) {
				$err[] = $l['log-bad-user'];	// bad username
			} else {
				
				$username = slash_if_needed($_POST['username']);
				if( !$user->userExists($username) ) {
					$err[] = $l['log-bad-user'];
				} else {
					// build new user object to manip his data
					$client = new nlb_user( $db );
					$id = $client->getIdByName( $username );
					$client->setId( $id );
					
					// create new password. 6 random letters + numbers
					$newpass = uniqid(rand(), true);
					$newpass = substr($newpass, 0, 6);
					$hash = md5($newpass);
					
					$link = full_url . script_path . 'login.php';					
					$message = $l['log-forgot-email'];
					$message = str_replace('%USERNAME%', $client->get('username'), $message);
					$message = str_replace('%PASSWORD%', $newpass, $message);
					$message = str_replace('%LINK%', $link, $message);
					
					$mail->AddAddress( $client->get('email'), $client->get('username') );
					$mail->Subject = $config->get('site_name') . $l['log-forgot-subject'];
					$mail->Body = $message;
					
					if( !$mail->Send() ) {
						// if we can't send the email, then don't write the
						// new password in the db
						$ets->page_body = $l['log-forgot-failed'];
						break;
					} else {
						// email was sent, set the password to something new
						$client->set('password', $hash);
						$client->updateDB();
						$ets->page_body = $l['log-forgot-success'];
					}
				}
			}
		}
		
		if( empty($_POST) || !empty($err) ) {
			if( !empty($err) ) {
				$ets->page_body = input_error_box( $err );
			}
				
			// build input	
			$form->action = script_path . 'login.php?action=forgot';
			$form->method = 'post';
			$form->class = 'nlb_form';
			$form->name = 'new_entry';
			$table->class = 'nlb_table';
			$table->width = "100%";
			
			// USERNAME
			$i = 0;
			$f[$i]->type = 'text';
			$f[$i]->name = 'username';
			$f[$i]->desc = $l['username:'];
			
			// SUBJECT
			$i++;
			$f[$i]->type = 'submit';
			$f[$i]->desc = $l['submit'];
			$f[$i]->value = $l['submit'];
			
			$ets->page_body .= build_form( $f, $form, $table, $_POST);
			
		}

	break;
			
}

$ets_outter->recent_blogs = $b->getRecent( $config );
$ets_outter->sitenav = buildMainNav( $l, $user );
$ets_outter->gen_time = mymicrotime( $start, 5 );
$ets_outter->query_count = $db->getquerycount();
$ets_outter->script_path = script_path;
$ets_outter->welcome[] = $user->getWelcomeTags();

printt( $ets_outter, 	skin_header );
printt( $ets,			skin_basic );
printt( $ets_outter, 	skin_footer );

// debug( $_COOKIE )

?>