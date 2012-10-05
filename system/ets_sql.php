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
 * ETS functions for Database-based cache system
 */

/**
 * @return mixed
 * @param string
 * @desc read cached file if its not obsolete
 * @date 01-17-04
 */
function ets_cache_read_handler( $pass ) {
	global $db;
	$content = false;
	$pass = unserialize( $pass );
	if( $pass['type'] == 'outter' ) {
		$result = $db->query("SELECT name, value FROM " . db_config . " WHERE name LIKE 'outter_template%';");
		while( $row = mysql_fetch_assoc( $result ) ) {
			$items[ $row['name'] ] = stripslashes( $row['value'] );
		}
		if( $items['outter_template_source_time'] > $items['outter_template_cache_time'] ) {
			return false;
		} else {
			return $items['outter_template_cache'];
		}
	} else {
		$user_id = $pass['user_id'];
		$type = $pass['type'];
		// get times
		$times = $db->getArray("SELECT s.${type}_updated as source, c.${type}_updated as cache
		FROM " . db_source. " as s, " . db_cache . " as c 
		WHERE s.owner_id = '$user_id' AND c.owner_id = '$user_id';");
		if( $times['cache'] > $times['source'] ) {
			// use cache.
			$content = $db->getArray("SELECT $type as content FROM " . db_cache . " WHERE owner_id = $user_id;");
			return $content['content'];
		} else {
			return false;
		}
	}
	return false;
}

/**
 * @return void
 * @param string
 * @param string
 * @desc Write cached file
 * @date 02-02-04
 */
function ets_cache_write_handler( $id, $content ) {
	global $db;
	$pass = unserialize( $id );
	$content = addslashes( $content );
	if( $pass['type'] == 'outter' ) {
		$now = time();
		// update cache
		$db->query("UPDATE " . db_config . "
		SET value = \"$content\"
		WHERE name = \"outter_template_cache\";");
		// update time
		$db->query("UPDATE " . db_config . "
		SET value = '$now'
		WHERE name='outter_template_cache_time';");
	} else {
		$type = $pass['type'];
		$user_id = $pass['user_id'];
		$now = time();
		// update cache 
		$db->query("UPDATE " . db_cache . "
		SET {$type}_updated = '$now',
		$type = '$content'
		WHERE owner_id = '$user_id';");
	}		
}

/**
 * @return mixed
 * @param string
 * @desc read a standard ets template file
 * @date 01-17-04
 */
function ets_source_read_handler( $id ) {
	global $db;
	$pass = unserialize( $id );
	if( $pass['type'] == 'outter' ) {
		$get = $db->getArray("SELECT value as content FROM " . db_config . " WHERE name='outter_template_source';");
		return $get['content'];
	} else {
		$type = $pass['type'];
		$user_id = $pass['user_id'];
		$get = $db->getArray("SELECT $type as content FROM " . db_source . " WHERE owner_id = '$user_id';");
		return $get['content'];
	}
}

?>