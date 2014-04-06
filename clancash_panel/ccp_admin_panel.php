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
require_once "../../maincore.php";
require_once THEMES . "templates/header.php";
include INFUSIONS . "clancash_panel/infusion_db.php";

if (file_exists(INFUSIONS . "clancash_panel/locale/" . $settings['locale'] . ".php")) {
    include INFUSIONS . "clancash_panel/locale/" . $settings['locale'] . ".php";
} else {
    include INFUSIONS . "clancash_panel/locale/English.php";
}

add_to_head("<link rel='stylesheet' href='" . INFUSIONS . "clancash_panel/css/clancash.css' type='text/css'/>\n");

include_once INFUSIONS . "clancash_panel/ccp_functions.php";

$edit = (isset($_POST['edit'])) ? $_POST['edit'] : "";
$id = (isset($_POST['id'])) ? $_POST['id'] : "";
$ed_check_m = (isset($_POST['ed_check_m'])) ? $_POST['ed_check_m'] : "";
$ed_check_p = (isset($_POST['ed_check_p'])) ? $_POST['ed_check_p'] : "";
$ed_kat_id = (isset($_POST['ed_kat_id'])) ? $_POST['ed_kat_id'] : "";
$ed_konto_id = (isset($_POST['ed_konto_id'])) ? $_POST['ed_konto_id'] : "";


if (!checkgroup($set_member_id) && !checkgroup($set_admin_id))
    redirect("../../login.php");

if ((isset($_GET['edit'])) != '') {
    $edit = mysql_real_escape_string($_GET['edit']);
    $update = dbarray(dbquery("SELECT * FROM " . DB_CCP_BUCHUNGEN . " WHERE id='$edit'"));
    $ed_valuta = ($update['valuta'] < 0 ? $update['valuta'] * -1 : $update['valuta']);
    $ed_comment = $update['comment'];
    $ed_tag = $update['tag'];
    $ed_monat = $update['monat'];
    $ed_jahr = $update['jahr'];
    $ed_kat_id = $update['kat_id'];
    $ed_user_id = $update['user_id'];
    $ed_konto_id = $update['konto_id'];
    $ed_check_p = ($update['valuta'] > 0 ? "selected" : "");
    $ed_check_m = ($update['valuta'] < 0 ? "selected" : "");
}

if ((isset($_GET['del'])) != '') {
    $del = mysql_real_escape_string($_GET['del']);
    dbquery("UPDATE " . DB_CCP_BUCHUNGEN . " SET
  geloescht = '1' WHERE id='$del'");
}

if ((isset($_GET['delret'])) != '') {
    $delret = mysql_real_escape_string($_GET['delret']);
    dbquery("UPDATE " . DB_CCP_BUCHUNGEN . " SET
  geloescht = '0' WHERE id='$delret'");
}

if ((isset($_GET['delcom'])) != '') {
    $delcom = mysql_real_escape_string($_GET['delcom']);
    dbquery("DELETE FROM " . DB_CCP_BUCHUNGEN . " WHERE id='$delcom' AND geloescht=1");
}

if (isset($_POST['save'])) {

    if ($_POST['kategorie'] == '' || $_POST['betrag'] == '00.00' || $_POST['betrag'] == '' || $_POST['tag'] == '' || $_POST['monat'] == '' || $_POST['jahr'] == '' || $_POST['konto_id'] == '') {
        $ed_valuta = $_POST['betrag'];
        $ed_comment = $_POST['comment'];
        $ed_tag = $_POST['tag'];
        $ed_monat = $_POST['monat'];
        $ed_jahr = $_POST['jahr'];
        $ed_kat_id = $_POST['kategorie'];
        $ed_user_id = $_POST['user_id'];
        $ed_konto_id = $_POST['konto_id'];
        $ed_check_p = ($_POST['einaus'] > 0 ? "selected" : "");
        $ed_check_m = ($_POST['einaus'] < 0 ? "selected" : "");
        $edit = $_POST['id'];
        echo $ngespeichert;
    } else {
        $betrag = str_replace(',', '.', $_POST['betrag']);
        dbquery("INSERT " . DB_CCP_BUCHUNGEN . " SET
      user_id = '" . stripinput($_POST['user_id']) . "',
      konto_id = '" . stripinput($_POST['konto_id']) . "',
      valuta = '" . stripinput($betrag) * stripinput($_POST['einaus']) . "',
      kat_id = '" . stripinput($_POST['kategorie']) . "',
      tag = '" . stripinput($_POST['tag']) . "',
      monat = '" . stripinput($_POST['monat']) . "',
      jahr = '" . stripinput($_POST['jahr']) . "',
      comment = '" . stripinput($_POST['comment']) . "'");
        echo $gespeichert;
    }
}

if (isset($_POST['update'])) {
    if ($_POST['kategorie'] == '' || $_POST['betrag'] == '00.00' || $_POST['betrag'] == '' || $_POST['tag'] == '' || $_POST['monat'] == '' || $_POST['jahr'] == '' || $_POST['konto_id'] == '') {
        $ed_valuta = $_POST['betrag'];
        $ed_comment = $_POST['comment'];
        $ed_tag = $_POST['tag'];
        $ed_monat = $_POST['monat'];
        $ed_jahr = $_POST['jahr'];
        $ed_kat_id = $_POST['kategorie'];
        $ed_user_id = $_POST['user_id'];
        $ed_konto_id = $_POST['konto_id'];
        $ed_check_p = ($_POST['einaus'] > 0 ? "selected" : "");
        $ed_check_m = ($_POST['einaus'] < 0 ? "selected" : "");
        $edit = $_POST['id'];
        echo $ngespeichert;
    } else {
        $betrag = str_replace(',', '.', $_POST['betrag']);
        dbquery("UPDATE " . DB_CCP_BUCHUNGEN . " SET
      user_id = '" . stripinput($_POST['user_id']) . "',
      konto_id = '" . stripinput($_POST['konto_id']) . "',
      valuta = '" . stripinput($betrag) * stripinput($_POST['einaus']) . "',
      kat_id = '" . stripinput($_POST['kategorie']) . "',
      tag = '" . stripinput($_POST['tag']) . "',
      monat = '" . stripinput($_POST['monat']) . "',
      jahr = '" . stripinput($_POST['jahr']) . "',
      comment = '" . stripinput($_POST['comment']) . "' WHERE id='$id'");
        echo $gespeichert;
    }
}
opentable($locale['ccp_a000']);
require_once "ccp_navigation.php";
closetable();

opentable($locale['ccp100']);

echo"<form name='chasadmin' method='post' enctype='multipart/form-data' action='" . FUSION_SELF . "'>
      <table class='tbl-border' width='100%'>
      <tr>
        <td class='tbl1' style='text-align: center; width:30%;'>" . $locale['ccp101'] . ":$required</td>
        <td class='tbl1' style='width:70%'>
          <select name='tag' class='textbox'>\n";
$tag = 1;
while ($tag < 32) {
    echo"<option" . ($tag == $ed_tag ? " selected" : "") . " value='$tag'>$tag</option>\n";
    $tag = $tag + 1;
}
echo" </select>
          <select name='monat' class='textbox'>\n";
$monat = 1;
while ($monat < 13) {
    echo"<option" . ($monat == $ed_monat ? " selected" : "") . " value='$monat'>$monat</option>\n";
    $monat = $monat + 1;
}
echo"</select>
          <select name='jahr' class='textbox'>\n";
$jahr = $ed_jahr;
$jahrverg = $ed_jahr - 11;
while ($jahr > $jahrverg) {
    echo"<option" . ($jahr == $ed_jahr ? " selected" : "") . " value='$jahr'>$jahr</option>\n";
    $jahr = $jahr - 1;
}
echo"</select>";
echo"</td>
      </tr>
      <tr>
        <td class='tbl1' style='text-align: center; width:30%;'>" . $locale['ccp102'] . ":$required</td>
        <td class='tbl1' style='width:70%' >
          <select name='kategorie' class='textbox' style='width:95%;'>\n
          <option value=''>" . $locale['ccp103'] . "</option>\n";
$result = dbquery("SELECT * FROM " . DB_CCP_KATEGORIEN . " ORDER BY kat_klartext asc");
while ($data = dbarray($result)) {
    echo "<option" . ($data['id'] == $ed_kat_id ? " selected" : "") . " value='" . $data['id'] . "'>" . $data['kat_klartext'] . "</option>\n";
}
echo" </select></td>
      </tr>
      <tr>
        <td class='tbl1' style='text-align:center; width:30%;'>" . $locale['ccp104'] . ":$required</td>
        <td class='tbl1' style='width:30%'>\n
          <select name='einaus' class='textbox' style='text-align:center;'>\n
                 <option value='1' $ed_check_p style='background-color:green;color:black;'>+</option>\n
                 <option value='-1' $ed_check_m style='background-color:red;color:black;'>-</option>\n
          </select>
        <input type='text' name='betrag' class='textbox' value='$ed_valuta' size='8' style='text-align:center; maxlength:9;'>&nbsp;$set_symbol</td>  
        <!--<td class='tbl1' style='width:40%' align='left'><input name='einaus' value='1' type='radio' $ed_check_p>" . $locale['ccp117'] . "<br><input name='einaus' value='-1' type='radio' $ed_check_m>" . $locale['ccp118'] . "</td>-->  
      </tr>
      <tr>
        <td class='tbl1' style='text-align: center;width:30%;'>" . $locale['ccp155'] . "</td>
        <td class='tbl1' style='width:70%' ><input type='text' name='comment' class='textbox' value='$ed_comment' style='width:95%; maxlenght:40;'></td>
      </tr>
      <tr>
        <td  class='tbl1' style='text-align: center; width:30%;'>" . $locale['ccp106'] . ":$required</td>
        <td  class='tbl1' style='width:70%'>";
$result = dbquery("SELECT * FROM " . DB_CCP_KONTEN . " ORDER BY name");
if (dbrows($result) > 0) {
    echo "<select name='konto_id' class='textbox' style='width:145;'>\n
        <option value=''>----</option>\n";
    while ($data = dbarray($result)) {
        echo "<option" . ($data['id'] == $standard_konto ? " selected" : "") . " value='" . $data['id'] . "'>" . $data['name'] . "</option>\n";
    }
    echo "</select>";
} else {
    echo "<a href='" . BASEDIR . "infusions/clancash_panel/ccp_konten.php'>" . $locale['ccp251'] . "</a>";
}
echo"</td>
      </tr>
      <tr>
        <td class='tbl1' style='text-align: center; width:30%;'>" . $locale['ccp107'] . "</td>
        <td class='tbl1' style='width:50%'>
         <select name='user_id' class='textbox' style='width:145; textalign:right;'>\n
         <option value=''>----</option>\n";
if ($set_member_id == 0 || 101 || 102 || 103) {
    if ($set_member_id == 101) {
        $result = dbquery("SELECT user_id, user_name FROM " . DB_USERS . " ORDER BY user_name");
        while ($data = dbarray($result)) {
            echo "<option" . ($data['user_id'] == $ed_user_id ? " selected" : "") . " value='" . $data['user_id'] . "'>" . $data['user_name'] . "</option>\n";
        }
    } elseif ($set_member_id == 102 || 103) {
        $result = dbquery("SELECT user_id, user_name FROM " . DB_USERS . " WHERE user_level = " . $set_member_id . " ORDER BY user_name");
        while ($data = dbarray($result)) {
            echo "<option" . ($data['user_id'] == $ed_user_id ? " selected" : "") . " value='" . $data['user_id'] . "'>" . $data['user_name'] . "</option>\n";
        }
    }
} else {
    $result = dbquery("SELECT user_id, user_name FROM " . DB_USERS . " WHERE user_groups REGEXP('^\\\.{$set_member_id}$|\\\.{$set_member_id}\\\.|\\\.{$set_member_id}$') ORDER BY user_name");
    while ($data = dbarray($result)) {
        echo "<option" . ($data['user_id'] == $ed_user_id ? " selected" : "") . " value='" . $data['user_id'] . "'>" . $data['user_name'] . "</option>\n";
    }
}
echo"</select></td>
      </tr>
      <tr> 
        <td class='tbl2'>&nbsp;</td>\n
        <td class='tbl2' align='center'>";
if ($edit != "")
    echo"<input type='hidden' name='id' value='$edit' /><input style='width:75' type='submit' name='update' class='button' value='" . $locale['ccp108'] . "'>&nbsp;&nbsp;<input style='width:75' type='submit' class='button' value='" . $locale['ccp109'] . "'>";
else
    echo"<input style='width:75' type='submit' name='save' class='button' value='" . $locale['ccp110'] . "'>";
echo"</td>
      </tr>
      <tr>
        <td class='tbl1' align='center' colspan='2'>" . $locale['ccp111'] . "</td>
      </tr></table></form>";

closetable();
include "ccp_filter.php";
include "ccp_buchungen.php";
include "ccp_copyright.php";
require_once THEMES . "templates/footer.php";
?>
