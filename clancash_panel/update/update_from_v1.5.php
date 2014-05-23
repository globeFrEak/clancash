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

require_once "../../../maincore.php";

// Check: iAUTH and $aid
if (!defined("iAUTH") || $_GET['aid'] != iAUTH) redirect("index.php");

// Includes
require_once INFUSIONS."clancash_panel/infusion_db.php";
//require_once INFUSIONS."clancash_panel/includes/ccp_functions.php";

// Check: Admin Rights
if (!iADMIN) redirect("index.php");

// Header
	require_once THEMES."templates/header.php";


// Language Files
if (file_exists(INFUSIONS."clancash_panel/locale/".$settings['locale'].".php")) {
	include INFUSIONS."clancash_panel/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."clancash_panel/locale/English.php";
}

// MySQL database functions
function dbquery_ccp_update($query) {
	$result = @mysql_query($query);
	if (!$result) {
		//echo mysql_error();
		return false;
	} else {
		return $result;
	}
}

opentable($locale['ccp306'].": v1.5 => v1.6");

$mysql[] = "UPDATE ".DB_CCP_SETTINGS." SET version='1.6'";
$mysql[] = "ALTER TABLE ".DB_CCP_SETTINGS." ADD superadmin_pn BOOL NOT NULL";
$mysql[] = "UPDATE ".DB_CCP_SETTINGS." SET superadmin_pn='1'";

$mysql[] = "UPDATE ".DB_INFUSIONS." SET inf_version='1.6' WHERE inf_folder='clancash_panel'";

$errors = 0;
foreach($mysql as $query) {

		if(dbquery_ccp_update($query)) {
			$res = "<b>".$locale['ccp307']."</b>";
		} else {
			$errors++;
			$res = "<b>".$locale['ccp308'].":</b>&nbsp;";
			$res .= mysql_error();
		}

	echo "<br /><code>".htmlentities($query)."</code>";

	echo "<br />".$res."<br />";

}

if($errors) {
	echo "<p><font color='red'><b>".$locale['ccp309'].": ".$errors."</b></font></p>";
} else {
	echo "<p><p>&nbsp;</p>";
	echo "<p align='center'><font color='green'><b>".$locale['ccp310']."</b></font></p>";
	echo "<p><p>&nbsp;</p>";
}
echo "<br /><a href='".INFUSIONS."clancash_panel/ccp_settings_panel.php".$aidlink."'>".$locale['ccp311']."</a><br /><br />";

closetable();

// Footer
	require_once THEMES."templates/footer.php";
?>

