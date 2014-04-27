<?php
/*--------------------------------------------------------------+
 | PHP-Fusion 7 Content Management System             		|
 +--------------------------------------------------------------+
 | Copyright © 2002 - 2013 Nick Jones                 		|
 | http://www.php-fusion.co.uk/                       		|
 +--------------------------------------------------------------+
 | Infusion: ClanCash                                 		|
 | Author:                                            		|
 | RedDragon(v6) 	    http://www.efc-funclan.de      	|
 | globeFrEak (v7) 		http://www.cwclan.de           	|
 | GUL-Sonic (v7.02)	http://www.germanys-united-legends.de 	|
 +--------------------------------------------------------------+
 | This program is released as free software under the		|
 | Affero GPL license. You can redistribute it and/or		|
 | modify it under the terms of this license which you		|
 | can read by viewing the included agpl.txt or online		|
 | at www.gnu.org/licenses/agpl.html. Removal of this		|
 | copyright header is strictly prohibited without		|
 | written permission from the original author(s).		|
 +--------------------------------------------------------------*/
//Get donation amounts from db...
$result = dbquery("SELECT subtype, value, name FROM " . DB_CCP_PAYPAL);
while ($data = dbarray($result)) {
    switch ($data['subtype']) {
        case 1:
            $amount_value_1 = $data['value'];
			$amount_name_1 = $data['name'];
            break;
        case 2:
            $amount_value_2 = $data['value'];
			$amount_name_2 = $data['name'];
            break;
        case 3:
            $amount_value_3 = $data['value'];
			$amount_name_3 = $data['name'];
            break;
        case 4:
            $amount_value_4 = $data['value'];
			$amount_name_4 = $data['name'];
            break;
    }
}
echo"	
  <tr>
  <td class='tbl1' align='center' width='50%'>" . $locale['ccp189'] . "</td>
    <td class='tbl1' align='left' width='50%'>
      <select name='paypal_beitrag_checked' class='textbox'>
        <option " . ($ed_paypal_beitrag_checked == 1 ? "selected='selected'" : "") . " value='1' style='text-align:center'>1</option>
        <option " . ($ed_paypal_beitrag_checked == 2 ? "selected='selected'" : "") . " value='2' style='text-align:center'>2</option>
        <option " . ($ed_paypal_beitrag_checked == 3 ? "selected='selected'" : "") . " value='3' style='text-align:center'>3</option>
        <option " . ($ed_paypal_beitrag_checked == 4 ? "selected='selected'" : "") . " value='4' style='text-align:center'>4</option>
      </select>
  </tr><tr>
    <td align='right'>&nbsp;</td>
    <td>&nbsp;</td>
</tr><tr align='center'> 
    <td colspan='2'><b>" . $locale['ccp189'] . "</b><br>
        <table align='center' style='border: 1px solid #404050' cellpadding='2' cellspacing='0'>
            <tr> 
                <td align='center'><b>Nummer</b></td>
                <td align='center'><b>Betrag</b></td>
				<td align='center'><b>Bezeichnung</b></td>
            </tr>
            <tr>
                <td align='center'>1</td>
	        <td title='" . $locale['ccp191'] . "' align='center'><input size='4' name='var_amount_1' type='text' value='" . $amount_value_1 . "' onChange='return validInt(this,'Suggested Donation Amount #1',1);'></td>
			<td align='center'><input type='textbox' name='var_name_1' size='31' maxlength='30' value='".$amount_name_1."' placeholder='".$locale['ccp198']."'></td>
            </tr>
            <tr>
		<td align='center'>2</td>
	        <td title='" . $locale['ccp191'] . "' align='center'><input size='4' name='var_amount_2' type='text' value='" . $amount_value_2 . "' onChange='return validInt(this,'Suggested Donation Amount #2',1);'></td>
			<td align='center'><input type='textbox' name='var_name_2' size='31' maxlength='30' value='".$amount_name_2."' placeholder='".$locale['ccp198']."'></td>
            </tr>
            <tr>
		<td align='center'>3</td>
	        <td title='" . $locale['ccp191'] . "' align='center'><input size='4' name='var_amount_3' type='text' value='" . $amount_value_3 . "' onChange='return validInt(this,'Suggested Donation Amount #3',1);'></td>
			<td align='center'><input type='textbox' name='var_name_3' size='31' maxlength='30' value='".$amount_name_3."' placeholder='".$locale['ccp198']."'></td>
            </tr>
            <tr>
		<td align='center'>4</td>
	        <td title='" . $locale['ccp191'] . "' align='center'><input size='4' name='var_amount_4' type='text' value='" . $amount_value_4 . "' onChange='return validInt(this,'Suggested Donation Amount #4',1);'></td>
			<td align='center'><input type='textbox' name='var_name_4' size='31' maxlength='30' value='".$amount_name_4."' placeholder='".$locale['ccp198']."'></td> 
	    </tr>
        </table>
    </td>
</tr>";
?>
