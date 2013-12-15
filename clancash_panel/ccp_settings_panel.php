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
 | Sonic (v7.02)		http://www.germanys-united-legends.de 	|
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
require_once THEMES . "templates/admin_header.php";
include INFUSIONS . "clancash_panel/infusion_db.php";

if (file_exists(INFUSIONS . "clancash_panel/locale/" . $settings['locale'] . ".php")) {
    include INFUSIONS . "clancash_panel/locale/" . $settings['locale'] . ".php";
} else {
    include INFUSIONS . "clancash_panel/locale/English.php";
}

include_once INFUSIONS . "clancash_panel/ccp_functions.php";

add_to_footer("<script type='text/javascript'>    
    if( $('#set_1').attr('checked')){ 
        $('.placeholder_set_1').hide();} 
    else { 
        $('.placeholder_set_1').show();}
    $(':checkbox').change(function(e) {
        if($(this).is(':checked')){
            $('.placeholder_'+e.target.id).fadeOut('slow');            
        }else{           
            $('.placeholder_'+e.target.id).fadeIn('slow');
        }
    });</script>");

if (!checkrights("CCP") || !defined("iAUTH") || !isset($_GET['aid']) || $_GET['aid'] != iAUTH)
    redirect("../../login.php");

if (isset($_POST['save'])) {
    (dbrows(dbquery("SELECT * FROM " . DB_CCP_SETTINGS . "")) == 1 ? $action = "UPDATE" : $action = "INSERT");
    $result = dbquery("$action " . DB_CCP_SETTINGS . " SET
		cashadmin_groupid='" . stripinput($_POST['cashadmin_id']) . "',
                member_groupid='" . stripinput($_POST['member_id']) . "',
                zeilen='" . stripinput($_POST['zeilen']) . "',
                waehrung='" . stripinput($_POST['waehrung']) . "',
                member_show_all='" . stripinput((isset($_POST['member_show_all']) ? 1 : 0)) . "',
                member_show_names='" . stripinput((isset($_POST['member_show_names']) ? 1 : 0)) . "',    
                placeholder_name='" . stripinput($_POST['placeholder_name']) . "',
                paypal='" . stripinput((isset($_POST['paypal']) ? 1 : 0)) . "',
                standard_konto='" . stripinput($_POST['standard_konto']) . "'"
    );
    echo $gespeichert;
    echo "<br>";
}

opentable($locale['ccp_a000']);
include "ccp_navigation.php";
closetable();

opentable($locale['ccp145']);
echo"
<form name='cashadmin' method='post' enctype='multipart/form-data' action='" . FUSION_SELF . $aidlink . "'>
<table align='center' width='50%' class='tbl-border'>
   <tr>
    <td class='tbl1' align='center' width='50%'>" . $locale['ccp147'] . "</td>
    <td class='tbl1' align='center' width='50%'>
    <select name='cashadmin_id' class='textbox' style='width:150px'><option value='' style='text-align:center'>" . $locale['ccp103'] . "</option>\n";
$user_groups = getusergroups();
$access_opts = "";
while (list($key, $user_group) = each($user_groups)) {
    echo "<option style='text-align:center' value='" . $user_group['0'] . "'";
    if ($set_admin_id == $user_group['0'])
        echo " selected";
    echo ">" . $user_group['1'] . "</option>\n";
}

echo"</select></td>
  </tr>
  <tr>
    <td class='tbl1' align='center' width='50%'>" . $locale['ccp148'] . "</td>
    <td class='tbl1' align='center' width='50%'>
    <select name='member_id' class='textbox' style='width:150px'><option value='' style='text-align:center'>" . $locale['ccp103'] . "</option>\n";
$user_groups = getusergroups();
$access_opts = "";
while (list($key, $user_group) = each($user_groups)) {
    echo "<option style='text-align:center' value='" . $user_group['0'] . "'";
    if ($set_member_id == $user_group['0'])
        echo " selected";
    echo ">" . $user_group['1'] . "</option>\n";
}
echo"</select></td>
  </tr>";
$data = dbarray(dbquery("SELECT *  FROM " . DB_CCP_SETTINGS . ""));
echo"
  <tr>
  <td class='tbl1' align='center' width='50%'>" . $locale['ccp149'] . "</td>
    <td class='tbl1' align='center' width='50%'>
      <select name='zeilen' class='textbox'>
        <option" . ($data['zeilen'] == 5 ? " selected" : "") . " value='5' style='text-align:center'>5</option>
        <option" . ($data['zeilen'] == 10 ? " selected" : "") . " value='10' style='text-align:center'>10</option>
        <option" . ($data['zeilen'] == 15 ? " selected" : "") . " value='15' style='text-align:center'>15</option>
        <option" . ($data['zeilen'] == 20 ? " selected" : "") . " value='20' style='text-align:center'>20</option>
        <option" . ($data['zeilen'] == 25 ? " selected" : "") . " value='25' style='text-align:center'>25</option>
        <option" . ($data['zeilen'] == 30 ? " selected" : "") . " value='30' style='text-align:center'>30</option>
        <option" . ($data['zeilen'] == 35 ? " selected" : "") . " value='35' style='text-align:center'>35</option>
        <option" . ($data['zeilen'] == 40 ? " selected" : "") . " value='40' style='text-align:center'>40</option>
        <option" . ($data['zeilen'] == 45 ? " selected" : "") . " value='45' style='text-align:center'>45</option>
        <option" . ($data['zeilen'] == 50 ? " selected" : "") . " value='50' style='text-align:center'>50</option>
      </select>
  </tr>
  <tr>
  <td class='tbl1' align='center' width='50%'>" . $locale['ccp150'] . "</td>
    <td class='tbl1' align='center' width='50%'>";
echo"<input name='waehrung' class='textbox' style='width:40px; text-align:center' value='" . $data['waehrung'] . "'>          
    </td>
  </tr>
  <tr>
  <td class='tbl1' align='center' width='50%'>" . $locale['ccp250'] . "</td>
    <td class='tbl1' align='center' width='50%'>";
$result = dbquery("SELECT * FROM " . DB_CCP_KONTEN . " ORDER BY name");
if (dbrows($result) > 0) {
    echo"<select name='standard_konto' class='textbox'>";
    while ($data2 = dbarray($result)) {
        echo "<option" . ($data['standard_konto'] == $data2['id'] ? " selected" : "") . " value='" . $data2['id'] . "'>" . $data2['name'] . "</option>\n";
    }
    echo"</select>";
} else {
    echo $locale['ccp251'];
}
echo"</td>
  </tr>
  <td class='tbl1' align='center' width='50%'>" . $locale['ccp182'] . "</td>
    <td class='tbl1' align='center' width='50%'>";
echo"<input type='checkbox' " . (($data['paypal'] == 1) ? "checked='checked'" : "") . " name='paypal' value='1' style='width:10px; text-align:center'>
    </td>
  </tr>
  <tr>
  <td class='tbl1' align='center' width='50%'>" . $locale['ccp159'] . "</td>
    <td class='tbl1' align='center' width='50%'>";
echo"<input type='checkbox' " . (($data['member_show_all'] == 1) ? "checked='checked'" : "") . " name='member_show_all' value='1' style='width:10px; text-align:center'>
    </td>
  </tr>
  <tr>
  <td class='tbl1' align='center' width='50%'>" . $locale['ccp180'] . "</td>
    <td class='tbl1' align='center' width='50%'>";
echo"<input id='set_1' type='checkbox' " . (($data['member_show_names'] == 1) ? "checked='checked'" : "") . " name='member_show_names' value='1' style='width:10px; text-align:center'>
    </td>
  </tr>
  <tr>
  <td class='tbl1 placeholder_set_1' align='center' width='50%'>" . $locale['ccp181'] . "</td>
    <td class='tbl1 placeholder_set_1' align='center' width='50%'>";
echo"<input name='placeholder_name' class='textbox' style='width:150px; text-align:center' value='" . $data['placeholder_name'] . "'>
    </td>
  </tr>
  <tr>
  <td class='tbl2' align='center' width='100%' colspan='2'><input class='button' type='submit' name='save' style='width:150' value='" . $locale['ccp108'] . "'></td>
  </tr></table></form>";

closetable();

//// Testsequenz für Versionsüberprüfung ////
$ccp_config = dbarray(dbquery("SELECT * FROM " . DB_CCP_SETTINGS));
opentable($locale['ccp300']);

$ausgabe = '';
    if(function_exists('fsockopen'))
    { 
      $version_new = latest_ccp_version();
      if(version_compare($version_new, $ccp_config['version'], '<=') AND $version_new > 0)
      {
	  $ausgabe = "
	  <table cellpadding='0' cellspacing='1'>
	  <tr>
	  <td><img src='".INFUSIONS."clancash_panel/images/version.gif' alt='up to date' /></td>
	  <td><span style=\"font-weight: bold; color: #1bdc16;\">".$locale['ccp303'].": ".$ccp_config['version']."</span></td>
	  </tr>
	  </table>";
      } else {
        if (!empty($version_new))
        {
	$ausgabe = "
	<table cellpadding='0' cellspacing='1'>
	<tr>
	<td><img src='".INFUSIONS."clancash_panel/images/version_old.gif' alt='old version' /></td>
	<td><span style='font-weight: bold; color: red;'>".$locale['ccp302'].": ".$ccp_config['version']."</span><br />
	<span style='font-weight: bold; color: #1bdc16;'>".$locale['ccp301'].": ".$version_new."</span><br />
	<span style='font-weight: bold;'>".$locale['ccp304'].": </span><a href='http://germanys-united-legends.de/downloads.php' target='_blank' title='Germanys United Legends'><span style='font-weight: bold;'>http://germanys-united-legends.de</span></a></td>
	</tr>
	</table>";
       }
      }
    } 
	if (empty($version_new)) {
	$ausgabe = "<br /><span style='font-weight: bold; color: red;'>".$locale['ccp305']."!<br /></span><span style='font-weight: bold;'>".$locale['ccp304']."</span> <a href='http://germanys-united-legends.de/downloads.php' target='_blank' title='Germanys United Legends'><span style='font-weight: bold;'>http://germanys-united-legends.de</span></a><br /><br />";
    }

echo "<div align='center'>".$ausgabe."</div>";

//// Testsequenz für Datenbankupdate ////
require_once INFUSIONS."clancash_panel/update/ccp_update.php";
//// Testsequenz für Datenbankupdate Ende////
closetable();
require_once "ccp_copyright.php";
require_once THEMES . "templates/footer.php";
?>
