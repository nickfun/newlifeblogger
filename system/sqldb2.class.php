<?PHP

/**
 * SQLDB2: Easy interface to using MySQL
 *
 * @package NLB3
 * @author Nick F <nick@sevengraff.com>
 * @date 12-19-03
 */
class sqldb2 {
	var $qlog		= array();
	var $data 		= array();
	var $result 	= array();
	var $error 		= array();
	var $queryCount;
	var $sql;
	var $link;
	var $connected;
	var $debug		= true;

	/**
	 * @return VOID
	 * @param ARRAY
	 * @param BOOL
	 * @desc Constructor. First param is assoc array with connection info. 
	 */
	function sqldb2( $d = NULL , $conn = TRUE ) 	{
		if(is_array($d)) {
			$this->setConfig( $d );
		} 
		$this->queryCount = 0;	// holds number of querys
		// do we connect now?
		if($conn === TRUE) {
			$this->connect();
		}
		// specify destructor.
		register_shutdown_function(array(&$this, 'clear'));
	}
	
	/**
	 * @return VOID
	 * @param ARRAY
	 * @desc assigns config variables. 
	 */
	function setConfig( $d ) {
		if( !is_array($d) ) {
			$this->error = array(
				'action' => 'Setting Config',
				'error' => 'N/A',
				'errno' => 'N/A',
				'ref' => 'setConfig'
			);
			$this->errorReport();
		}
		$this->data['host'] 	= $d['location'];
		$this->data['username'] = $d['username'];
		$this->data['password'] = $d['password'];
		$this->data['db']		= $d['database'];
	}

	/**
	 * @return void
	 * @desc Connects to database.
	 */
	function connect() {
		if(!$this->link = @mysql_connect($this->data['host'], $this->data['username'], $this->data['password'])) {
			$this->error = array(
				'action' => 'Connecting to MySQL',
				'error' => mysql_error(),
				'errno' => mysql_errno(),
				'ref' => 'connect'
			);
			$this->errorReport();
		}
		if( $this->data['db'] ) {
			$this->selectDb();
		}
		$this->connected = true;
	}

	/**
	 * @return VOID
	 * @param [STRING]
	 * @desc Will switch databases or connect to new one.
	 */
	function selectDB( $newdb = false ) {
		$database = $this->data['db'];
		if( $newdb ) {
			$database = $newdb;
		}
		if( !mysql_select_db($database, $this->link) ) {
			$this->error = array(
				'action' => 'Selecting Database',
				'error' => mysql_error(),
				'errno' => mysql_errno(),
				'ref' => 'selectDB'
			);
			$this->errorReport();
		}
	}

	/**
	 * @return MIXED
	 * @param STRING
	 * @param [BOOL]
	 * @desc Runs a query, keeps count of # of querys. Called by other methods too.
	 */
	function query( $sql, $return = TRUE ) {
		$this->sql = trim($sql);	// mysql < 3 doesn't like whitespace at the end of q's.
		$this->qlog[] = $this->sql;
		
		if( !($this->result['query'] = mysql_query($this->sql, $this->link)) ) {
			$this->error = array(
				'action' => $sql,
				'error' => mysql_error(),
				'errno' => mysql_errno(),
				'ref' => 'query'
			);
			$this->errorReport();
		}
		$this->queryCount++;
		if( $return ) {
			return $this->result['query'];
		}
	}

	/**
	 * @return MIXED
	 * @param [STRING]
	 * @param [BOOL]
	 * @desc Will call query if needed, otherwise will return mysql_fetch_assoc of query
	 */
	function getArray( $sql = FALSE, $return = TRUE ) {
		if( $sql ) {
			// execute new query
			$this->query($sql, FALSE);
		}
		if( !$this->result['array'] = mysql_fetch_assoc($this->result['query'])) {
			$this->error = array(
				'action' => $sql,
				'error' => mysql_error(),
				'errno' => mysql_errno(),
				'ref' => 'getArray'
			);
			$this->errorReport();
		}
		if( $return ) {
			return $this->result['array'];
		}
	}

	/**
	 * @return MIXED
	 * @param [STRING]
	 * @param [STRING]
	 * @desc will process several rows of results into a large associative array.
	 */
	function getAllArray( $sql = FALSE, $return = TRUE ) {
		if( $sql ) {
			$this->query($sql, FALSE);
		}
		$allArr = array();
		while($row = mysql_fetch_assoc($this->result['query'])) {
			$allArr[] = $row;
		}
		$this->result['allArray'] = $allArr;
		if( $return ) {
			return $allArr;
		}
	}
	
	/**
	 * @return ARRAY
	 * @param [STRING]
	 * @param [STRING]
	 * @desc returns results of SQL query ready for ETS processing
	 */
	function getAllObject( $sql = false, $return = true ) {
		if( $sql ) {
			$this->query($sql, false);
		}
		$allObj = array();
		while( $row = mysql_fetch_object($this->result['query']) ) {
			$allObj[] = $row;
		}
		$this->result['allObj'] = $allObj;
		if( $return ) return $allObj;
	}
	
	/**
	 * @return int
	 * @desc calls mysql_insert_id on last query.
	 * @date 01-17-04
	 */
	function getLastId() {
		return mysql_insert_id();
	}

	/**
	 * @return INT
	 * @desc The number of querys made so far.
	 */
	function getQueryCount() {
		return $this->queryCount;
	}

	/**
	 * @return INT
	 * @desc Will try and decide how many rows were returned in the last query
	 */
	function getRowCount() {
		if( @$num = mysql_affected_rows($this->result['query']) ) {
			return $num;
		} else {
			return mysql_num_rows($this->result['query']);
		}
	}

	/**
	 * @return VOID
	 * @desc Prints a descriptive error report, triggered by mysql_error(), and then die().
	 */
	function errorReport() {
		if( $this->error['errno'] < 1 ) return;
		if( $this->debug == false ) {
			echo 'A MySQL related error has occured.<p>
			File: ' . $_SERVER['REQUEST_URI'] . '<br>
			TIME: ' . date('r');
			die();
		}
		$action = nl2br($this->error['action']);
		$error = nl2br($this->error['error']);
		$errno = nl2br($this->error['errno']);
		$date = date('n/d/Y h:i');
		echo <<< ERROR_OUTPUT
<html>
<head>
<title>sqldb2::errorReport()</title>
<style type="text/css">
div { color: #0000ff; border: 1px solid black; padding: 3px; }
tt { color: #ff0000; }
</style>
</head>
<body>
<div><b>MySQL Error:<b></div><p>
<div>Trying to execute:<br>
<tt>$action</tt>
</div> <p>
<div>Error Returned:<br>
<tt>$error</tt>
</div><p>
<div>Error Number:<br>
<tt>$errno</tt>
</div><p>
<div>
$date
</div>
<b><a href="http://www.sevengraff.com">sqldb2::errorReport()</a></b>
</body>
</html>
ERROR_OUTPUT;
		die();
	}
	
	/**
	 * @return void
	 * @desc only used for de-bugging
	 */
	function showLog() {
// 		debug( $this->qlog );
		foreach( $this->qlog as $q ) {
			echo '<div style="background-color: white; color: red; border: 1px solid black; padding: 2px; margin: 2px;">';
			echo '<pre>' . $q . '</pre>';
			echo "</div>\n";
		}
	}

	/**
	 * @return VOID
	 * @desc Destructor. Resets all properites, disconnects from database. 
	 */
	function clear() {
		if( $this->connected ) {
			mysql_close( $this->link );		// disconnect from database
		}
		// reset object properties
		$this->connected 	= false;
		$this->data 		= array();
		$this->result 		= array();
		$this->error 		= array();
		$this->queryCount 	= 0;
		$this->sql 			= null;
		$this->link			= null;
	}
	
	/**
	 * @return VOID
	 * @desc Will reset the query count to zero.
	 */
	function resetCount() {
		$this->queryCount = 0;
	}
}

?>