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

require_once "system/class.phpmailer.php";

/**
 * Extends phpMailer class <phpmailer.sf.net>
 * Checks MySQL for mail settings.
 *
 * @package NLB3
 * @author Nick F <nick@sevengraff.com>
 * @date 02-06-04
 */
class nlb_mail extends phpmailer {
	
	// if active is false, then we will not send mail.
	var $Active = true;
	
	// where class.smtp.php will be
	var $PluginDir = "system/";

	function nlb_mail( & $db ) {
		
		// get info from db
		$result = $db->getAllArray(" # Getting mail config
		SELECT name, value FROM " . db_config . " 
		WHERE name='site_name' OR
		name='mail_type' OR 
		name='mail_from' OR
		name='smtp_host' OR
		name='smtp_username' OR
		name='smtp_password' OR
		name='sendmail_path'; ");
		
		// load into a more managable array
		$info = array();
		foreach( $result as $row ) {
			$info[ $row['name'] ] = $row['value'];
		}
		
		// use info to setup PHPMailer.
		switch( $info['mail_type'] ) {
			case 'smtp_auth':
				$this->Mailer 	= 'smtp';
				$this->Host 	= $info['smtp_host'];
				$this->Username	= $info['smtp_username'];
				$this->Password = $info['smtp_password'];
				$this->SMTPAuth = true;
			break;
			
			case 'smtp':
				$this->Mailer	= 'smtp';
				$this->Host 	= $info['smtp_host'];
			break;
			
			case 'mail':
				$this->Mailer	= 'mail';
			break;
			
			case 'sendmail';
				$this->Mailer	= 'sendmail';
				$this->Sendmail = $info['sendmail_path'];
			break;
			
			case 'none':
				$this->Active = false;
			break;
		}
		
		// set other stuff...
		$this->From = $info['mail_from'];
		$this->SetLanguage( 'en', 'system/');
		$this->AddCustomHeader('X-NewLifeBlogger: ' . nlb_version);
		$this->FromName = $info['site_name'];
	}
}

?>