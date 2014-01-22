<?php
/*--------------------------------------------------------------+
 | PHP-Fusion 7 Content Management System             			|
 +--------------------------------------------------------------+
 | Copyright © 2002 - 2013 Nick Jones                 			|
 | http://www.php-fusion.co.uk/                       			|
 +--------------------------------------------------------------+
 | Infusion: ClanCash                                 			|
 | Filename: ccp_admin_panel.php                      			|
 | Author:                                            			|
 | RedDragon(v6) 	    http://www.efc-funclan.de      			|
 | globeFrEak (v7) 		http://www.cwclan.de           			|
 | GUL-Sonic (v7.02)	http://www.germanys-united-legends.de 	|
 +--------------------------------------------------------------+
 | This program is released as free software under the			|
 | Affero GPL license. You can redistribute it and/or			|
 | modify it under the terms of this license which you			|
 | can read by viewing the included agpl.txt or online			|
 | at www.gnu.org/licenses/agpl.html. Removal of this			|
 | copyright header is strictly prohibited without				|
 | written permission from the original author(s).				|
 +--------------------------------------------------------------*/
require_once "../../maincore.php";
require_once THEMES . "templates/header.php";
include INFUSIONS . "clancash_panel/infusion_db.php";

$del = (isset($_POST['del'])) ? $_POST['del'] : "";
$filter = (isset($_POST['filter'])) ? $_POST['filter'] : "";
$edit = (isset($_POST['edit'])) ? $_POST['edit'] : "";
$ed_kat_klartext = (isset($_POST['ed_kat_klartext'])) ? $_POST['ed_kat_klartext'] : "";

if (file_exists(INFUSIONS . "clancash_panel/locale/" . $settings['locale'] . ".php")) {
    include INFUSIONS . "clancash_panel/locale/" . $settings['locale'] . ".php";
} else {
    include INFUSIONS . "clancash_panel/locale/English.php";
}
include_once INFUSIONS . "clancash_panel/ccp_functions.php";
if (!checkgroup($set_admin_id))
    redirect("../../login.php");

if ((isset($_GET['del'])) != '') {
    $del = $_GET['del'];
    if (dbrows(dbquery("SELECT * FROM " . DB_CCP_BUCHUNGEN . " WHERE kat_id='$del'")) == 0) {
        dbquery("DELETE FROM " . DB_CCP_KATEGORIEN . " WHERE ID='$del'");
        echo $geloescht;
    } else {
        echo $ngeloescht;
    }   
}

if ((isset($_GET['edit'])) != '') {
    $edit = $_GET['edit'];
    $update = dbarray(dbquery("SELECT * FROM " . DB_CCP_KATEGORIEN . " WHERE id='$edit'"));
    $ed_kat_klartext = $update['kat_klartext'];
    $ed_id = $update['id'];
}

if (isset($_POST['save'])) {
    $rows = dbrows(dbquery("SELECT * FROM " . DB_CCP_KATEGORIEN . " WHERE kat_klartext='" . $_POST['kategorie'] . "'"));
    if ($_POST['kategorie'] == '') {
        echo $ngespeichert;      
    } else if ($rows > 0)
        echo $doppelt;
    else {
        dbquery("INSERT " . DB_CCP_KATEGORIEN . " SET
      kat_klartext = '" . stripinput($_POST['kategorie']) . "'");
        echo $gespeichert;        
    }
}

if (isset($_POST['update'])) {
    if ($_POST['kategorie'] == '') {
        echo $ngespeichert;        
    } else {
        dbquery("UPDATE " . DB_CCP_KATEGORIEN . " SET
      kat_klartext = '" . stripinput($_POST['kategorie']) . "'WHERE id='$ed_id'");
        echo $gespeichert;       
    }
}

opentable($locale['ccp_a000']);
require_once "ccp_navigation.php";
closetable();

opentable($locale['ccp127']);
echo"<form name='cashadmin' method='post' enctype='multipart/form-data' action=''>";
echo"<table align='center' class='tbl-border' width='100%'>";
echo"<tr>
           <td class='tbl1' align='center' width='30%'>" . $locale['ccp102'] . ":$required</td>
           <td class='tbl1' align='center' width='70%'><input name='kategorie' class='textbox' value='$ed_kat_klartext' maxlength='40' style='width:100%'></td>
         <tr>";
if ($edit != '')
    echo"<td colspan='2' align='center' class='tbl2'><input type='hidden' name='ed_id' value='$edit'><input type='submit' name='update' class='button' value='" . $locale['ccp108'] . "'></td>";
else
    echo"<td colspan='2' align='center' class='tbl2'><input type='submit' name='save' class='button' value='" . $locale['ccp110'] . "'></td>";
echo"</tr><tr>
          <td class='tbl1' align='center' colspan='2'>" . $locale['ccp111'] . "</td>
          </table></form><br>";

    $result = dbquery("SELECT * FROM " . DB_CCP_KATEGORIEN . " ORDER BY 2");
if (dbrows($result) > 0) {
    echo "<table align='center' class='tbl-border' width='100%'>";    
    while ($data = dbarray($result)) {
        $cell_color = ($i % 2 == 0 ? "tbl1" : "tbl2");
        $i++;
        echo"<tr>
            <td class='$cell_color' align='center' width='70%'>" . $data['kat_klartext'] . "</td>
            <td class='$cell_color' align='center' width='30%'><a href='" . FUSION_SELF . "?edit=" . $data['id'] . "'>" . $locale['ccp113'] . "</a>";
        if (dbrows(dbquery("SELECT * FROM " . DB_CCP_BUCHUNGEN . " WHERE kat_id='" . $data['id'] . "'")) == 0) {
            echo " -- <a href='" . FUSION_SELF . "?del=" . $data['id'] . "' onclick='return ccp_ask_first(this)'>" . $locale['ccp114'] . "</a>";
        } else {
            echo " -- <span style='text-decoration:line-through;'>" . $locale['ccp114'] . "</span>";
        }
        echo"</td></tr>
          ";
    }
    echo"</table>";
} else {
    echo $keintrag;
}
closetable();

require_once "ccp_copyright.php";
require_once THEMES . "templates/footer.php";
?>
