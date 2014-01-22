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
if (!defined("IN_FUSION") || !IN_FUSION)
    die("Access denied!");

$data = dbarray(dbquery("SELECT * FROM " . DB_CCP_SETTINGS));
$set_symbol = $data['waehrung'];
$set_member_id = $data['member_groupid'];
$set_admin_id = $data['cashadmin_groupid'];
$b_per_page = $data['zeilen'];
$is_admin = checkgroup($set_admin_id);
$show_all = $data['member_show_all'];
$show_names = $data['member_show_names'];
$placeholder_name = $data['placeholder_name'];
$paypal = $data['paypal'];
$standard_konto = $data['standard_konto'];
$gespeichert = "<table align='center' cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>\n<tr><td class='tbl2' align='center' width='100%'><span style='color:green;'><b>" . $locale['ccp130'] . "</b></span></td></tr>\n</table>\n";
$ngespeichert = "<table align='center' cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>\n<tr><td class='tbl2' align='center' width='100%'><span style='color:red;'><b>" . $locale['ccp132'] . "</b></span></td></tr>\n</table>\n";
$geloescht = "<table align='center' cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>\n<tr><td class='tbl2' align='center' width='100%'><span style='color:green;'><b>" . $locale['ccp131'] . "</b></span></td></tr>\n</table>\n";
$ngeloescht = "<table align='center' cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>\n<tr><td class='tbl2' align='center' width='100%'><span style='color:red;'><b>" . $locale['ccp134'] . "</b></span></td></tr>\n</table>\n";
$keintrag = "<table align='center' cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>\n<tr><td class='tbl2' align='center' width='100%'><span style='color:red;'><b>" . $locale['ccp133'] . "</b></span></td></tr>\n</table>\n";
$doppelt = "<table align='center' cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>\n<tr><td class='tbl2' align='center' width='100%'><span style='color:red;'><b>" . $locale['ccp157'] . "</b></span></td></tr>\n</table>\n";
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
$ccp_version = $data['version'];

$data = dbarray(dbquery("SELECT SUM(valuta) AS summe FROM " . DB_CCP_BUCHUNGEN . " WHERE geloescht='0'"));
$summe = round($data['summe'], 2);
$summe = number_format($summe, 2, ',', '.');
$valuta = "<font style='font-size:150%'><b>$summe $set_symbol</b></font>";

add_to_head("<script type='text/javascript'>
    function ccp_ask_first(link){
        return window.confirm('" . $locale['ccp999'] . "');
    }
</script>");

function VerifyMail($mail) {
    $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
    if (preg_match($pattern, $mail) === 1) {
        return true;
    }
}

//// Testsequenz für Updateüberprüfung ////
function latest_ccp_version()
{
	$url = "http://germanys-united-legends.de/version/phpfusion_ccp.txt";
	$url_p = @parse_url($url);
	$host = $url_p['host'];
	$port = isset($url_p['port']) ? $url_p['port'] : 80;

	$fp = @fsockopen($url_p['host'], $port, $errno, $errstr, 5);
	if(!$fp) return false;

	@fputs($fp, 'GET '.$url_p['path'].' HTTP/1.1'.chr(10));
	@fputs($fp, 'HOST: '.$url_p['host'].chr(10));
	@fputs($fp, 'Connection: close'.chr(10).chr(10));

	$response = @fgets($fp, 1024);
	$content = @fread($fp,1024);
	$content = preg_replace("#(.*?)text/plain(.*?)$#is","$2",$content);
	@fclose ($fp);

	$content = preg_replace("/X-Pad: avoid browser bug/si", "", $content);

	if(preg_match("#404#",$response)) return false;
	else return trim($content);
}
?>
