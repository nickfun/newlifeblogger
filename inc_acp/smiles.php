<?PHP

/**
 * =======================================
 *		S M I L E   M A N A G E R 
 * =======================================
 */

if( !defined('IN_NLB3') ) {
	echo 'NLB3 Denies Direct Access';
	exit;
}

// very much inspiried by LDU :)
$ets_outter->main_title = $config->get('site_name') . ": " . $l['title-smiles'];
$ets_outter->page_title = $l['title-smiles'];
$USESKIN = skin_basic;
// get list of smiles.
$smiles = $db->getAllArray('SELECT * FROM ' . db_smiles . ' ORDER BY smile_id asc;');
$rows = count( $smiles );
$ets->page_body = '<table width="100%" class="nlb_table">
<tr><th colspan="5">' . $l['acp-smiles'] . '</th></tr>
<tr><td width="5%">' . $l['acp-smile'] . '</td><td>' . $l['acp-smilefile'] . '</td><td>' . $l['acp-code'] . '</td>
<td>' . $l['desc'] . '</td><td>' . $l['options'] . '</td></tr>';
foreach( $smiles as $row ) {
	$ets->page_body .= '
	<form method="post" action="admincp.php?action=edit_smile">
	<input type="hidden" name="smile_id" value="' . $row['smile_id'] . '">
	<tr><td width="5%"><img src="' . script_path . 'smiles/' . $row['image'] . '"></td>
	<td><input type="text" name="image" value="' . $row['image'] . '"></td>
	<td><input type="text" name="code" value="' . $row['code'] . '"></td>
	<td><input type="text" name="desc" value="' . $row['desc'] . '"></td>
	<td><input type="checkbox" name="delete" value="x">' . $l['delete'] . ' 
	<input type="submit" value="' . $l['update'] . '"></form>
	</td></tr>' . "\n";
}
$ets->page_body .= '
<tr><th colspan="5">New Smile</td></tr>
<tr><td colspan="2">' . $l['acp-smilefile'] . '</td>
<td>' . $l['acp-code'] . '</td>
<td>' . $l['desc'] . '</td>
<td>' . $l['acp-required'] . '</td></tr>
<form method="post" action="admincp.php?action=new_smile">
<tr><td colspan="2"><input type="text" name="image"></td>
<td><input type="text" name="code"></td>
<td><input type="text" name="desc"></td>
<td><input type="submit" value="' . $l['submit'] . '"></td>
</form></tr>
</table>';

?>