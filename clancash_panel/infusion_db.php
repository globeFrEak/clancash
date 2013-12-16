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
if (!defined("IN_FUSION")) { die("Access Denied"); }

if (!defined("DB_CCP_BUCHUNGEN")) {
    define("DB_CCP_BUCHUNGEN", DB_PREFIX."ccp_buchungen");
}

if (!defined("DB_CCP_BUDGET")) {
    define("DB_CCP_BUDGET", DB_PREFIX."ccp_budget");
}

if (!defined("DB_CCP_KATEGORIEN")) {
    define("DB_CCP_KATEGORIEN", DB_PREFIX."ccp_kategorien");
}

if (!defined("DB_CCP_KONTEN")) {
    define("DB_CCP_KONTEN", DB_PREFIX."ccp_konten");
}

if (!defined("DB_CCP_SETTINGS")) {
    define("DB_CCP_SETTINGS", DB_PREFIX."ccp_settings");
}

if (!defined("DB_CCP_PAYPAL")) {
    define("DB_CCP_PAYPAL", DB_PREFIX."ccp_paypal");
}
?>
