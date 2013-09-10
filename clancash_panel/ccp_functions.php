<?php
/*---------------------------------------------------+
| PHP-Fusion 7 Content Management System
+----------------------------------------------------+
| Copyright © 2002 - 2013 Nick Jones
| http://www.php-fusion.co.uk/
|----------------------------------------------------+
| Infusion: Clankasse
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

$data = dbarray(dbquery("SELECT * FROM ".DB_CCP_SETTINGS));
$set_symbol = $data['waehrung'];
$set_member_id = $data['member_groupid'];
$set_admin_id = $data['cashadmin_groupid'];
$b_per_page = $data['zeilen'];
$is_admin = checkgroup($set_admin_id);
$show_all = $data['member_show_all'];
$show_names = $data['member_show_names'];
$gespeichert = "<table align='center' cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>\n<tr><td class='tbl2' align='center' width='100%'><span style='color:green;'><b>".$locale['ccp130']."</b></span></td></tr>\n</table>\n";
$ngespeichert = "<table align='center' cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>\n<tr><td class='tbl2' align='center' width='100%'><span style='color:red;'><b>".$locale['ccp132']."</b></span></td></tr>\n</table>\n";
$geloescht = "<table align='center' cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>\n<tr><td class='tbl2' align='center' width='100%'><span style='color:green;'><b>".$locale['ccp131']."</b></span></td></tr>\n</table>\n";
$ngeloescht = "<table align='center' cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>\n<tr><td class='tbl2' align='center' width='100%'><span style='color:red;'><b>".$locale['ccp134']."</b></span></td></tr>\n</table>\n";
$keintrag = "<table align='center' cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>\n<tr><td class='tbl2' align='center' width='100%'><span style='color:red;'><b>".$locale['ccp133']."</b></span></td></tr>\n</table>\n";
$doppelt = "<table align='center' cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>\n<tr><td class='tbl2' align='center' width='100%'><span style='color:red;'><b>".$locale['ccp157']."</b></span></td></tr>\n</table>\n";
$required = "<span style='color:red;'>*</span>";
$akt_monat = date('m');
$akt_jahr = date('Y');
$ed_valuta = "00.00";
$ed_comment = "";
$ed_tag = date('d');
$ed_monat = date('m');
$ed_jahr = date('Y');
$ed_kat = "0";
$ed_user_id = "0";
$ed_check_p = "selected ";

$data = dbarray(dbquery("SELECT SUM(valuta) AS summe FROM ".DB_CCP_BUCHUNGEN." WHERE geloescht='0'"));
($data['summe'] >= 0 ? $zeichen = "" : "-");
$summe = round($data['summe'],2);
$summe = number_format($summe,2,',','.');
$valuta = "<font style='font-size:150%'><b>$zeichen$summe $set_symbol</b></font>";

echo"<script type='text/javascript'>\n
      function ccp_ask_first(link)\n
            {\n
                return window.confirm('".$locale['ccp999']."');\n
            }\n
</script>\n";
?>
