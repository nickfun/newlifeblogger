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
require_once 'system/nlb_config.class.php';
require_once 'ets.php';

$db = new sqldb2( $DB_CONFIG );
$config = new nlb_config( $db );

include $config->langFile();

$bbcode_image_folder = skin_dir . 'bb/';

$codes = array();
$codes[] = array( $l['bb-bold'], 		'bold.gif', 		'[b] [/b]');
$codes[] = array( $l['bb-italic'], 		'italic.gif', 		'[i] [/i]');
$codes[] = array( $l['bb-underline'], 	'underline.gif', 	'[u] [/u]');
$codes[] = array( $l['bb-code'], 		'code.gif', 		'[code] [/code]');
$codes[] = array( $l['bb-img'], 		'img.gif', 			'[img] [/img]');
$codes[] = array( $l['bb-url'], 		'url.gif', 		'[url] [/url]');
$codes[] = array( $l['bb-quote'], 		'quote.gif', 		'[quote] [/quote]');

$i=0;
foreach( $codes as $bb ) {
	$ets->items[$i]->desc = $bb[0];
	$ets->items[$i]->img  = $bbcode_image_folder . $bb[1];
	$ets->items[$i]->code = $bb[2];
	$i++;
}

$ets->java_script = <<< END_OF_JS
<script language="JavaScript" type="text/javascript">
<!--
function insertItem(text) {
	opener.document.new_entry.body.value += text; 
}
//-->
</script>
END_OF_JS;

printt( $ets, skin_insert );

?>