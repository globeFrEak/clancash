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
if (!defined("IN_FUSION") || !IN_FUSION)
    die("Access denied!");

if (file_exists(INFUSIONS . "clancash_panel/locale/" . $settings['locale'] . ".php")) {
    include INFUSIONS . "clancash_panel/locale/" . $settings['locale'] . ".php";
} else {
    include INFUSIONS . "clancash_panel/locale/English.php";
}
include_once INFUSIONS . "clancash_panel/ccp_functions.php";

if (!checkgroup($set_member_id) && !checkgroup($set_admin_id))
    redirect("../../login.php");
$view_jahr = (isset($_POST['filter_jahr'])) ? $_POST['filter_jahr'] : $akt_jahr;
$view = (isset($_POST['view'])) ? $_POST['view'] : "";
$openkonten = (isset($_POST['view'])) ? "on" : "off";
$openview = (isset($_POST['view_jahr'])) ? "on" : "off";
$opengraph = (isset($_POST['view_jahr'])) ? "on" : "off";
$box_img_konto = ($openkonten == "on" ? "off" : "on");
$box_img_view = ($openview == "on" ? "off" : "on");
$box_img_graph = ($opengraph == "on" ? "off" : "on");

echo"<form name='zahlungen' method='post' enctype='multipart/form-data' action='" . FUSION_SELF . "'>
    <table class='tbl-border tbl_ccp' cellpadding='1'>
    <td></td>";
$monat = explode("|", $locale['shortmonths']);
for ($sp = 0; $sp < 12; $sp++) {
    echo "<td style='width:7%;'>" . $monat[$sp + 1] . "</td>";
}
echo"</tr>";
if ($set_member_id == 0 || 101 || 102 || 103) {
    if ($set_member_id == 101) {
        $result = dbquery("SELECT a.user_id, a.user_name, a.user_status FROM " . DB_USERS . " AS a, " . DB_CCP_BUCHUNGEN . " AS b WHERE b.jahr='$view_jahr' AND b.geloescht='0' AND a.user_id=b.user_id GROUP BY a.user_name ORDER BY a.user_name");
    } elseif ($set_member_id == 102 || 103) {
        $result = dbquery("SELECT a.user_id, a.user_name, a.user_status FROM " . DB_USERS . " AS a, " . DB_CCP_BUCHUNGEN . " AS b WHERE a.user_level = " . $set_member_id . " AND b.jahr='$view_jahr' AND b.geloescht='0' AND a.user_id=b.user_id GROUP BY a.user_name ORDER BY user_name");
    }
} else {
    $result = dbquery("SELECT a.user_id, a.user_name, a.user_status FROM " . DB_USERS . " AS a, " . DB_CCP_BUCHUNGEN . " AS b WHERE a.user_groups REGEXP('^\\\.{$set_member_id}$|\\\.{$set_member_id}\\\.|\\\.{$set_member_id}$') AND b.jahr='$view_jahr' AND b.geloescht='0' AND a.user_id=b.user_id GROUP BY a.user_name ORDER BY user_name");
}
while ($data = dbarray($result)) {
    for ($count_monat = 1; $count_monat < 13; $count_monat++) {
        $db_total = dbarray(dbquery("SELECT ROUND(SUM(valuta), 2) AS total FROM " . DB_CCP_BUCHUNGEN . " WHERE jahr='$view_jahr' AND monat='$count_monat' AND user_id='" . $data['user_id'] . "' AND geloescht='0'"));
        $summe = number_format($db_total['total'], 2, $locale['ccp006'], $locale['ccp007']);
        ${"total_" . $count_monat} = $summe;
        ${"total_op" . $count_monat} = $db_total['total'];
    }
    $cell_color = ($i % 2 == 0 ? "tbl1" : "tbl2");
    $i++;
    for ($nr = 1; $nr < 13; $nr++) {
        if (${"total_op" . $nr} > 0 || ${"total_" . $nr} < 0) {
            ${"col_" . $nr} = "<a href='" . INFUSIONS . "clancash_panel/ccp_clancash.php?user=" . $data['user_id'] . "&amp;year=$view_jahr&amp;month=$nr&amp;cat=all&amp;account=all'>" . ${"total_" . $nr} . " $set_symbol</a>";
        } else {
            ${"col_" . $nr} = "";
        }
    }
    if ($show_names == 1 || (iSUPERADMIN)) {
        $username = profile_link($data['user_id'], $data['user_name'], $data['user_status']);
        $name = $data['user_name'];
    } else {
        $username = $name = $placeholder_name;
    }
    echo"<tr>
              <td class='$cell_color ccp_left'><img src='" . INFUSIONS . "clancash_panel/images/user_16.png' alt='" . $locale['user1'] . "&nbsp;" . $name . "' title='" . $locale['user1'] . "&nbsp;" . $name . "'>&nbsp;" . $username . "</td>\n";
    for ($c = 1; $c < 13; $c++) {
        echo"<td class='$cell_color'>" . ${"col_" . $c} . "</td>\n";
    }
    echo"</tr>";
}
// Auslesen der Buchungen ohne User Bezug!!///
$result = dbquery("SELECT a.id, a.kat_klartext FROM " . DB_CCP_KATEGORIEN . " AS a, " . DB_CCP_BUCHUNGEN . " AS b WHERE b.geloescht='0' AND a.id=b.kat_id AND a.id!='3' GROUP BY a.id ORDER BY a.id");
if (dbrows($result) > 0) {
    while ($data = dbarray($result)) {
        for ($count_monat = 1; $count_monat < 13; $count_monat++) {
            $db_total = dbarray(dbquery("SELECT ROUND(SUM(valuta), 2) AS total FROM " . DB_CCP_BUCHUNGEN . " WHERE jahr='$view_jahr' AND monat='$count_monat' AND user_id='0' AND geloescht='0' AND kat_id='" . $data['id'] . "'"));
            $summe = number_format($db_total['total'], 2, $locale['ccp006'], $locale['ccp007']);
            ${"total_" . $count_monat} = $summe;
        }
        $cell_color = ($i % 2 == 0 ? "tbl1" : "tbl2");
        $i++;
        for ($nr = 1; $nr < 13; $nr++) {
            ${"col_" . $nr} = (${"total_" . $nr} <> 0 ? ${"total_" . $nr} . " $set_symbol" : "");
        }
        echo"<tr>
              <td class='$cell_color ccp_left'><img src='" . INFUSIONS . "clancash_panel/images/cats_16.png' alt='" . $locale['ccp102'] . "&nbsp;" . $data['kat_klartext'] . "' title='" . $locale['ccp102'] . "&nbsp;" . $data['kat_klartext'] . "'>&nbsp;" . $data['kat_klartext'] . "</td>\n";
        for ($c = 1; $c < 13; $c++) {
            echo"<td class='$cell_color'>" . ${"col_" . $c} . "</td>\n";
        }
        echo"</tr>";
    }
}
echo"</table></form>";
?>
