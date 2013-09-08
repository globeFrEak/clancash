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
require_once "../../maincore.php";
require_once THEMES."templates/header.php";
include INFUSIONS."clancash_panel/infusion_db.php";

if (file_exists(INFUSIONS."clancash_panel/locale/".$settings['locale'].".php")) {
    include INFUSIONS."clancash_panel/locale/".$settings['locale'].".php";
} else {
    include INFUSIONS."clancash_panel/locale/English.php";
}

include INFUSIONS."clancash_panel/ccp_functions.php";

if (!checkgroup($set_admin_id)) redirect("../../login.php");

$del = (isset($_POST['del'])) ? $_POST['del'] : "";
$edit = (isset($_POST['edit'])) ? $_POST['edit'] : "";
$anzahl = (isset($_POST['anzahl'])) ? $_POST['anzahl'] : "";
$betrag = (isset($_POST['betrag'])) ? $_POST['betrag'] : "";
$zweck = (isset($_POST['zweck'])) ? $_POST['zweck'] : "";
$art = (isset($_POST['art'])) ? $_POST['art'] : "";
$bmonat = (isset($_POST['bmonat'])) ? $_POST['bmonat'] : "";
$einaus = (isset($_POST['einaus'])) ? $_POST['einaus'] : "";
$ed_anzahl = (isset($_POST['ed_anzahl'])) ? $_POST['ed_anzahl'] : "";
$ed_art = (isset($_POST['ed_art'])) ? $_POST['ed_art'] : "";
$ed_check_m = (isset($_POST['ed_check_m'])) ? $_POST['ed_check_m'] : "";
$ed_check_p = (isset($_POST['ed_check_p'])) ? $_POST['ed_check_p'] : "";
$ed_id = (isset($_POST['ed_id'])) ? $_POST['ed_id'] : "";
$ed_zweck = (isset($_POST['ed_zweck'])) ? $_POST['ed_zweck'] : "";
$cell_color =(isset($_POST['cell_color'])) ? $_POST['cell_color'] : "";

if ((isset($_GET['del'])) != ''){
  $del = $_GET['del'];
  dbquery("DELETE FROM ".DB_CCP_BUDGET." WHERE ID='$del'");
  echo $geloescht;
  tablebreak();
}

if ((isset($_GET['edit'])) != ''){
  $edit = $_GET['edit'];
  $update = dbarray(dbquery("SELECT * FROM ".DB_CCP_BUDGET." WHERE id='$edit'"));
  $ed_anzahl = $update['anzahl'];
  $ed_valuta = ($update['betrag'] < 0 ? $update['betrag'] * -1 : $update['betrag']);
  $ed_zweck = $update['zweck'];
  $ed_art = $update['art'];
  $ed_check_p = ($update['bmonat'] > 0 ? "selected " : " ");
  $ed_check_m = ($update['bmonat'] < 0 ? "selected " : " ");
}

if (isset($_POST['save'])) {     
    if ($_POST['anzahl'] == '' || $_POST['betrag'] == '0' || $_POST['zweck'] == '' || $_POST['art'] == ''){ 
    echo $ngespeichert;tablebreak();
      $ed_anzahl = $_POST['anzahl'];
      $ed_valuta = str_replace(',', '.', $_POST['betrag']);
      $ed_zweck = $_POST['zweck'];
      $ed_art = $_POST['art'];
      $ed_check_p = ($_POST['einaus'] > 0 ? "selected " : " ");
      $ed_check_m = ($_POST['einaus'] < 0 ? "selected " : " ");
   }else {
    $betrag = str_replace(',', '.', $_POST['betrag']);
    IF ($_POST['art'] == 1) {$bmonat = $_POST['anzahl'] * $betrag * 30;}
            else if ($_POST['art'] == 2) {$bmonat = $_POST['anzahl'] * $betrag;}
            else if ($_POST['art'] == 3) {$bmonat = $_POST['anzahl'] * $betrag / 3;}
            else if ($_POST['art'] == 4) {$bmonat = $_POST['anzahl'] * $betrag / 6;}
            else if ($_POST['art'] == 5) {$bmonat = $_POST['anzahl'] * $betrag / 12;}
      dbquery("INSERT ".DB_CCP_BUDGET." SET
      anzahl = '".stripinput($_POST['anzahl'])."',
      betrag = '".stripinput($betrag)* stripinput($_POST['einaus'])."',
      zweck = '".stripinput($_POST['zweck'])."',
      art = '".stripinput($_POST['art'])."',
      bmonat = '".stripinput($bmonat * $_POST['einaus'])."'");
      echo $gespeichert;
      tablebreak();
     }    
}

if (isset($_POST['update'])) {
    if ($_POST['anzahl'] == '' || $_POST['betrag'] == '0' || $_POST['zweck'] == '' || $_POST['art'] == ''){ 
    echo $ngespeichert;tablebreak();
      $ed_anzahl = $_POST['anzahl'];
      $ed_valuta = $_POST['betrag'];
      $ed_zweck = $_POST['zweck'];
      $ed_art = $_POST['art'];
      $ed_check_p = ($_POST['einaus'] > 0 ? "selected " : "");
      $ed_check_m = ($_POST['einaus'] < 0 ? "selected " : "");
    }else {
    IF ($_POST['art'] == 1) {$bmonat = $_POST['anzahl'] * $_POST['betrag'] * 30;}
            else if ($_POST['art'] == 2) {$bmonat = $_POST['anzahl'] * $_POST['betrag'];}
            else if ($_POST['art'] == 3) {$bmonat = $_POST['anzahl'] * $_POST['betrag'] / 3;}
            else if ($_POST['art'] == 4) {$bmonat = $_POST['anzahl'] * $_POST['betrag'] / 6;}
            else if ($_POST['art'] == 5) {$bmonat = $_POST['anzahl'] * $_POST['betrag'] / 12;}
      dbquery("UPDATE ".DB_CCP_BUDGET." SET
        anzahl = '".stripinput($_POST['anzahl'])."',
        betrag = '".stripinput($_POST['betrag'] * $_POST['einaus'])."',
        zweck = '".stripinput($_POST['zweck'])."',
        art = '".stripinput($_POST['art'])."',
        bmonat = '".stripinput($bmonat * $_POST['einaus'])."' WHERE id='$ed_id'");
      echo $gespeichert;
      tablebreak();
     }
}
opentable($locale['ccp000']);
echo"<table width='100%' border='0'>
      <tr>
        <td>";
        require_once "ccp_navigation.php";
        echo"</td></tr><tr><td>";
    opentable($locale['ccp115']);
    echo"<form name='cashadmin' method='post' enctype='multipart/form-data' action='".FUSION_SELF."'>";
     echo"<table align='center' class='tbl-border' width='100%'>";
     echo"<tr>
            <td class='tbl1' align='center' width='30%'>".$locale['ccp116'].":$required</td>
            <td class='tbl1' align='left' width='70%'><input name='anzahl' class='textbox' value='$ed_anzahl' maxlength='6' size='7' style='text-align:center'></td>
          </tr>
          <tr>
            <td class='tbl1' align='center'>".$locale['ccp104'].":$required</td>
            <td class='tbl1' align='left'>
              <select name='einaus' class='textbox' style='text-align:center;'>\n
                 <option value='1' $ed_check_p style='background-color:green;color:black;'>+</option>\n
                 <option value='-1' $ed_check_m style='background-color:red;color:black;'>-</option>\n
              </select>
            <input name='betrag' class='textbox' value='$ed_valuta' maxlength='10' size='11' style='text-align:center'>&nbsp;$set_symbol</td>
          </tr>
          <tr>
            <td class='tbl1' align='center'>".$locale['ccp155'].":$required</td>
            <td class='tbl1' align='center'><input name='zweck' class='textbox' value='$ed_zweck' maxlength='54' size='56' style='width:100%'></td>
          </tr>
          <tr>
            <td class='tbl1' align='center'>".$locale['ccp119'].":$required</td>
            <td class='tbl1' align='left'>
              <select name='art' class='textbox'>\n
                <option".(1 == $ed_art ? " selected" : "")." value='1'>".$locale['ccp120']."</option>\n
                <option".(2 == $ed_art ? " selected" : "")." value='2'>".$locale['ccp121']."</option>\n
                <option".(3 == $ed_art ? " selected" : "")." value='3'>".$locale['ccp122']."</option>\n
                <option".(4 == $ed_art ? " selected" : "")." value='4'>".$locale['ccp123']."</option>\n
                <option".(5 == $ed_art ? " selected" : "")." value='5'>".$locale['ccp124']."</option>\n
              </select>
          <tr>";
            if ($edit != '') 
              echo"<td align='center' class='tbl2' colspan='2'><input type='hidden' name='ed_id' value='$edit'><input type='submit' name='update' class='button' value='".$locale['ccp108']."'></td>";
            else 
              echo"<td align='center' class='tbl2' colspan='2'><input type='submit' name='save' class='button' value='".$locale['ccp110']."'></td>";
          echo"</tr><tr>
            <td class='tbl1' align='center' colspan='2'>".$locale['ccp111']."</td>
            </table></form><br>";
          if (dbrows(dbquery("SELECT * FROM ".DB_CCP_BUDGET)) == 0) echo $keintrag;
          else {
          echo"<table align='center' class='tbl-border' width='100%'>";
            $data = dbarray(dbquery("SELECT SUM(bmonat) AS total FROM ".DB_CCP_BUDGET));
            $total_monat = round($data['total'],2);
            $total_jahr = round($total_monat * 12,2);
          echo"<tr>
            <td class='tbl1' align='right' colspan='4'>".$locale['ccp104'].":&nbsp;&nbsp;</td>
            <td class='tbl1' align='center' width='10%'>$total_monat&nbsp;$set_symbol</td>
            <td class='tbl1' align='center' width='60%'>$total_jahr&nbsp;$set_symbol</td>
            <td class='tbl1' align='right'>&nbsp;</td>
          </tr>
          <tr>
            <td class='$cell_color' align='center' width='5%'>".$locale['ccp116']."</td>
            <td class='$cell_color' align='center' width='10%'>".$locale['ccp104']."</td>
            <td class='$cell_color' align='center' width='60%'>".$locale['ccp155']."</td>
            <td class='$cell_color' align='center' width='20%'>".$locale['ccp119']."</td>
            <td class='$cell_color' align='center' width='10%'>".$locale['ccp125']."</td>
            <td class='$cell_color' align='center' width='10%'>".$locale['ccp126']."</td>
            <td class='$cell_color' align='center' width='30%'>&nbsp;</td>
          </tr>";
          $result = dbquery("SELECT * FROM ".DB_CCP_BUDGET." ORDER BY 2");
          while ($data = dbarray($result)){
          $cell_color = ($i % 2 == 0 ? "tbl1" : "tbl2"); $i++;
          echo"<tr>
            <td class='$cell_color' align='center' width='5%'>".$data['anzahl']."</td>
            <td class='$cell_color' align='center' width='10%'>".$data['betrag']."&nbsp;$set_symbol</td>
            <td class='$cell_color' align='center' width='60%'>".$data['zweck']."</td>
            <td class='$cell_color' align='center' width='20%'>";
            IF ($data['art'] == 1) echo $locale['ccp120'];
            else if ($data['art'] == 2) echo $locale['ccp121'];
            else if ($data['art'] == 3) echo $locale['ccp122'];
            else if ($data['art'] == 4) echo $locale['ccp123'];
            else if ($data['art'] == 5) echo $locale['ccp124'];
            $bjahr = round($data['bmonat'] * 12,2);
            echo"</td>
            <td class='$cell_color' align='center' width='10%'>".round($data['bmonat'],2)."&nbsp;$set_symbol</td>
            <td class='$cell_color' align='center' width='10%'>$bjahr&nbsp;$set_symbol</td>
            <td class='$cell_color' align='center' width='30%'><a href='".FUSION_SELF."?edit=".$data['id']."'>".$locale['ccp113']."</a><br><a href='".FUSION_SELF."?del=".$data['id']."' onclick='return ccp_ask_first(this)'>".$locale['ccp114']."</a></td>
          </tr>";}
      }
    echo"</table>";
    closetable();
closetable();
require_once "ccp_copyright.php";
require_once THEMES."templates/footer.php";
?>
