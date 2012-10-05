<?php
//
// +----------------------------------------------------------------------+
// | PHP version 4														  |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2002 The PHP Group								  |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the PHP license, 	  |
// | that is bundled with this package in the file LICENSE, and is		  |
// | available at through the world-wide-web at 						  |
// | http://www.php.net/license/2_02.txt.								  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to		  |
// | license@php.net so we can mail you a copy immediately. 			  |
// +----------------------------------------------------------------------+
// | Authors: Stig Bakken <ssb@fast.no> 								  |
// |		  Urs Gehrig <urs@circle.ch>								  |
// +----------------------------------------------------------------------+
//
// $Id: Form.php,v 1.2 2003/02/14 11:12:08 mj Exp $
//
// HTML form utility functions.
//

/*
	Changes by sevengraff
	<nick@sevengraff.com>
	
	----- March 26, 2004 -----
	*	Killed off all the display*() functions because I will
	never use them in my projects.
	*	Instead of the left column being made of <th>'s, it is
	now <td class="left">, with the other column being 
	<td class="right">
	*	Net method: setHeader() will set text to be displayed
	inside a <thead> section inside a single <td>
	
	----- March 19, 2004 -----
	*	Removed all the basename() calls
	
	----- March 16, 2004 -----
	*	Changed all the display* to be just echo return*() to cut down
	on the redundancy.
	*	Start using phpDoc comment style so this class can be easily
	documented.
	
	----- March 13, 2004 -----
	*	removed all changes to start() and end(). Didn't know about
	the functions returnStart() and returnEnd(). whoops...
	*	Display() is now just echo build()
	*	Added function setTableAttribs, which lets you specify info
	for the output of <table>
	*	addTextArea only needs first two args now
	*	Defined HTML_FORM_TEXTAREA_WT and HTML_FORM_TEXTAREA_HT as 20 and 2
	*	Converted spaces to tabs
	
	----- March 12, 2004 -----
	*	Default method is now post.
	*	start() and end() will now return the output by default.
	Or can pass a non-false value as first param and they
	will act like normal
	*	addPassword() only requires first two args now
	*	added type Pass that works just like Password, but user
	does not need to confirm password.
	functions added:
		addPass, displayPass, returnPass, displayPassRow, returnPassRow
	*	added function build() that works just like display(), but 
	will return the form as a string. Does not use Output Buffering.
	*	New function setTableAttribs() takes an array and lets the 
	user have a bit more control over the built table.
	
*/

if (!defined('HTML_FORM_TEXT_SIZE')) {
	define('HTML_FORM_TEXT_SIZE', 20);
}

if (!defined('HTML_FORM_MAX_FILE_SIZE')) {
	define('HTML_FORM_MAX_FILE_SIZE', 1048576); // 1 MB
}

if (!defined('HTML_FORM_PASSWD_SIZE')) {
	define('HTML_FORM_PASSWD_SIZE', 8);
}

if (!defined('HTML_FORM_TEXTAREA_WT')) {
	define('HTML_FORM_TEXTAREA_WT', 20);	// aka "cols"
}

if (!defined('HTML_FORM_TEXTAREA_HT')) {
	define('HTML_FORM_TEXTAREA_HT', 2); 	// aka "rows"
}

/**
 * Class to generate forms
 *
 * Extreamly modified version of PEAR::HTML_Form
 *
 * @package NLB3
 * @author Nick F <nick@sevengraff.com>
 * @date 03-16-04
 */
class HTML_Form
{
	
	/**#@+
	 * @access private
	 * @var string
	 */
	/**
	 * action attirbut of <form> tag. Where the user 
	 * will be sent when they click submit
	 */
	var $action;

	/**
	 * METHOD attribute of <form> tag 
	 */
	var $method;

	/** 
	 * NAME attribute of <form> tag 
	 */
	var $name;

	/** 
	 * an array of entries for this form 
	 */
	var $fields;

	/** 
	 * DB_storage object, if tied to one 
	 */
	var $storageObject;

	/** 
	 * TARGET attribute of <form> tag 
	 */
	var $target;

	/** 
	 * ENCTYPE attribute of <form> tag 
	 */
	var $enctype;
	
	/** 
	 * Table attributes
	 */
	var $table;
	
	/**
	 * Table header
	 */
	var $thead;
	
	/** 
	 * value of <form onSubmit=""> 
	 */
	var $onSubmit;
	/**#@-*/
		
	/**
	 * Default values for form tags.
	 * Array format: 'element name' => 'value
	 *
	 * @access private
	 * @var array
	 */
	var $values;
	
	/**
	 * set to true if you want to generate the hidden 
	 * field _fileds which lists all the fields
	 *
	 * @var bool
	 * @access public
	 */
	var $gen_fields;
	
	/**
	 * Version of PEAR::HTML_Form
	 *
	 * @access public
	 * @var string
	 */
	var $version = '2.0';
	
	/**
	 * Constructor
	 * 
	 * @return		void
	 * @param		string	form action
	 * @param		string	form method (post|get)
	 * @param		string	form name
	 * @param		string	target
	 * @param		string	encryption type
	 * @param		string	js function to call onSubmit.
	 */
	function HTML_Form($action, $method = 'post', $name = '', $target = '', $enctype = '', $onSubmit = '')
	{
		$this->action 	= $action;
		$this->method 	= $method;
		$this->name 	= $name;
		$this->fields 	= array();
		$this->target 	= $target;
		$this->enctype 	= $enctype;
		$this->onSubmit	= $onSubmit;
		$this->table 	= '<table>';
		$this->values 	= array();
		$this->gen_fields	= true;
		$this->thead 	= false;
		
		// Default attributes for <table>
		$this->setTableAttribs( array('class' => 'HTML_Form') );
	}

	/**
	 * Set attributes to the outer <table> tag.
	 *
	 * @param	array	format: attribute => value
	 */
	function setTableAttribs( $attribs )
	{
		$this->table = '<table';
		foreach( $attribs as $name => $value ) {
			$this->table .= ' ' . $name . '="' . $value . '"';
		}
		$this->table .= '>';
	}
	
	/**
	 * Sets a table header
	 * will apear in <code>&lt;thead></code> section of output
	 *
	 * @return void
	 * @param string
	 * @access public
	 */
	function setHeader( $header )
	{
		$this->thead = $header;
	}
	
	// ================
	// add*() section
	// ================

	/**
	 * Add a text field to form
	 *
	 * @param	string	name
	 * @param	string	message to user
	 * @param	string	default value
	 * @param	int		size of input field
	 * @param	maxlength	max number of chars that can be entered
	 
	 * @return void
	 */
	function addText($name, $title, $default = '',
					 $size = HTML_FORM_TEXT_SIZE, $maxlength = '')
	{
		$this->fields[] = array("text", $name, $title, $default, $size, $maxlength);
	}

	/**
	 * add password field
	 *
	 * @param	string	name
	 * @param	string	message to user
	 * @param	string	default value
	 * @param	int		size of field
	 */
	function addPassword($name, $title = '', $default = '', $size = HTML_FORM_PASSWD_SIZE)
	{
		$this->fields[] = array("password", $name, $title, $default, $size);
	}
	
	/**
	 * Add a passwd field
	 * this field makes a confirm password field also.
	 * the second password field will be called {$name}2
	 *
	 * @param	string	name
	 * @param	string	message to user
	 * @param	string	default value
	 * @param	int		size of field
	 */	
	function addPasswd($name, $title, $default = '', $size = HTML_FORM_PASSWD_SIZE)
	{
		$this->fields[] = array('passwd', $name, $title, $default, $size);
	}

	/**
	 * Add single checkbox
	 *
	 * @param	string	name
	 * @param	string	message to user
	 * @param	string	default value
	 */
	function addCheckbox($name, $title, $default)
	{
		$this->fields[] = array("checkbox", $name, $title, $default);
	}

	/**
	 * Add a textarea field 
	 *
	 * @param	string	name
	 * @param	string	message to user
	 * @param	string	default value
	 * @param	int		Width of textarea
	 * @param	int		Height of textarea
	 * @param	int		Max number of chars user can input
	 */
	function addTextarea($name, $title, $default = '',
						 $width = HTML_FORM_TEXTAREA_WT,
						 $height = HTML_FORM_TEXTAREA_HT, $maxlength = '')
	{
		$this->fields[] = array("textarea", $name, $title, $default, $width, $height, $maxlength);
	}

	/**
	 * Add a submit button
	 *
	 * @param	string	name
	 * @param	string	message to user
	 */
	function addSubmit($name = "submit", $title = "Submit Changes")
	{
		$this->fields[] = array("submit", $name, $title);
	}

	/**
	 * Add a reset button
	 *
	 * @param	string	message to user
	 */
	function addReset($title = "Discard Changes")
	{
		$this->fields[] = array("reset", $title);
	}

	/**
	 * Add a select field
	 *
	 * @param	string	Name of select field
	 * @param	string	message to user
	 * @param	array	<option> values: value=>display
	 * @param	int		selected option -??-
	 * @param	int		size
	 * @param	string	blank-??-
	 * @param	bool	Select multiple items t/f
	 * @param	array	attributes
	 */
	function addSelect($name, $title, $entries, $default = '', $size = 1,
					   $blank = '', $multiple = false, $attribs = '')
	{
		$this->fields[] = array("select", $name, $title, $entries, $default,
								$size, $blank, $multiple, $attribs);
	}

	/**
	 * Add single radio option
	 *
	 * @param	string	name
	 * @param	string	message to user
	 * @param	string	value
	 * @param	bool	Checked
	 */
	function addRadio($name, $title, $value, $default = false)
	{
		$this->fields[] = array("radio", $name, $title, $value, $default);
	}

	/**
	 * Image field
	 *
	 * @param	string	Name
	 * @param	string	location of image
	 */
	function addImage($name, $src)
	{
		$this->fields[] = array("image", $name, $src);
	}

	/**
	 * Hidden Field
	 * Hidden fields are outputted last, regardless of the order you added them
	 *
	 * @param	string	Name of field
	 * @param	string	Value
	 */
	function addHidden($name, $value)
	{
		$this->fields[] = array("hidden", $name, $value);
	}

	/**
	 * Blank Entry
	 *
	 * @param	int		Number of blank entries
	 * @param	string	Message to user -??-
	 */
	function addBlank($i,$title = '')
	{
		$this->fields[] = array("blank", $i, $title);
	}

	/**
	 * Upload file filed
	 *
	 * @param	string	Name
	 * @param	string	Message to user
	 * @param	int		Max size of file
	 * @param	int		size of input field
	 * @param	int		accpet? -??-
	 */
	function addFile($name, $title, $maxsize = HTML_FORM_MAX_FILE_SIZE,
					 $size = HTML_FORM_TEXT_SIZE, $accept = '') 
	{
		$this->enctype = "multipart/form-data";
		$this->fields[] = array("file", $name, $title, $maxsize, $size, $accept);
	}

	/**
	 * Plain text. $value will be displayed outside of any input tag
	 *
	 * @param	string	Message to user
	 * @param	string	Value of text
	 */
	function addPlaintext($title, $text = '&nbsp;')
	{
		$this->fields[] = array("plaintext", $title, $text);
	}

	/**
	 * Opens the <table> and <form> tags.
	 *
	 */
	function start()
	{
		echo returnStart();
	}

	/**
	 * Closes the <form> and <table> tags.
	 *
	 */
	function end()
	{
		echo returnEnd();
	}
	
	
	// ===================
	// return*() section
	// ===================

	function returnText($name, $default = '', $size = HTML_FORM_TEXT_SIZE)
	{
		return "<input name=\"$name\" value=\"$default\" size=\"$size\" />";
	}

	function returnTextRow($name, $title, $default = '', $size = HTML_FORM_TEXT_SIZE)
	{
		$str  = " <tr>\n";
		$str .= "  <td class=\"left\">$title</td>";
		$str .= "  <td class=\"right\">";
		$str .= $this->returnText($name, $default, $size);
		$str .= "</td>\n";
		$str .= " </tr>\n";

		return $str;
	}

	function returnPasswd($name, $default = '', $size = HTML_FORM_PASSWD_SIZE)
	{
		return $this->returnPassword($name, $default, $size);
	}
	
	function returnPassword($name, $default = '', $size = HTML_FORM_PASSWD_SIZE)
	{
		return "<input name=\"$name\" type=\"password\" value=\"$default\" size=\"$size\" />";
	}

	function returnPasswdRow($name, $title, $default = '', $size = HTML_FORM_PASSWD_SIZE)
	{
		$str  = "<tr>\n";
		$str .= "  <td class=\"left\">$title</td>\n";
		$str .= "  <td class=\"right\">";
		$str .= $this->returnPassword($name, $default, $size);
		$str .= " repeat: ";
		$str .= $this->returnPassword($name."2", $default, $size);		
		$str .= "  </td>\n";
		$str .= "</tr>\n";

		return $str;
	}

	function returnPasswordRow($name, $title, $default = '', $size = HTML_FORM_PASSWD_SIZE)
	{
		$str  = "<tr>\n";
		$str .= "  <td class=\"left\">$title</td>\n";
		$str .= "  <td class=\"right\">";
		$str .= $this->returnPassword($name, $default, $size);
		$str .= "</td>\n";
		$str .= "</tr>\n";

		return $str;
	}

	function returnCheckbox($name, $default = false)
	{
		$str = "<input type=\"checkbox\" name=\"$name\"";
		if ($default && $default != 'off') {
			$str .= " checked";
		}
		$str .= " />";

		return $str;
	}

	function returnCheckboxRow($name, $title, $default = false)
	{
		$str  = " <tr>\n";
		$str .= "  <td class=\"left\">$title</td>\n";
		$str .= "  <td class=\"right\">";
		$str .= $this->returnCheckbox($name, $default);
		$str .= "</td>\n";
		$str .= " </tr>\n";

		return $str;
	}

	function returnTextarea($name, $default = '', $width = 40, $height = 5)
	{
		$str  = "<textarea name=\"$name\" cols=\"$width\" rows=\"$height\">";
		$str .= $default;
		$str .= "</textarea>";

		return $str;
	}

	function returnTextareaRow($name, $title, $default = '', $width = 40, $height = 5)
	{
		$str  = " <tr>\n";
		$str .= "  <td class=\"left\">$title</td>\n";
		$str .= "  <td class=\"right\">";
		$str .= $this->returnTextarea($name, $default, $width, $height);
		$str .= "</td>\n";
		$str .= " </tr>\n";

		return $str;
	}

	function returnSubmit($title = 'Submit Changes', $name = "submit")
	{
		return "<input name=\"$name\" type=\"submit\" value=\"$title\" />";
	}

	function returnSubmitRow($name = "submit", $title = 'Submit Changes')
	{
		$str  = " <tr>\n";
		$str .= "  <td class=\"left\">&nbsp;</td>\n";
		$str .= "  <td class=\"right\">";
		$str .= $this->returnSubmit($title, $name);
		$str .= "</td>\n";
		$str .= " </tr>\n";

		return $str;
	}

	function returnReset($title = 'Clear contents')
	{
		return "<input type=\"reset\" value=\"$title\" />";
	}

	function returnResetRow($title = 'Clear contents')
	{
		$str  = " <tr>\n";
		$str .= "  <td class=\"right\">&nbsp;</td>\n";
		$str .= "  <td class=\"right\">";
		$str .= $this->returnReset($title);
		$str .= "</td>\n";
		$str .= " </tr>\n";

		return $str;
	}

	function returnSelect($name, $entries, $default = '', $size = 1,
						   $blank = '', $multiple = false, $attrib = '')
	{
		if ($multiple && substr($name, -2) != "[]") {
			$name .= "[]";
		}
		$str = "   <select name=\"$name\"";
		if ($size) {
			$str .= " size=\"$size\"";
		}
		if ($multiple) {
			$str .= " multiple=\"multiple\"";
		}
		if ($attrib) {
			$str .= " $attrib";
		}
		$str .= ">\n";
		if ($blank) {
			$str .= "	 <option value=\"\">$blank</option>\n";
		}
		while (list($val, $text) = each($entries)) {
			$str .= '	 <option ';
				if ($default) {
					if ($multiple && is_array($default)) {
						if ((is_string(key($default)) && $default[$val]) ||
							(is_int(key($default)) && in_array($val, $default))) {
							$str .= 'selected="selected" ';
						}
					} elseif ($default == $val) {
						$str .= 'selected="selected" ';
					}
				}
			$str .= "value=\"$val\">$text</option>\n";
		}
		$str .= "	</select>\n";

		return $str;
	}

	function returnSelectRow($name, $title, &$entries, $default = '', $size = 1,
							  $blank = '', $multiple = false, $attribs = '')
	{
		$str  = " <tr>\n";
		$str .= "  <td class=\"left\">$title</td>\n";
		$str .= "  <td class=\"right\">\n";
		$str .= $this->returnSelect($name, $entries, $default, $size, $blank, $multiple, $attribs);
		$str .= "  </td>\n";
		$str .= " </tr>\n";

		return $str;
	}

	function returnHidden($name, $value)
	{
		return "<input type=\"hidden\" name=\"$name\" value=\"$value\" />";
	}

	function returnFile($name = 'userfile',
						$maxsize = HTML_FORM_MAX_FILE_SIZE,
						$size = HTML_FORM_TEXT_SIZE)
	{
		$str  = " <input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"$maxsize\" />";
		$str .= " <input type=\"file\" name=\"$name\" size=\"$size\" />";
		return $str;
	}

	function returnMultipleFiles($name = 'userfile[]',
								 $maxsize = HTML_FORM_MAX_FILE_SIZE,
								 $files = 3,
								 $size = HTML_FORM_TEXT_SIZE)
	{
		$str  = " <input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"$maxsize\" />";
		for($i=0; $i < $files; $i++) {
		   $str .= " <input type=\"file\" name=\"$name\" size=\"$size\" /><br />";
		}
		return $str;
	}

	function returnStart($multipartformdata = false)
	{
		$str = '<form action="' . $this->action . '" method="' . $this->method . '"';
		
		if ($this->name) 
		{
			$str .= ' name="$this->name"';
		}
		
		if ($multipartformdata) 
		{
			$str .= ' enctype="multipart/form-data"';
		}
		
		if( $this->onSubmit ) 
		{
			$str .= ' onSubmit="' . $this->onSubmit . '"';
		}
		$str .= '>';

		return $str;
	}

	function returnEnd()
	{
		$ret = '';
		if( $this->gen_fields )
		{
			$fields = array();
			reset($this->fields);
			while (list($i, $data) = each($this->fields)) {
				if ($data[0] == 'reset') {
					continue;
				}
				$fields[$data[1]] = true;
			}
			$ret = $this->returnHidden("_fields", implode(":", array_keys($fields)));
		}
		$ret .= "</form>";
		return $ret;
	}

	function returnPlaintext($text = '&nbsp;')
	{
		return $text;
	}

	function returnPlaintextRow($title, $text = '&nbsp;')
	{
		$str  = " <tr>\n";
		$str .= "  <td class=\"left\">$title</td>";
		$str .= "  <td class=\"right\">";
		$str .= $this->returnPlaintext($text);
		$str .= "</td>\n";
		$str .= " </tr>\n";

		return $str;
	}

	/**
	 * Will return the forum as a string
	 *
	 * @return string
	 * @since 2.0
	 * @access public
	 */
	function build()
	{
		$out = '';
		$arrname = 'HTTP_'.strtoupper($this->method).'_VARS';
		$arr = &$GLOBALS[$arrname];
		$out .= $this->returnStart();
		$out .= "\n" . $this->table;
		// table header?
		if( $this->thead )
		{
			$out .= "\n<thead><tr><td colspan=\"2\">"
			. $this->thead . '</td></tr></thead>' . "\n";
		}
		// call the return*() functions to build the form.
		reset($this->fields);
		$hidden = array();
		foreach ($this->fields as $i => $data) 
		{
			switch ($data[0]) {
				case "hidden":
					$hidden[] = $i;
					$defind = 0;
					continue 2;
				case "reset":
					$params = 1;
					$defind = 0;
					break;
				case "submit":
				case "blank": // new
					$params = 2;
					$defind = 0;
					break;
				case "image":
					$params = 2;
					$defind = 0;
					break;
				case "checkbox":
					$params = 3;
					$defind = 2;
					break;
				case "file":  //new
				case "text":
					$params = 5;
					$defind = 3;
					break;
				case 'passwd':
				case "password":
				case "radio":
					$params = 4;
					$defind = 3;
					break;
				case "textarea":
					$params = 6;
					$defind = 3;
					break;
				case "select":
					$params = 8;
					$defind = 4;
					break;
				case "plaintext":
					$params = 2;
					$defind = 1;
					break;
				default:
					// unknown field type
					continue 2;
			}
			$str = '$out .= $this->return'.ucfirst($data[0])."Row(";
			for ($i = 1;$i <= $params;$i++) {
				if ($i == $defind && $data[$defind] === null && isset($arr[$data[1]])) {
					$str .= "\$arr['$data[1]']";
				} else {
					$str .= '$'."data[$i]";
				}
				if ($i < $params) $str .= ', ';
			}
			$str .= ');';
			eval($str);
		}
		$out .= "</table>\n";
		for ($i = 0;$i < sizeof($hidden);$i++) {
			$out .= $this->returnHidden($this->fields[$hidden[$i]][1],
								 $this->fields[$hidden[$i]][2]);
		}
		$out .= $this->returnEnd();
		return $out;
	}

	/**
	 * Will print the forum
	 *
	 * @return void
	 * @access public
	 */
	function display()
	{
		echo $this->build();
	}

}

/*
* Local variables:
* tab-width: 4
* c-basic-offset: 4
* End:
*/
?>