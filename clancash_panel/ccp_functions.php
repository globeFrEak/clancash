<?php

/* --------------------------------------------------------------+
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
  +-------------------------------------------------------------- */
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
$gespeichert = "<table cellpadding='0' cellspacing='1' class='tbl-border tbl_ccp'>\n<tr><td class='tbl2'><span class='ccp_positive'>" . $locale['ccp130'] . "</span></td></tr>\n</table>\n";
$ngespeichert = "<table cellpadding='0' cellspacing='1' class='tbl-border tbl_ccp'>\n<tr><td class='tbl2'><span class='ccp_negative'>" . $locale['ccp132'] . "</span></td></tr>\n</table>\n";
$geloescht = "<table cellpadding='0' cellspacing='1' class='tbl-border tbl_ccp'>\n<tr><td class='tbl2'><span class='ccp_positive'>" . $locale['ccp131'] . "</span></td></tr>\n</table>\n";
$ngeloescht = "<table cellpadding='0' cellspacing='1' class='tbl-border tbl_ccp'>\n<tr><td class='tbl2'><span class='ccp_negative'>" . $locale['ccp134'] . "</span></td></tr>\n</table>\n";
$keintrag = "<table cellpadding='0' cellspacing='1' class='tbl-border tbl_ccp'>\n<tr><td class='tbl2'><span class='ccp_negative'>" . $locale['ccp133'] . "</span></td></tr>\n</table>\n";
$doppelt = "<table cellpadding='0' cellspacing='1' class='tbl-border tbl_ccp'>\n<tr><td class='tbl2'><span class='ccp_negative'>" . $locale['ccp157'] . "</span></td></tr>\n</table>\n";
$required = "<span class='ccp_require'>*</span>";
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

add_to_head("<script type='text/javascript'>
    function ccp_ask_first(link){
        return window.confirm('" . $locale['ccp999'] . "');
    }
</script>");

add_to_head("<link rel='stylesheet' href='" . INFUSIONS . "clancash_panel/css/clancash.css' type='text/css'/>\n");

function VerifyMail($mail) {
    $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
    if (preg_match($pattern, $mail) === 1) {
        return true;
    }
}

//// Testsequenz für Updateüberprüfung ////
function latest_ccp_version() {
    $url = "http://germanys-united-legends.de/version/phpfusion_ccp.txt";
    $url_p = @parse_url($url);
    $host = $url_p['host'];
    $port = isset($url_p['port']) ? $url_p['port'] : 80;

    $fp = @fsockopen($url_p['host'], $port, $errno, $errstr, 5);
    if (!$fp)
        return false;

    @fputs($fp, 'GET ' . $url_p['path'] . ' HTTP/1.1' . chr(10));
    @fputs($fp, 'HOST: ' . $url_p['host'] . chr(10));
    @fputs($fp, 'Connection: close' . chr(10) . chr(10));

    $response = @fgets($fp, 1024);
    $content = @fread($fp, 1024);
    $content = preg_replace("#(.*?)text/plain(.*?)$#is", "$2", $content);
    @fclose($fp);

    $content = preg_replace("/X-Pad: avoid browser bug/si", "", $content);

    if (preg_match("#404#", $response))
        return false;
    else
        return trim($content);
}

// Filter Settings
if (((isset($_POST['filter_jahr'])) || (isset($_POST['filter_monat'])) || (isset($_POST['filter_user'])) || (isset($_POST['filter_cat'])) || (isset($_POST['filter_konto'])) || (isset($_GET['year'])) || (isset($_GET['month'])) || (isset($_GET['user'])) || (isset($_GET['cat'])) || (isset($_GET['account']))) && !(isset($_POST['reset']))) {
    $filter_jahr = (isset($_POST['filter_jahr'])) ? mysql_real_escape_string($_POST['filter_jahr']) : $_GET['year'];
    $filter_monat = (isset($_POST['filter_monat'])) ? mysql_real_escape_string($_POST['filter_monat']) : $_GET['month'];
    if ($show_all == 1) {
        $filter_user = (isset($_POST['filter_user'])) ? mysql_real_escape_string($_POST['filter_user']) : $_GET['user'];
    } else if ($is_admin == 1) {
        $filter_user = (isset($_POST['filter_user'])) ? mysql_real_escape_string($_POST['filter_user']) : $_GET['user'];
    } else {
        $filter_user = $userdata['user_id'];
    }
    $filter_cat = (isset($_POST['filter_cat'])) ? mysql_real_escape_string($_POST['filter_cat']) : $_GET['cat'];
    $filter_konto = (isset($_POST['filter_konto'])) ? mysql_real_escape_string($_POST['filter_konto']) : $_GET['account'];
} else {
    if ($show_all == 1) {
        $filter_user = "all";
    } else {
        $filter_user = ($is_admin == 1 ? "all" : $userdata['user_id']);
    }
    $filter_cat = "all";
    $filter_monat = "all";
    $filter_jahr = $akt_jahr;
    $filter_konto = "all";
    $year = "";
    $month = "";
    $user = "";
    $cat = "";
    $month = "";
}


$data = dbarray(dbquery("SELECT SUM(valuta) AS summe FROM " . DB_CCP_BUCHUNGEN . " WHERE geloescht='0'"));
$summe = number_format($data['summe'], 2, $locale['ccp006'], $locale['ccp007']);
$valuta = "<font style='font-size:150%'><b>$summe $set_symbol</b></font>";

if (isset($_POST['filter_konto']) && $_POST['filter_konto'] != 'all') {
    $data = dbarray(dbquery("SELECT SUM(valuta) AS summe FROM " . DB_CCP_BUCHUNGEN . " WHERE geloescht='0' AND konto_id = '" . mysql_real_escape_string($_POST['filter_konto']) . "'"));
    $summe_konto = number_format($data['summe'], 2, $locale['ccp006'], $locale['ccp007']);
    $valuta = "<font style='font-size:150%'><b>$summe_konto $set_symbol</b></font>";
}
?>
