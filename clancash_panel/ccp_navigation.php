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
if (!defined("IN_FUSION") || !IN_FUSION) die("Access denied!");

echo"<h4 class='ccp_navi'>\n
	 <span><img src='" . INFUSIONS . "clancash_panel/images/overview.png' alt='".$locale['ccp143']."'><a class='navi' href='ccp_clancash.php'>".$locale['ccp165']."</a></span>\n
     <span><img src='" . INFUSIONS . "clancash_panel/images/admin_panel.png' alt='".$locale['ccp143']."'><a class='navi' href='ccp_admin_panel.php".$aidlink."'>".$locale['ccp143']."</a></span>\n
     <span><img src='" . INFUSIONS . "clancash_panel/images/cats.png' alt='".$locale['ccp127']."'><a class='navi' href='ccp_cats.php'>".$locale['ccp127']."</a></span>\n
     <span><img src='" . INFUSIONS . "clancash_panel/images/konto.png' alt='".$locale['ccp135']."'><a class='navi' href='ccp_konten.php'>".$locale['ccp135']."</a></span>\n
     <span><img src='" . INFUSIONS . "clancash_panel/images/budget.png' alt='".$locale['ccp144']."'><a class='navi' href='ccp_budget.php'>".$locale['ccp144']."</a></span>\n";
if (checkrights('CCP'))
    echo"<span><img src='" . INFUSIONS . "clancash_panel/images/settings.png' alt='".$locale['ccp145']."'><a class='navi' href='ccp_settings_panel.php".$aidlink."'>".$locale['ccp145']."</a></span>\n";
echo"</h4>";

?>
