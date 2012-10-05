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

/**
 * HEADERS TO STOP CACHING
 */
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    			// Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  // always modified
header("Cache-Control: no-store, no-cache, must-revalidate");   // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");                          			// HTTP/1.0

/**
 * Refrence of how many seconds are in specified length of time.
 */
$TIMES = array(
    'sec' => 1,
    'min' => 60,
    'hour' => 3600,
    'day' => 86400,
    'week' => 604800,
    'month' => 2592000,
    'year' => 31536000
);



/**
 * @return string
 * @param array
 * @desc Builds the <div> error warning for output
 * @date 03-19-04
 */
function input_error_box( $errors ) {
	global $l;
	
	if( empty($errors) ) return '';
	
	$box = '<div class="error">' . $l['data-problems'] . '<br />';
	foreach( $errors as $e ) {
		$box .= '<li>' . $e . "</li>\n";
	}
	$box .= "</div>\n";
	
	return $box;
}

/**
 * @return array
 * @desc Abstraction to get data from _GET or path types.
 * @date 12-20-03
 */
function fetch_url_data() {
	if( !defined('FETCH_TYPE') || FETCH_TYPE != 'path' ) {
		// build from get
		return $_GET;
	} else {
		// build from path
		$_PATH = array();
		if( isset($_SERVER['PATH_INFO']) ) {
			$getdata = explode('/', $_SERVER['PATH_INFO']);
			$getcount = count($getdata);
			if( $getcount % 2 == 0 ) {
				$getdata[] = '';
				$getcount++;
			}
			for( $i = 1; $i < $getcount; $i += 2) {
				$_PATH[$getdata[$i]] = $getdata[$i+1];
			}
		}
		return $_PATH;
	}
}

/**
 * @return string
 * @param string
 * @param array
 * @desc Abstraction to build links for _GET and path types.
 * @date 12-20-03
 */
function build_link( $pre, $links = false ) {
	$url='';
	if( !$links ) $links = array();
	if( !defined('FETCH_TYPE') || FETCH_TYPE != 'path' ) { 
		$i=0;
		foreach($links as $key=>$val) {
			$and = '&';
			if($i==0) $and = '?';
			$url .= $and . $key . '=' . $val;
			$i++;
		}
	} else {
		foreach($links as $key=>$val) {
			$url .= '/' . $key . '/' . $val;
		}
	}
	return script_path . $pre . $url;
}

/**
 * @return ARRAY
 * @param ARRAY
 * @param OBJECT nlb_user
 * @desc Builds main navigation links. nlb_user object must be initialize and working.
 * @date 01-08-03
 */
function buildMainNav( $l, &$user ) {

	$i=0;
	$menu[$i]->text = $l['nav-home'];
	$menu[$i]->link = script_path . 'index.php';
	$i++;
	$menu[$i]->text = $l['nav-members'];
	$menu[$i]->link = script_path . 'members.php';
	$i++;
	$menu[$i]->text = $l['nav-articles'];
	$menu[$i]->link = build_link('index.php', array('action'=>'list_articles'));
	$i++;
	$menu[$i]->text = $l['nav-stats'];
	$menu[$i]->link = script_path . 'stats.php';
	$i++;
	$menu[$i]->text = $l['nav-search'];
	$menu[$i]->link = script_path . 'search.php';
	$i++;
	if( $user->isLogedIn ) {		// these show up when user is loged in
		$menu[$i]->text = $l['nav-logout'];
		$menu[$i]->link = script_path . 'login.php?action=logout';
		$i++;
		$menu[$i]->text = $l['nav-user'];
		$menu[$i]->link = script_path . 'usercp.php';
	} else {						// these when is not loged in
		$menu[$i]->text = $l['nav-login'];
		$menu[$i]->link = script_path . 'login.php';
		$i++;
		$menu[$i]->text = $l['nav-register'];
		$menu[$i]->link = script_path . 'register.php';
	}
	if( $user->isLogedIn && $user->isAllowed('admin') ) {	// when user is an admin
		$i++;
		$menu[$i]->text = $l['nav-admin'];
		$menu[$i]->link = script_path . 'admincp.php';
	}
	return $menu;
}

/**
 * @return string
 * @param int
 * @desc special callback for changing profile
 * @date 02-16-04
 */
function bday_format( $value ) {
	return date('d F Y', $value);
}

/**
 * Validate a email
 *
 * @param string    $email          URL to validate
 * @param boolean   $domain_check   Check or not if the domain exists
 *
 * @author pear 	This is from the PEAR package Validate.
 */
function pear_check_email($email, $check_domain = false)
{
    if($check_domain){

    }

    if (ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'.'@'.
             '[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.'.
             '[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $email))
    {
        if ($check_domain && function_exists('checkdnsrr')) {
            list (, $domain)  = explode('@', $email);
            if (checkdnsrr($domain, 'MX') || checkdnsrr($domain, 'A')) {
                return true;
            }
            return false;
        }
        return true;
    }
    return false;
}

/**
 * @return string
 * @param string
 * @desc Will call addslashes() if magic quotes is off.
 * @date 01-12-04
 */
function slash_if_needed( $str ) {
	if( !get_magic_quotes_gpc() ) {
		$str = addslashes( $str );
	}
	return $str;
}

/**
 * @return void
 * @param &array
 * @desc runs stripslashes on all elements in array. array is passed by ref, so nothing retured.
 * @date 01-13-04
 */
function stripslashes_array( & $arr ) {
	foreach( $arr as $key => $val ) {
		$arr[$key] = stripslashes( $val );
	}
}

/**
 * @return VOID
 * @param STRING
 * @desc Sends a user to another page, then kills php. Don't do any output before calling this function
 * @date 01-12-04
 */
function jsRedirect( $URL )
{
	echo '<html><body><script language="javascript" type="text/javascript">window.location="' . $URL . '";</script></body></html>';
	die();
	return;
}

/**
 * @return FLOAT
 * @param [FLOAT]
 * @param [INT]
 * @desc A nice way to handel page-generation time
 * @date 10-12-04
 */
function mymicrotime( $start = FALSE, $place = 5)
{
	/*	USAGE:
		$start = mymicrotime();
		$end = mymicrotime($start, $precision);
	*/
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

/**
 * @return STRING
 * @param STRING
 * @author Fusion PHP Team (www.fusionphp.net)
 * @desc will add BB code to a string, and the return it.
 *       This function is mostly taken from Fusion News 3.6.1
 		 http://www.fusionphp.net
 */
function InsertBBCode( $fusnewsm ) {

	// open tags risk wrong formatting of the whole newspage... open tags should be dealth with
	$bbcodes_open  = array('[move]','[sub]','[tt]','[sup]','[s]','[b]','[i]','[u]','[list]','[quote]','[code]');
	$bbcodes_close = array('[/move]','[/sub]','[/tt]','[/sup]','[/s]','[/b]','[/i]','[/u]','[/list]','[/quote]','[/code]');
	for($i = 0; $i < 11; $i++ ) {
		$bbcode_open = $bbcodes_open[$i];
		$bbcode_close = $bbcodes_close[$i];
		$open_cnt = substr_count( $fusnewsm, $bbcode_open );
		$close_cnt = substr_count( $fusnewsm, $bbcode_close );
		$div = abs( $open_cnt - $close_cnt );

		if ( $open_cnt > $close_cnt ) {
			for ($i = 0; $i < $div; $i++ ) {
				$fusnewsm .= $bbcode_close;
			}
		}
		if ( $open_cnt < $close_cnt ) {
			for ($i = 0; $i < $div; $i++ ) {
				$fusnewsm = $bbcode_open . $fusnewsm;
			}
		}
	}
	$fusnewsm = str_replace('[move]', '<marquee>', $fusnewsm);
	$fusnewsm = str_replace('[/move]', '</marquee>', $fusnewsm);
	$fusnewsm = str_replace('[sub]', '<sub>', $fusnewsm);
	$fusnewsm = str_replace('[/sub]', '</sub>', $fusnewsm);
	$fusnewsm = str_replace('[tt]', '<tt>', $fusnewsm);
	$fusnewsm = str_replace('[/tt]', '</tt>', $fusnewsm);
	$fusnewsm = str_replace('[sup]', '<sup>', $fusnewsm);
	$fusnewsm = str_replace('[/sup]', '</sup>', $fusnewsm);
	$fusnewsm = str_replace('[s]', '<s>', $fusnewsm);
	$fusnewsm = str_replace('[/s]', '</s>', $fusnewsm);
	$fusnewsm = str_replace('[b]', '<b>', $fusnewsm);
	$fusnewsm = str_replace('[/b]', '</b>', $fusnewsm);
	$fusnewsm = str_replace('[i]', '<i>', $fusnewsm);
	$fusnewsm = str_replace('[/i]', '</i>', $fusnewsm);
	$fusnewsm = str_replace('[u]', '<u>', $fusnewsm);
	$fusnewsm = str_replace('[/u]', '</u>', $fusnewsm);
	$fusnewsm = str_replace('[list]', '<ul>', $fusnewsm);
	$fusnewsm = str_replace('[/list]', '</ul>', $fusnewsm);
	$fusnewsm = str_replace('[quote]', '<blockquote><span class=\'12px\'>quote:</span><hr>', $fusnewsm);
	$fusnewsm = str_replace('[/quote]', '<hr></blockquote>', $fusnewsm);
	$fusnewsm = str_replace('[code]','<blockquote><span class=\'12px\'>code:</span><hr><pre>',$fusnewsm);
	$fusnewsm = str_replace('[/code]','</pre><hr></blockquote>',$fusnewsm);
	$fusnewsm = str_replace('[*]', '<li>', $fusnewsm);
	$fusnewsm = str_replace('[hr]', '<hr>', $fusnewsm);
	$fusnewsm = eregi_replace(" http://([^\\[]*) ", '<a target="_blank" href="http://\\1">\\1</a>', $fusnewsm);
	$fusnewsm = eregi_replace("\\[color=([^\\[]*)\\]([^\\[]*)\\[/color\\]","<font color=\"\\1\">\\2</font>",$fusnewsm);
	$fusnewsm = eregi_replace("\\[size=([^\\[]*)\\]([^\\[]*)\\[/size\\]","<font size=\"\\1\">\\2</font>",$fusnewsm);
	$fusnewsm = eregi_replace("\\[font=([^\\[]*)\\]([^\\[]*)\\[/font\\]","<font face=\"\\1\">\\2</font>",$fusnewsm);
	$fusnewsm = eregi_replace("\\[img height=([^\\[]*)\\ width=([^\\[]*)\\]([^\\[]*)\\[/img\\]","<img src=\"\\3\" height=\"\\1\" width=\"\\2\">",$fusnewsm);
	$fusnewsm = eregi_replace("\\[img width=([^\\[]*)\\ height=([^\\[]*)\\]([^\\[]*)\\[/img\\]","<img src=\"\\3\" width=\"\\1\" height=\"\\2\">",$fusnewsm);
	$fusnewsm = eregi_replace("\\[img]([^\\[]*)\\[/img\\]","<img src=\"\\1\">",$fusnewsm);
	$fusnewsm = eregi_replace("\\[flash=([^\\[]*)\\,([^\\[]*)\\]([^\\[]*)\\[/flash\\]","<object classid=\"clsid: D27CDB6E-AE6D-11cf-96B8-444553540000\" width=\\1 height=\\2><param name=movie value=\\3><param name=play value=true><param name=loop value=true><param name=quality value=high><embed src=\\3 width=\\1 height=\\2 play=true loop=true quality=high></embed></object>",$fusnewsm);
	$fusnewsm = eregi_replace("\\[align=([^\\[]*)\\]([^\\[]*)\\[/align\\]","<p align=\"\\1\">\\2</p>",$fusnewsm);
	$fusnewsm = eregi_replace("\\[shadow=([^\\[]*)\\,([^\\[]*)\\,([^\\[]*)\\]([^\\[]*)\\[/shadow\\]","<font style=\"Filter: Shadow(color=\\1, Direction=\\2); Width=\\3px;\">\\4</font>",$fusnewsm);
	$fusnewsm = eregi_replace("\\[glow=([^\\[]*)\\,([^\\[]*)\\,([^\\[]*)\\]([^\\[]*)\\[/glow\\]","<font style=\"Filter: Glow(color=\\1, Strength=\\2); Width=\\3px;\">\\4</font>",$fusnewsm);
	$fusnewsm = eregi_replace("\\[email\\]([^\\[]*)\\[/email\\]", "<a href=\"mailto:\\1\">\\1</a>",$fusnewsm);
	$fusnewsm = eregi_replace("\\[email=([^\\[]*)\\]([^\\[]*)\\[/email\\]", "<a href=\"mailto:\\1\">\\2</a>",$fusnewsm);
	$fusnewsm = eregi_replace("(^|[>[:space:]\n])([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])([<[:space:]\n]|$)","\\1<a href=\"\\2://\\3\\4\" target=\"_blank\">\\2://\\3\\4</a>", $fusnewsm);
	$fusnewsm = preg_replace("/([\n >\(])www((\.[\w\-_]+)+(:[\d]+)?((\/[\w\-_%]+(\.[\w\-_%]+)*)|(\/[~]?[\w\-_%]*))*(\/?(\?[&;=\w\+%]+)*)?(#[\w\-_]*)?)/", "\\1<a href=\"http://www\\2\">www\\2</a>", $fusnewsm);
	$fusnewsm = eregi_replace("\\[url\\]www.([^\\[]*)\\[/url\\]", "<a href=\"http://www.\\1\" target=\"_blank\">\\1</a>",$fusnewsm);
	$fusnewsm = eregi_replace("\\[url\\]([^\\[]*)\\[/url\\]","<a href=\"\\1\" target=\"_blank\">\\1</a>",$fusnewsm);
	$fusnewsm = eregi_replace("\\[url=([^\\[]*)\\]([^\\[]*)\\[/url\\]","<a href=\"\\1\" target=\"_blank\">\\2</a>",$fusnewsm);
	return $fusnewsm;
}

/**
 * @return STRING
 * @param STRING
 * @desc same idea as insertBBCode, but smiley images instead
 * @date 01-10-04
 */
function insertSmiles( $string )
{
	$smileDir = 'smiles/';		// trailing slash!!
	$smiles = array(
		':)' => 'happy.gif',
		':(' => 'sad.gif',
		':P' => 'tounge.gif',
		'8)' => 'cool.gif',
		':D' => 'grin.gif',
		':o' => 'eep.gif',
		'>_<' => 'angry.gif',
		';)' => 'wink.gif',
		':cry' => 'cry.gif'
	);
	foreach($smiles as $key => $val) {
		$string = str_replace($key, '<img src="' . $smileDir . $val . '" alt="' . $val . '">', $string);
	}
	return $string;
}

/**
 * @return STRING
 * @param STRING
 * @desc Will take in a file name, and return it's file extension.
 * @date 
 */
function getFileExt( $FN )
{
	if(is_dir($FN)) {
		return "DIR";
	}
	$file = explode('.', $FN);
	if(count($file) >= 3) {
		// more than one extension.
		$i=1;
		$r = "";
		while($i<count($file)) {
			$r .= $file[$i] . '.';
			$i++;
		}
		$r = substr($r, 0, -1);	// remove the . at the end.
		return $r;
	} else {
		return $file[1];
	}
}	

/**
 * @return STRING
 * @param INT
 * @param INT
 * @desc Will offset a given unix timestamp by timezone.
 * @date 12-20-03
 */
function date_offset( $unix, $hours ) {
	return $unix + ($hours * 3600);
}

/**
 * @return array
 * @param int
 * @desc builds an array to be used as a dropdown list to select timezone
 * REMEBER: Subtract 13 from whatever the user selects to get the real timezone!
 * @date 02-11-04
 */
// function build_timezone_list( $server_offset ) {
// 	$server_timezone = date_offset( time(), $server_offset );
// 	$list = array();
// 	$i = range(1, 25);
// 	foreach( $i as $zone ) {
// 		$t = $zone - 13;
// 		$date = date( 'M jS, g:i a', date_offset( $server_timezone, $t ) );
// 		$t = ($t>0) ? "+$t" : $t;
// 		$list[ $zone ] = " $t GMT [ $date ]";
// 	}
// 	return $list;
// }
function build_timezone_list( $server_offset ) { 
   $server_timezone = date_offset( time(), $server_offset ); 
   $list = array(); 
   $i = range(-12, 12); 
   foreach( $i as $zone ) { 
      $t = $zone; 
      $date = date( 'M jS, g:i a', date_offset( $server_timezone, $t ) ); 
      $t = ($t>0) ? "+$t" : $t; 
      $list[ $zone ] = " $t GMT [ $date ]"; 
   } 
   return $list; 
}

/**
 * @return void
 * @param sqldb2 object
 * @param array
 * @desc Removes an avatar (ONE!) that meets the where clause
 * @date 02-22-04
 */
function remove_avatar( & $db, $where ) {
	$w = '';
	foreach( $where as $key => $val ) {
		$w .= "$key = '$val' AND ";
	}
	$w = substr( $w, 0, -5);

	$av = $db->getArray('SELECT * FROM ' . db_avatars . ' WHERE ' . $w . ' LIMIT 1;');
	
	if( empty( $av ) ) {
		return;
	}
	if( $av['isCustom'] == 1 ) {
		unlink('./avatars/' . $av['file'] );
	}
	$db->query('DELETE FROM ' . db_avatars . ' WHERE ' . $w . ' LIMIT 1;');
}



/**
 * @return VOID
 * @param MIXED
 * @desc More advanced than print_r. Example function from php.net
 * @date 01-04-04
 */
function debug( $var, $title = false ) {
	echo '<fieldset><legend>***<B>DEBUGGING</B>***';
	if( $title ) 
		echo '&nbsp;&nbsp;&nbsp;<font color="red">' . $title . '</font>';
	echo "</legend>\n<pre>";
	if (is_array($var) || is_object($var) || is_resource($var)) {
		print_r($var);
	} else {
		echo "\n$var\n";
	}
	echo '</pre></fieldset>';
}

/**
 * @return void
 * @pram string $text pass by ref
 * @desc Fixes bug of working inside a <textarea> with bad html
 * @date 04-02-04
 */
function badHtmlFirst( & $text ) {
	$text = str_replace('<', '&#060;', $text);
	$text = str_replace('>', '&#062;', $text);
}

/**
 * @return void
 * @pram string $text pass by ref
 * @desc Fixes bug of working inside a <textarea> with bad html
 * @date 04-02-04
 */
function badHtmlSecond( & $text ) {
	$text = str_replace('&#060;', '<', $text);
	$text = str_replace('&#062;', '>', $text);
}

/**
 * use it to shorten a string to a certin length. If it is not as big
 * as limit, then won't do anything.
 *
 * @return string
 * @param string
 * @param int
 * @param [string]
 * @date 01-04-04
 */
function truncate($string, $limit, $text = '...') {
	if( strlen($string) > $limit ) {
		return substr($string, 0, $limit) . $text;
	} else {
		return $string;
	}
}

/**
 * @return STRING
 * @param ARRAY
 * @param OBJECT
 * @param [OBJECT]
 * @param [ARRAY]
 * @desc Build a html form for submitting user info
 * @date 01-06-04
 */
function build_form( & $tree, $form, $table = false, $merge = array() ) {
	ob_start();
	
	echo '<form method="' . $form->method . '" action="' .$form->action . '"';
	if( isset($form->class) ) {
		echo ' class="' . $form->class . '"';
	}
	if( isset($form->name) ) {
		echo ' name="' . $form->name . '"';
	}
	echo ">\n";
	echo '<table';
	if( isset($table->class) ) {
		echo ' class="' . $table->class . '"';
	}
	if( isset($table->width) ) {
		echo ' width="' . $table->width . '"';
	}
	echo "> \n";
	
	foreach( $tree as $key => $item ) {
		echo "<tr>\n";
		if( isset($item->desc) ) {
			echo '<td valign="top">' . $item->desc . "</td>\n<td>";
		} else {
			echo '<td colspam="2" valign="top">';
		}

		//
		// Decide what to print based on input type
		//
		switch( $item->type ) {
			
			case 'text':
				echo '<input type="text" name="' . $item->name . '"';
				if( isset($item->class) ) {
					echo 'class="' . $item->class . '"';
				}
				// passed in value, or use $merge?
				if( !isset($item->value) ) $item->value = "";	// no data passed in
				if( isset( $merge[ $item->name ] ) ) $item->value = $merge[ $item->name ];
				if( isset( $item->call ) ) {
					$cb = $item->call;
					$item->value = $cb($item->value);
				}
				echo ' value="' . $item->value . '"';
				
				echo ' /></td>';
			break;
			
			case 'password':
				echo '<input type="password" name="' . $item->name . '"';
				if( !isset($item->value) ) $item->value = "";
				if( isset( $merge[$item->name] ) ) $item->value = $merge[$item->name];
				echo ' value="' . $item->value . '"';
				echo ' /></td>';
			break;
			
			case 'textarea':

				echo '<textarea name="' . $item->name . '"';
				if( isset($item->class) ) {
					echo ' class="' . $item->class . '"';
				}
				// check for rows/cols, becuase it's needed to validate as good html
				if( !isset($item->rows) ) {	$item->rows = 2; }	
				if( !isset($item->cols) ) { $item->cols = 20; }	
				echo ' rows="' . $item->rows . '" cols="' . $item->cols . '">';	
				// passed in value, or use $merge?
				if( !isset($item->value) ) $item->value = "";	// no data passed in
				if( isset( $merge[ $item->name ] ) ) $item->value = $merge[ $item->name ];
				echo $item->value;

				echo "</textarea></td>";
			break;
			
			case 'submit':
				if( isset( $item->center ) && $item->center === true ) {
					echo '<center>';
				}
				echo '<input type="submit"';
				if( isset($item->name) ) {
					echo ' name="' . $item->name . '"';
				}
				if( isset($item->class) ) {
					echo ' class="' . $item->class . '"';
				}
				// passed in value, or use $merge?
				if( !isset($item->value) ) $item->value = "";	// no data passed in
				echo ' value="' . $item->value . '"';
				echo " />";
				if( isset( $item->center ) && $item->center === true ) {
					echo '</center>';
				}
				echo "</td>";
			break;
			
			case 'data':
				// non-form specal case. Print passed value
				echo $item->value;
				echo '</td>';
			break;
			
			case 'select':
				echo '<select name="' . $item->name . '">' . "\n";
				foreach( $item->value as $key => $val ) {
					if( isset( $item->selected ) && $item->selected == $key ) {
						echo '<option value="' . $key . '" selected="selected">' . $val . "</option>\n";
					} else if( isset($merge[$item->name]) && $merge[$item->name] == $key ) {
						echo '<option value="' . $key . '" selected="selected">' . $val . "</option>\n";
					} else {
						echo '<option value="' . $key . '">' . $val . "</option>\n";
					}
				}
				echo "</select>\n</td>";
			break;
			
			case 'checkboxes':
				// expecting value to be a multi-d array
				foreach( $item->value as $option ) {
					echo '<input type="checkbox" name="' . $option['name'] . '" value="' . $option['value'] . '"';
					if( isset( $merge[ $option['name'] ] ) ) {
						echo " checked";
					}
					echo '> ' . $option['desc'] . "<br>\n";
				}
				echo "</td>";
			break;
		}
		
		echo "\n</tr>\n";
	}
	echo "</table>\n</form>";
	
	$form = ob_get_contents();
	ob_end_clean();
	return $form;
}

?>