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
 * Class to validate form-submitted data
 * Inspired by Nay's post at http://forums.devnetwork.net/viewtopic.php?t=16077
 *
 * @package NLB3
 * @author Nick F <nick@sevengraff.com>
 * @date 01-04-04
 */
 class Text {
 	
 	var $original;			// original array
 	var $clean;				// array that's okay to use
 	var $required;			// required fields to check existance & has data
 	var $optional;			// other fields.
	var $log;				// keep track of strange things.
	var $is_missing_required;	// var to check if there are missing/empty fields.
	var $missing_fields;	// the missing vars that we expected to find.
	var $unexpected_fields;	// watch out for these.
	
	/**
	 * @return VOID
	 * @param ARRAY Untrusted data
	 * @param ARRAY required fields
	 * @param [ARRAY] optional fields
	 * @desc Constructor.
	 * @date 01-04-04
	 */
	function Text( $orig, $req, $opt = array() ) {
		$this->original = $orig;
		$this->required = $req;
		$this->optional = $opt;
		// initilize other vars.
		$this->log = array();
		$this->is_missing_required = false;
		$this->unexpected_fields = false;
		$this->missing_fields = array();
		$this->clean = array();
		// For possible future refrence...
		$this->log("Users IP Address: " . $_SERVER['REMOTE_ADDR'] );
		$this->log("Time: " . date('r') );
		$this->log("User Browser: " . $_SERVER['HTTP_USER_AGENT'] );
		$this->log("Called by file " . $_SERVER['PHP_SELF'] );
	}
	
	/**
	 * @return VOID
	 * @param STRING
	 * @desc Keeps track of when something bad happens
	 * @date 01-04-04
	 */
	function log( $msg ) {
		$this->log[] = $msg;
	}
	
	/**
	 * @return VOID
	 * @desc checks data passed to constructor. Required fields must exists and have data, optional fields must exist. Looks for other fields too.
	 * @date 01-04-04
	 */
	function validate() {
		// make sure we have propper number of values
		$original_c = count( $this->original );
		$needed = count( $this->required ) + count( $this->optional );
		if( $original_c != $needed ) {
			// something is wrong with the user input.
			if( $original_c < $needed ) {
				$this->log( "Fewer fields than expected" );
			} else {
				$this->log( "More fields than expected" );
			}
		}
		// look for required fields.
		foreach( $this->required as $field ) {
			// check field exists
			if( !isset($this->original[$field]) ) {
				$this->is_missing_required = true;
				$this->missing_fields[] = $field;
				$this->log("Missing required field '$field'");
				$this->clean[$field] = false;
				continue;
			}
			// required fields must have a value
			if( $this->original[$field] != 0 && empty($this->original[$field]) || is_null($this->original[$field]) || $this->original[$field] === "" ) {
				$this->is_missing_required = true;
				$this->missing_fields[] = $field;
				$this->log("Required Field '$field' has no value");
				$this->clean[$field] = false;
			}
			$this->clean[$field] = $this->original[$field];
		}
		
		// look for existance of optional fields.
		foreach( $this->optional as $field ) {
			if( !isset($this->original[$field]) ) {
				// missing an optional field. Will create empty instance in $this->clean.
				$this->clean[$field] = "";
				$this->log("Missing optional field '$field'");
			} else {
				$this->clean[$field] = $this->original[$field];
			}
		}
		
		// look for non-defined fields. Is probally from bad html input
		foreach( $this->original as $field => $value ) {
			if( !isSet( $this->clean[$field] ) ) {
				$this->log( "Unexpected field '$field' found." );
				$this->unexpected_fields = true;
			}
		}
	}
				
	/**
	 * @return VOID
	 * @param LIST
	 * @desc Pass in function names and it will run them on all the elements.
	 */
	function makeClean() {
		if( func_num_args() > 0) { 
			foreach( func_get_args() as $callback ) {
				if( function_exists( $callback ) ) {
					foreach( $this->clean as $key => $val ) {
						if( is_array( $val ) ) {
							$this->log("Variable '$key' is an array, not calling function '$callback'");
						} else {
							if( !($this->clean[$key] = $callback( $val ) ) ) {
								$this->log("Error calling function '$callback' on variable '$key'");
							}
						}
					}
				} else {
					$this->log("Function not found: '$callback'");
				}
			}
		}
	}
	
	/**
	 * @return STRING
	 * @param STRING
	 * @desc Returns the log as a string. Default delimiter is <br>\n.
	 * @date 01-01-04
	 */
	function getLogAsString($delim = "<br>\n") {
		return implode( $this->log, $delim );
	}
	
}

?>