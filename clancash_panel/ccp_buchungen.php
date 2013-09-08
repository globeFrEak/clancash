<?php
/*---------------------------------------------------+
| PHP-Fusion 7 Content Management System
+----------------------------------------------------+
| Copyright © 2002 - 2013 Nick Jones
| http://www.php-fusion.co.uk/
|----------------------------------------------------+
| Infusion: Clankasse
| Filename: ccp_admin_panel.php
| Author: 
| RedDragon(v6) 	http://www.efc-funclan.de
| globeFrEak (v7) 	http://www.cwclan.de
| Sonic (v7.02)		http://www.germanys-united-legends.de
+----------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+----------------------------------------------------*/
if (!defined("IN_FUSION") || !IN_FUSION) die("Access denied!");

if (file_exists(INFUSIONS."clancash_panel/locale/".$settings['locale'].".php")) {
    include INFUSIONS."clancash_panel/locale/".$settings['locale'].".php";
} else {
    include INFUSIONS."clancash_panel/locale/English.php";
}

if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;
if (dbrows(dbquery("SELECT * FROM ".DB_CCP_BUCHUNGEN." $filter")) == 0) echo $keintrag;
else {
$result = dbquery("SELECT * FROM ".DB_CCP_BUCHUNGEN." $filter ORDER BY jahr DESC, monat DESC, tag DESC LIMIT $rowstart,$b_per_page");
echo"<div><table class='tbl-border' width='100%'>";
while ($data = dbarray($result)){
  $cell_color = ($i % 2 == 0 ? "tbl1" : "tbl2"); $i++;
  $users = dbarray(dbquery("SELECT * FROM ".DB_USERS." WHERE user_id=".$data['user_id'].""));
  $kat   = dbarray(dbquery("SELECT * FROM ".DB_CCP_KATEGORIEN." WHERE id=".$data['kat_id'].""));
  $konto = dbarray(dbquery("SELECT * FROM ".DB_CCP_KONTEN." WHERE id=".$data['konto_id'].""));
  $kategorie = $kat['kat_klartext'];
  $datum = $data['tag'].".".$data['monat'].".".$data['jahr'];
  $summe = round($data['valuta'],2);
  $summe = number_format($summe,2,',','.');
  ($summe >= 0 ? $valuta = "<span style='color:green;'>$summe </span>$set_symbol" : $valuta ="<span style='color:red;'>$summe </span>$set_symbol");

echo"<tr>\n
        <td style='width:10%' class='$cell_color' align='center'>$datum</td>\n
        <td style='width:20%' class='$cell_color' align='center'>$kategorie&nbsp;</td>\n
        <td style='width:30%' class='$cell_color' align='center'>".$users['user_name']."</td>\n
        <td class='$cell_color' style='text-align: center;width:20%;'>".$konto['name']."</td>\n
        <td class='$cell_color' style='text-align: right;width:10%;'>$valuta</td>\n
      </tr>\n
      <tr>\n
        <td style='width:15%' class='$cell_color' colspan='3'>".$data['comment']."</td>\n
        <td class='$cell_color' colspan='2' style='text-align: right;width:75%;'>";
        if(checkgroup($set_admin_id) && $data['geloescht'])echo"<font style='color:red'>".$locale['ccp112']."</font> --- <a href='".INFUSIONS."clancash_panel/ccp_admin_panel.php?delcom=".$data['id']."' onclick='return ccp_ask_first(this)'>".$locale['ccp160']."</a>";
          else if(checkgroup($set_admin_id))echo"<a href='".INFUSIONS."clancash_panel/ccp_admin_panel.php?edit=".$data['id']."' >".$locale['ccp113']."</a> -- <a href='".INFUSIONS."clancash_panel/ccp_admin_panel.php?del=".$data['id']."' onclick='return ccp_ask_first(this)'>".$locale['ccp114']."</a>";
        echo"</td>\n
      </tr>
    <tr style='height:1'><td colspan='5'></td></tr>";
}
echo "</table></div>";}
$rows = dbrows(dbquery("SELECT * FROM ".DB_CCP_BUCHUNGEN." $filter"));
echo "<div align='center' style='margin-top:5px;margin-bottom:5px;'>
".makePageNav($rowstart,$b_per_page,$rows,3,FUSION_SELF."?year=$filter_jahr&amp;month=$filter_monat&amp;user=$filter_user&amp;cat=$filter_cat&amp;account=$filter_konto&")."</div>\n";
?>
