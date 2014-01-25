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
require_once "../../maincore.php";
require_once THEMES."templates/header.php";
include INFUSIONS."clancash_panel/infusion_db.php";

if (file_exists(INFUSIONS."clancash_panel/locale/".$settings['locale'].".php")) {
    include INFUSIONS."clancash_panel/locale/".$settings['locale'].".php";
} else {
    include INFUSIONS."clancash_panel/locale/English.php";
}

include_once INFUSIONS."clancash_panel/ccp_functions.php";
if (!checkgroup($set_member_id) && !checkgroup($set_admin_id)) redirect("../../login.php");

opentable($locale['ccp000']);
echo"
<table align='center' width='100%'>\n
  <tr>\n
    <td>\n";
      include "ccp_valuta.php";
      include "ccp_filter.php";
      include "ccp_buchungen.php";
echo"</td>\n
  </tr>\n
</table>\n";

closetable();

include "ccp_copyright.php";
require_once THEMES."templates/footer.php";
?>
