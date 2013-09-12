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

echo"<center>\n<h4>\n<a href='ccp_admin_panel.php".$aidlink."'>".$locale['ccp143']."</a>&nbsp;".THEME_BULLET."&nbsp;\n
     <a href='ccp_cats.php'>".$locale['ccp127']."</a>&nbsp;".THEME_BULLET."&nbsp;\n
     <a href='ccp_konten.php'>".$locale['ccp135']."</a>&nbsp;".THEME_BULLET."&nbsp;\n
     <a href='ccp_budget.php'>".$locale['ccp144']."</a>\n";
if (checkrights('CCP'))echo"&nbsp;".THEME_BULLET."&nbsp;<a href='ccp_settings_panel.php".$aidlink."'>".$locale['ccp145']."</a>\n";
echo"</h4>\n</center>\n";

?>
