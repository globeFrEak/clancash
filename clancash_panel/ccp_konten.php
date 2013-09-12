<?php
/*---------------------------------------------------+
| PHP-Fusion 7 Content Management System
+----------------------------------------------------+
| Copyright © 2002 - 2013 Nick Jones
| http://www.php-fusion.co.uk/
|----------------------------------------------------+
| Infusion: ClanCash
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
include_once INFUSIONS."clancash_panel/ccp_functions.php";

$del = (isset($_POST['del'])) ? $_POST['del'] : "";
$edit = (isset($_POST['edit'])) ? $_POST['edit'] : "";
$konto_id = (isset($_POST['konto_id'])) ? $_POST['konto_id'] : "";
$name = (isset($_POST['name'])) ? $_POST['name'] : "";
$zweck = (isset($_POST['zweck'])) ? $_POST['zweck'] : "";
$inhaber = (isset($_POST['inhaber'])) ? $_POST['inhaber'] : "";
$blz = (isset($_POST['blz'])) ? $_POST['blz'] : "";
$iban = (isset($_POST['iban'])) ? $_POST['iban'] : "";
$swift = (isset($_POST['swift'])) ? $_POST['swift'] : "";
$bank = (isset($_POST['bank'])) ? $_POST['bank'] : "";
$ed_konto_id = (isset($_POST['ed_konto_id'])) ? $_POST['ed_konto_id'] : "";
$ed_name = (isset($_POST['ed_name'])) ? $_POST['ed_name'] : "";
$ed_inhaber = (isset($_POST['ed_inhaber'])) ? $_POST['ed_inhaber'] : "";
$ed_id = (isset($_POST['ed_id'])) ? $_POST['ed_id'] : "";
$ed_blz = (isset($_POST['ed_blz'])) ? $_POST['ed_blz'] : "";
$ed_iban = (isset($_POST['ed_iban'])) ? $_POST['ed_iban'] : "";
$ed_swift = (isset($_POST['ed_swift'])) ? $_POST['ed_swift'] : "";
$ed_bank = (isset($_POST['ed_bank'])) ? $_POST['ed_bank'] : "";
$ed_zweck = (isset($_POST['ed_zweck'])) ? $_POST['ed_zweck'] : "";

if (!checkgroup($set_admin_id)) redirect("../../login.php");

if ((isset($_GET['del'])) != ''){
  $del = $_GET['del'];
  if (dbrows(dbquery("SELECT * FROM ".DB_CCP_BUCHUNGEN." WHERE konto_id='$del'")) == 0)
  {dbquery("DELETE FROM ".DB_CCP_KONTEN." WHERE ID='$del'");
  echo $geloescht;}
  else{ echo $ngeloescht;}
  tablebreak();
}


if ((isset($_GET['edit'])) != ''){
  $edit = $_GET['edit'];
  $update = dbarray(dbquery("SELECT * FROM ".DB_CCP_KONTEN." WHERE id='$edit'"));
  $ed_konto_id = $update['konto_id'];
  $ed_name = $update['name'];
  $ed_inhaber = $update['inhaber'];
  $ed_blz = $update['blz'];
  $ed_iban = $update['iban'];
  $ed_swift = $update['swift'];
  $ed_bank = $update['bank'];
  $ed_zweck = $update['zweck'];
}

if (isset($_POST['save'])) {     
    if ($_POST['konto_id'] == '' || $_POST['name'] == '' || $_POST['inhaber'] == '' || $_POST['blz'] == '' || $_POST['zweck'] == ''){ 
    echo $ngespeichert ;}
    else {
     dbquery("INSERT ".DB_CCP_KONTEN." SET
      konto_id = '".stripinput($_POST['konto_id'])."',
      name = '".stripinput($_POST['name'])."',
      inhaber = '".stripinput($_POST['inhaber'])."',
      blz = '".stripinput($_POST['blz'])."',
      iban = '".stripinput($_POST['iban'])."',
      swift = '".stripinput($_POST['swift'])."',
      bank = '".stripinput($_POST['bank'])."',
      zweck = '".stripinput($_POST['zweck'])."'");
      echo $gespeichert;
      tablebreak();
     }    
}

if (isset($_POST['update'])) {
    if ($_POST['konto_id'] == '' || $_POST['name'] == '' || $_POST['inhaber'] == '' || $_POST['blz'] == '' || $_POST['zweck'] == ''){ 
    echo $ngespeichert;tablebreak();}
    else {
dbquery("UPDATE ".DB_CCP_KONTEN." SET
      konto_id = '".stripinput($_POST['konto_id'])."',
      name = '".stripinput($_POST['name'])."',
      inhaber = '".stripinput($_POST['inhaber'])."',
      blz = '".stripinput($_POST['blz'])."',
      iban = '".stripinput($_POST['iban'])."',
      swift = '".stripinput($_POST['swift'])."',
      bank = '".stripinput($_POST['bank'])."',
      zweck = '".stripinput($_POST['zweck'])."' WHERE id='$ed_id'");
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
    opentable($locale['ccp135']);
    echo"<form name='chasadmin' method='post' enctype='multipart/form-data' action='".FUSION_SELF."'>";
     echo"<table align='center' class='tbl-border' width='100%'>";
     echo"<tr>
            <td class='tbl1' align='center' width='30%'>".$locale['ccp136'].":$required</td>
            <td class='tbl1' align='center' width='70%'><input name='name' class='textbox' value='$ed_name' maxlength='15' size='16' style='width:100%'></td>
          </tr>
          <tr>
            <td class='tbl1' align='center'>".$locale['ccp137'].":$required</td>
            <td class='tbl1' align='center'><input name='inhaber' class='textbox' value='$ed_inhaber' maxlength='40' size='41' style='width:100%'></td>
          </tr>
          <tr>
            <td class='tbl1' align='center'>".$locale['ccp138'].":$required</td>
            <td class='tbl1' align='center'><input name='konto_id' class='textbox' value='$ed_konto_id' maxlength='15' size='16' style='width:100%'></td>
          </tr>
          <tr>
            <td class='tbl1' align='center'>".$locale['ccp139'].":$required</td>
            <td class='tbl1' align='center'><input name='blz' class='textbox' value='$ed_blz' maxlength='10' size='11' style='width:100%'></td>
          </tr>
          <tr>
            <td class='tbl1' align='center'>".$locale['ccp140'].":</td>
            <td class='tbl1' align='center'><input name='bank' class='textbox' value='$ed_bank' maxlength='40' size='41' style='width:100%'></td>
          </tr>
          <tr>
            <td class='tbl1' align='center'>".$locale['ccp156'].":$required</td>
            <td class='tbl1' align='center'><input name='zweck' class='textbox' value='$ed_zweck' maxlength='54' size='55' style='width:100%'></td>
          </tr>
          <tr>
            <td class='tbl1' align='center'>".$locale['ccp141'].":</td>
            <td class='tbl1' align='center'><input name='iban' class='textbox' value='$ed_iban' maxlength='34' size='35' style='width:100%'></td>
          </tr>
          <tr>
            <td class='tbl1' align='center'>".$locale['ccp142'].":</td>
            <td class='tbl1' align='center'><input name='swift' class='textbox' value='$ed_swift' maxlength='11' size='12' style='width:100%'></td>
          </tr><tr>";
            if ($edit != "") 
              echo"<td align='center' class='tbl2' colspan='2'><input type='hidden' name='ed_id' value='$edit'><input type='submit' name='update' class='button' value='".$locale['ccp108']."'></td>";
            else 
              echo"<td align='center' class='tbl2' colspan='2'><input type='submit' name='save' class='button' value='".$locale['ccp110']."'></td>";
          echo"</tr><tr>
          <td class='tbl1' align='center' colspan='2'>".$locale['ccp111']."</td>
          </table></form><br>";    
     if (dbrows(dbquery("SELECT * FROM ".DB_CCP_KONTEN)) == 0) echo $keintrag;
     else {
     echo"<table align='center' class='tbl-border' width='100%'>";
     $result = dbquery("SELECT * FROM ".DB_CCP_KONTEN." ORDER BY name");
     while ($data = dbarray($result)){
     $cell_color = ($i % 2 == 0 ? "tbl1" : "tbl2"); $i++;
     echo"<tr>
            <td class='$cell_color' align='center' width='70%'>".$data['name']."</td>
            <td class='$cell_color' align='center' width='30%'><a href='".FUSION_SELF."?edit=".$data['id']."'>".$locale['ccp113']."</a>";
            if (dbrows(dbquery("SELECT * FROM ".DB_CCP_BUCHUNGEN." WHERE konto_id='".$data['id']."'")) == 0){
            echo " -- <a href='".FUSION_SELF."?del=".$data['id']."' onclick='return ccp_ask_first(this)'>".$locale['ccp114']."</a>";}
            else{
            echo " -- <span style='text-decoration:line-through;'>".$locale['ccp114']."</span>";}
            echo"</td></tr>";
      }
    echo"</table>";}
    closetable();

echo "</td></tr></table>";
closetable();
require_once "ccp_copyright.php";
require_once THEMES."templates/footer.php";
?>
