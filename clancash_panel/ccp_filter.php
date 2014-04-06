<?php

/* --------------------------------------------------------------+
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
  +-------------------------------------------------------------- */
if (!defined("IN_FUSION") || !IN_FUSION)
    die("Access denied!");

//vars
$fzeichen = "-";

$filter7 = ($is_admin == 0 ? "geloescht='0'" : "");
$and5 = ($filter7 != '' && ($filter_monat != 'all' || $filter_jahr != 'all' || $filter_user != 'all' || $filter_cat != 'all' || $filter_konto != 'all') ? "AND " : "");
$filter6 = ($filter_konto != 'all' ? "konto_id='$filter_konto' " : "");
$and4 = ($filter6 != '' && ($filter_monat != 'all' || $filter_jahr != 'all' || $filter_user != 'all' || $filter_cat != 'all') ? "AND " : "");
$filter5 = ($filter_cat != 'all' ? "kat_id='$filter_cat' " : "");
$and3 = ($filter5 != '' && ($filter_monat != 'all' || $filter_jahr != 'all' || $filter_user != 'all') ? "AND " : "");
$filter4 = ($filter_monat != 'all' ? "monat='$filter_monat' " : "");
$and2 = ($filter4 != '' && ($filter_user != 'all' || $filter_jahr != 'all') ? "AND " : "");
$filter3 = ($filter_jahr != 'all' ? "jahr='$filter_jahr' " : "");
$and1 = ($filter3 != '' && $filter_user != 'all' ? "AND " : "");
if ($show_all == 1) {
    $filter2 = ($filter_user != 'all' ? "user_id='$filter_user' " : "");
} else {
    $filter2 = ($filter_user != 'all' ? "user_id='$filter_user' OR user_id='0' " : "");
}
$filter1 = ($filter2 != '' || $filter3 != '' || $filter4 != '' || $filter5 != '' || $filter6 != '' || $filter7 != '' ? "WHERE " : "");
$filter = "$filter1$filter2$and1$filter3$and2$filter4$and3$filter5$and4$filter6$and5$filter7";
$and = ($filter == '' && $is_admin == 1 ? "WHERE geloescht='0'" : "AND geloescht='0'");
$data = dbarray(dbquery("SELECT SUM(valuta) AS summe FROM " . DB_CCP_BUCHUNGEN . " $filter1$filter2$and1$filter3$and2$filter4$and3$filter5$and4$filter6$and5$filter7 $and"));

$fsumme = number_format($data['summe'], 2, $locale['ccp006'], $locale['ccp007']);
$fvaluta = $fsumme . "&nbsp;" . $set_symbol;
//echo "$filter";   //Filter debugging
echo "<form name='filter' method='post' enctype='multipart/form-data' action='" . FUSION_SELF . "'>
      <div>
      <table class='tbl-border tbl_ccp'>
      <tr>
        <td width='10%' class='tbl1' align='center'>" . $locale['ccp125'] . "</td>\n
        <td width='10%' class='tbl1' align='center'>" . $locale['ccp126'] . "</td>\n";
if ($is_admin == 1)
    echo"
          <td width='15%' class='tbl1'>" . $locale['ccp107'] . "</td>\n
          <td width='15%' class='tbl1'>" . $locale['ccp105'] . "</td>\n
          <td width='15%' class='tbl1'>" . $locale['ccp106'] . "</td>\n
          <td width='20%' class='tbl1'>" . $locale['ccp104'] . "</td>\n
          <td width='15%' class='tbl1'><a href='" . INFUSIONS . "clancash_panel/ccp_admin_panel.php" . $aidlink . "'>Admincenter</a></td>\n";
else
    echo"
          <td width='70%' colspan='2' class='tbl1'></td>\n";
echo"
      </tr>
      <tr>
        <td width='10%' class='tbl1 ccp_right'><select name='filter_monat' class='textbox' style='width:95%;' onChange='document.filter.submit();'>\n
          <option value='all' style='text-align:center'>" . $locale['ccp128'] . "</option>\n";
$monat = 0;
while ($monat < 12) {
    $monat = $monat + 1;
    echo "<option" . ($monat == $filter_monat ? " selected" : "") . " value='$monat' style='text-align:center'>$monat</option>\n";
}
echo"</select>
        </td>
        <td width='10%'class='tbl1 ccp_right' style='border:0'><select name='filter_jahr' class='textbox' style='width:95%;text-align:center;' onChange='document.filter.submit();'>\n
          <option value='all' style='text-align:center'>" . $locale['ccp128'] . "</option>\n";
$admin_filter = ($is_admin == 0 ? "WHERE geloescht='0'" : "");
$data = dbarray(dbquery("SELECT MIN(jahr) AS min FROM " . DB_CCP_BUCHUNGEN . " $admin_filter"));
$jahre = $akt_jahr - $data['min'] + 1;
$jahr = $akt_jahr - $jahre;
while ($jahr < $akt_jahr) {
    $jahr = $jahr + 1;
    echo "<option" . ($jahr == $filter_jahr ? " selected" : "") . " value='$jahr' style='text-align:center'>$jahr</option>\n";
}
echo"</select></td>";
if ($is_admin == 1) {
    echo"
            <td width='15%' class='tbl1 ccp_right'><select name='filter_user' class='textbox' style='width:95%; text-align:center; ' onChange='document.filter.submit();'>\n
            <option value='all' style='text-align:center'>" . $locale['ccp128'] . "</option>\n";
    $result = dbquery("SELECT DISTINCT " . DB_USERS . ".user_id," . DB_USERS . ".user_name FROM " . DB_CCP_BUCHUNGEN . "," . DB_USERS . " WHERE " . DB_CCP_BUCHUNGEN . ".user_id = " . DB_USERS . ".user_id ORDER BY user_name");
    while ($data = dbarray($result)) {
        echo "<option" . ($data['user_id'] == $filter_user ? " selected" : "") . " value='" . $data['user_id'] . "' style='text-align:center'>" . $data['user_name'] . "</option>\n";
    }
    echo" </select>
            </td>
            <td width='15%' class='tbl1 ccp_right'><select name='filter_cat' class='textbox' style='width:95%; text-align:center; ' onChange='document.filter.submit();'>\n
            <option value='all' style='text-align:center'>" . $locale['ccp128'] . "</option>\n";
    $result = dbquery("SELECT * FROM " . DB_CCP_KATEGORIEN);
    while ($data = dbarray($result)) {
        echo "<option" . ($data['id'] == $filter_cat ? " selected" : "") . " value='" . $data['id'] . "' style='text-align:center'>" . $data['kat_klartext'] . "</option>\n";
    }
    echo"</select></td>
            <td width='15%' class='tbl1 ccp_right'><select name='filter_konto' class='textbox' style='width:95%; text-align:center; ' onChange='document.filter.submit();'>\n
            <option value='all' style='text-align:center'>" . $locale['ccp128'] . "</option>\n";
    $result = dbquery("SELECT * FROM " . DB_CCP_KONTEN);
    while ($data = dbarray($result)) {
        echo "<option" . ($data['id'] == $filter_konto ? " selected" : "") . " value='" . $data['id'] . "' style='text-align:center'>" . $data['name'] . "</option>\n";
    }
    echo"</select></td>
            <td width='10%' class='tbl1'>$fvaluta</td>";
} else
    echo"<input type='hidden' name='filter_user' value='all'>\n
                  <input type='hidden' name='filter_cat' value='all'>\n
                  <input type='hidden' name='filter_konto' value='all'>\n
                  <td width='60%' class='tbl1'>&nbsp;</td>";

if ((isset($_POST['reset']))) {
    echo "<td align='center'></td>";
} elseif ((isset($_POST['filter_jahr'])) || (isset($_POST['filter_monat'])) || (isset($_POST['filter_user'])) || (isset($_POST['filter_cat'])) || (isset($_POST['filter_konto']))) {
    echo "<td align='center'><input type='submit' name='reset' class='button' style='width:75' value='" . $locale['ccp129'] . "'></td>";
}
echo "</tr>
      </table>
      </div></form>";
?>
