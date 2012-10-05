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
 * Handles config stored in database
 *
 * @package NLB3
 * @author Nick F <nick@sevengraff.com>
 * @date 01-05-04
 */
class nlb_config {
	
	var $sql;			// pointer to sqldb2 object
	var $config;		// holds config data
	
	/**
	 * @return VOID
	 * @param OBJECT $db sqldb2 object that is connected to DB
	 * @desc Constructor. Gets all config info from db and manages it.
	 * @date 01-05-03
	 */
	function nlb_config( & $db ) {
		$this->sql =& $db;
		$this->fetch_all_info();
	}
	
	/**
	 * @return VOID
	 * @desc Querys the database for config info, store it as array $config
	 * @date 01-05-04
	 */
	function fetch_all_info () {
		$data = $this->sql->query("SELECT name, value FROM " . db_config . " ORDER BY config_id ASC;");
		while( $row = mysql_fetch_assoc( $data ) ) {
			$this->config[$row['name']] = $row['value'];
		}
	}
	
	/**
	 * @return VOID
	 * @param STRING $name Name of config item
	 * @param STRING $value Value of config item
	 * @desc updates LOCAL value of config item
	 * @date 01-05-04
	 */
	function set( $name, $value ) {
		if( isset($this->config[$name] ) ) {
			$this->config[$name] = $value;
		}
	}
	
	/** 
	 * @return STRING
	 * @param STRING $name Name of config item
	 * @desc Returns value of config item $name
	 * @date 01-05-04
	 */
	function get( $name ) {
		if( $this->config[$name] ) {
			return $this->config[$name];
		} else {
			return false;
		}
	}
	
	/**
	 * @return VOID
	 * @param STRING
	 * @param STRING
	 * @desct Inserts new config item into database and local info
	 * @date 01-05-04
	 */
	function newConfig( $name, $value ) {
		$this->sql->query("INSERT INTO `" . db_config . "` VALUES ( '', '$name', '$value' );");
		$this->config[$name] = $value;
	}

	/**
	 * @return VOID
	 * @param STRING
	 * @desc Updates the database for ONE config item.
	 * @date 01-05-04
	 */
	function updateDb( $item ) {
		if( isset($this->config[$item]) ) {
			$this->sql->query("UPDATE TABLE `" . db_config . "` SET '$item' = '" . $this->config[$item] . "' WHERE name='$item' LIMIT 1;");
		}
	}
	
	/**
	 * @return STRING
	 * @desc Returns path to chose lang file
	 * @date 01-09-04
	 */
	function langfile() {
		return 'lang/' . $this->get('lang') . '.php';
	}
	
}

?>