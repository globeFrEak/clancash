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

if (!isset($_GET['rowstart']) || !isNum($_GET['rowstart'])) {
    $rowstart = 0;
} else {
    $rowstart = $_GET['rowstart'];
}
$result = dbquery("SELECT * FROM " . DB_CCP_BUCHUNGEN . " $filter ORDER BY jahr DESC, monat DESC, tag DESC");
$rows = dbrows($result);
$result = dbquery("SELECT * FROM " . DB_CCP_BUCHUNGEN . " $filter ORDER BY jahr DESC, monat DESC, tag DESC LIMIT $rowstart,$b_per_page");

if ($rows > 0) {
    echo"<table class='tbl-border tbl_ccp' cellspacing='0' cellpadding='5'>";

    echo"<tr>\n
        <th class='tbl1'>" . $locale['ccp101'] . "</th>\n
        <th class='tbl1'>" . $locale['ccp105'] . "</th>\n                
        <th class='tbl1'>" . $locale['ccp136'] . "</th>\n
        <th class='tbl1'>" . $locale['ccp107'] . "</th>\n
        <th class='tbl1 ccp_right'>" . $locale['ccp104'] . "</th>\n
        <th class='tbl1 ccp_right'>" . $locale['ccp113'] . "</th>\n
      </tr>\n";
    $i = 1;
    while ($data = dbarray($result)) {
        $cell_color = ($i % 2 == 0 ? "tbl1" : "tbl2");
        if (checkgroup($set_admin_id) && $data['geloescht']) {
            $cell_color = "tbl_del";
        }
        $i++;
        $users = dbarray(dbquery("SELECT user_id, user_name, user_status FROM " . DB_USERS . " WHERE user_id=" . $data['user_id'] . ""));
        $kat = dbarray(dbquery("SELECT * FROM " . DB_CCP_KATEGORIEN . " WHERE id=" . $data['kat_id'] . ""));
        $konto = dbarray(dbquery("SELECT * FROM " . DB_CCP_KONTEN . " WHERE id=" . $data['konto_id'] . ""));
        $kategorie = $kat['kat_klartext'];
        $datum = $data['tag'] . "." . $data['monat'] . "." . $data['jahr'];
        $summe = number_format($data['valuta'], 2, $locale['ccp006'], $locale['ccp007']);
        ($summe >= 0 ? $valuta = "<span style='color:green;'>$summe </span>$set_symbol" : $valuta = "<span style='color:red;'>$summe </span>$set_symbol");

        echo"<tr>\n
        <td class='$cell_color'>$datum</td>\n
        <td class='$cell_color'>$kategorie</td>\n        
        <td class='$cell_color'>" . $konto['name'] . "</td>\n
        <td class='$cell_color'>" . profile_link($users['user_id'], $users['user_name'], $users['user_status']) . "</td>\n
        <td class='$cell_color ccp_right' style='white-space: nowrap'>$valuta</td>\n
        <td class='$cell_color ccp_right' style='white-space: nowrap'>";
        if (checkgroup($set_admin_id) && $data['geloescht']) {
            echo"<a href='" . INFUSIONS . "clancash_panel/ccp_admin_panel.php?year=$filter_jahr&amp;month=$filter_monat&amp;user=$filter_user&amp;cat=$filter_cat&amp;account=$filter_konto&delcom=" . $data['id'] . "' onclick='return ccp_ask_first(this)'><img src='" . INFUSIONS . "clancash_panel/images/delete.png' alt='" . $locale['ccp160'] . "' title='" . $locale['ccp160'] . "'></a>&nbsp;";
            echo"<a href='" . INFUSIONS . "clancash_panel/ccp_admin_panel.php?year=$filter_jahr&amp;month=$filter_monat&amp;user=$filter_user&amp;cat=$filter_cat&amp;account=$filter_konto&delret=" . $data['id'] . "' ><img src='" . INFUSIONS . "clancash_panel/images/returndel.png' alt='" . $locale['ccp114a'] . "' title='" . $locale['ccp112'] . "'></a>&nbsp;";
        } else if (checkgroup($set_admin_id)) {
            echo"<a href='" . INFUSIONS . "clancash_panel/ccp_admin_panel.php?year=$filter_jahr&amp;month=$filter_monat&amp;user=$filter_user&amp;cat=$filter_cat&amp;account=$filter_konto&edit=" . $data['id'] . "' ><img src='" . INFUSIONS . "clancash_panel/images/edit.png' alt='" . $locale['ccp113'] . "' title='" . $locale['ccp113'] . "'></a>&nbsp;";
            echo"<a href='" . INFUSIONS . "clancash_panel/ccp_admin_panel.php?year=$filter_jahr&amp;month=$filter_monat&amp;user=$filter_user&amp;cat=$filter_cat&amp;account=$filter_konto&del=" . $data['id'] . "' onclick='return ccp_ask_first(this)'><img src='" . INFUSIONS . "clancash_panel/images/temp-delete.png' alt='" . $locale['ccp114'] . "' title='" . $locale['ccp114'] . "'></a>";
        }
        echo"</td>\n</tr>\n";
        if ($data['comment']) {
            echo"<tr>\n<td class='$cell_color ccp_left' colspan='6'>" . $locale['ccp155'] . ": " . $data['comment'] . "</td>\n</tr>\n";
        }
    }
    echo "</table>";
} else {
    echo $keintrag;
}
echo "<div align='center' style='margin-top:5px;margin-bottom:5px;'>
" . makePageNav($rowstart, $b_per_page, $rows, 3, FUSION_SELF . "?year=$filter_jahr&amp;month=$filter_monat&amp;user=$filter_user&amp;cat=$filter_cat&amp;account=$filter_konto&") . "</div>\n";
?>
