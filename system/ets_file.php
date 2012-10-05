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
 * ETS functions for file-based cache system
 * Mostly from the ETS manual
 */

/**
 * @return mixed
 * @param string
 * @desc read cached file if its not obsolete
 * @date 01-17-04
 */
function ets_cache_read_handler( $id ) {
	$content = false;
	if( filemtime( cache_dir . $id ) > filemtime( skin_dir . $id ) ) {
		if( $fp = fopen( cache_dir . $id, 'rb' ) ) {
			$size = filesize( cache_dir . $id );
			$content = fread( $fp, $size );
			fclose( $fp );
		}
	}
	return $content;
}

/**
 * @return void
 * @param string
 * @param string
 * @desc Write cached file
 * @date 01-17-04
 */
function ets_cache_write_handler( $id, $content ) {
	if( $fp = fopen( cache_dir . $id, 'wb') ) {
		fwrite( $fp, $content );
		fclose( $fp );
	}
}

/**
 * @return mixed
 * @param string
 * @desc read a standard ets template file
 * @date 01-17-04
 */
function ets_source_read_handler( $id ) {
	$id = skin_dir . $id;
	$content = false;
	if( $fp = fopen( $id, 'rb' ) ) {
		$size = filesize( $id );
		$content = fread( $fp, $size );
		fclose( $fp );
	}
	return $content;
}

?>