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
if (!defined("IN_FUSION") || !IN_FUSION) die("Access denied!");

add_to_head("<style type='text/css'>
.navi{
    position: relative;
    top: -12px;
    margin: 5px 10px 5px 2px;
}
</style>");

echo"<center>\n<h4>\n
     <img src='" . INFUSIONS . "clancash_panel/images/admin_panel.png' alt='".$locale['ccp143']."'><a class='navi' href='ccp_admin_panel.php".$aidlink."'>".$locale['ccp143']."</a>\n
     <img src='" . INFUSIONS . "clancash_panel/images/cats.png' alt='".$locale['ccp127']."'><a class='navi' href='ccp_cats.php'>".$locale['ccp127']."</a>\n
     <img src='" . INFUSIONS . "clancash_panel/images/konto.png' alt='".$locale['ccp135']."'><a class='navi' href='ccp_konten.php'>".$locale['ccp135']."</a>\n
     <img src='" . INFUSIONS . "clancash_panel/images/budget.png' alt='".$locale['ccp144']."'><a class='navi' href='ccp_budget.php'>".$locale['ccp144']."</a>\n";
if (checkrights('CCP'))
    echo"<img src='" . INFUSIONS . "clancash_panel/images/settings.png' alt='".$locale['ccp145']."'><a class='navi' href='ccp_settings_panel.php".$aidlink."'>".$locale['ccp145']."</a>\n";
echo"</h4>\n</center>\n";

?>
