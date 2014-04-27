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
if (!defined("IN_FUSION") || !IN_FUSION)
    die("Access denied!");

if (file_exists(INFUSIONS . "clancash_panel/locale/" . $settings['locale'] . ".php")) {
    include INFUSIONS . "clancash_panel/locale/" . $settings['locale'] . ".php";
} else {
    include INFUSIONS . "clancash_panel/locale/English.php";
}

include INFUSIONS . "clancash_panel/infusion_db.php";
include_once INFUSIONS . "clancash_panel/ccp_functions.php";

openside($locale['ccp000']);
if (checkgroup("$set_member_id") || checkgroup("$set_admin_id")) {    
    if (checkgroup("$set_admin_id") || $show_all == 1) {
        ($summe >= 0 ? $valuta_panel = "<img src='".INFUSIONS."clancash_panel/images/plus.png' alt='plus' \>&nbsp;<b>$summe</b>&nbsp;$set_symbol" : $valuta_panel = "<img src='".INFUSIONS."clancash_panel/images/minus.png' alt='plus' \>&nbsp;<b>".substr($summe, 1)."</b>&nbsp;$set_symbol");
        echo"<center>$valuta_panel</center>";
    }
} else {
    echo "<span><b>" . $locale['ccp162'] . "</b></span>";
}
if (checkgroup("$set_member_id") || checkgroup("$set_admin_id")) {
    echo "<center><a href='" . INFUSIONS . "clancash_panel/ccp_clancash.php'>" . $locale['ccp153'] . "</a>";
}
echo "</center>";
closeside();
?>