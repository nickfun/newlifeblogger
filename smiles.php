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
require_once 'ets.php';

$db = new sqldb2( $DB_CONFIG );

$smiles = $db->query( "SELECT * FROM " . db_smiles . ";");

$i = 0;
while( $row = mysql_fetch_assoc( $smiles ) ) {
	$ets->items[$i]->img = script_path . 'smiles/' . $row['image'];
	$ets->items[$i]->code = $row['code'];
	$ets->items[$i]->desc = $row['desc'];
	$i++;
}

$ets->java_script = <<< END_OF_JS
<script language="JavaScript" type="text/javascript">
<!--
function insertItem(text) {
	opener.document.new_entry.body.value += ' ' + text + ' '; 
}
//-->
</script>
END_OF_JS;

printt( $ets, skin_insert );

?>