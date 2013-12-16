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
if (!defined("IN_FUSION") || !IN_FUSION)
    die("Access denied!");

$openkonten = (isset($_POST['view'])) ? "on" : "off";
$openview = (isset($_POST['view_jahr'])) ? "on" : "off";
$opengraph = (isset($_POST['view_jahr'])) ? "on" : "off";
$openstats = (isset($_POST['stats_jahr'])) ? "on" : "off";
$box_img_konto = ($openkonten == "on" ? "off" : "on");
$box_img_view = ($openview == "on" ? "off" : "on");
$box_img_graph = ($opengraph == "on" ? "off" : "on");
$view_jahr = (isset($_POST['view_jahr'])) ? $_POST['view_jahr'] : $akt_jahr;
$stats_jahr = (isset($_POST['stats_jahr'])) ? $_POST['stats_jahr'] : $akt_jahr;

echo "<table class='tbl-border' cellspacing='1' cellpadding='0' style='width:100%'>
      <tr>";
if (checkgroup("$set_admin_id") || $show_all == 1) {
    echo "<td align='center' ><img onclick=\"javascript:flipBox('view')\" name='b_view' border='0' src='" . INFUSIONS . "clancash_panel/images/beitrag_$box_img_view.png'></td>
	<td align='left' ><span onclick=\"javascript:flipBox('view')\" style='cursor:pointer'>" . $locale['ccp158'] . "</span></td>
        <td align='center' ><img onclick=\"javascript:flipBox('graph')\" name='b_graph' border='0' src='" . INFUSIONS . "clancash_panel/images/einaus_$box_img_graph.png'></td>
        <td align='left' ><span onclick=\"javascript:flipBox('graph')\" style='cursor:pointer'>" . $locale['ccp161'] . "</span></td>";
}
echo "<td align='center' ><img onclick=\"javascript:flipBox('konten')\" name='b_konten' border='0' src='" . INFUSIONS . "clancash_panel/images/konto_$box_img_konto.png'></td>
        <td align='left' ><span onclick=\"javascript:flipBox('konten')\" style='cursor:pointer'>" . $locale['ccp151'] . "</span></td>";
if (checkgroup("$set_admin_id") || $show_all == 1) {
    echo "<td align='right' >" . $locale['ccp152'] . ": $valuta</td>\n";
}
echo"</tr>
      </table><br>
          <div id='box_konten'";
if ($openkonten == "off") {
    echo "style='display:none'";
} echo ">\n
          <table class='tbl-border' width='100%'>
          <tr align='center'>
          <td class='tbl1'>";
$result = dbquery("SELECT * FROM " . DB_CCP_KONTEN);
while ($data = dbarray($result)) {
    echo"<table class='tbl2' cellspacing='1' cellpadding='0' style='width:100%'>
            <tr>
              <td class='tbl-border' align='left' colspan='2'>" . $data['name'] . "</td>
            </tr>
            <tr>
              <td align='right' width='25%'>" . $locale['ccp137'] . ":&nbsp;</td>
              <td align='left'>&nbsp;" . $data['inhaber'] . "</td>
            </tr>
            <tr>
              <td align='right'>" . $locale['ccp140'] . ":&nbsp;</td>
              <td align='left'>&nbsp;" . $data['bank'] . "</td>
            </tr>
            <tr>
              <td align='right'>" . $locale['ccp106'] . ":&nbsp;</td>
              <td align='left'>&nbsp;" . $data['konto_id'] . "</td>
            </tr>
            <tr>
              <td align='right'>" . $locale['ccp139'] . ":&nbsp;</td>
              <td align='left'>&nbsp;" . $data['blz'] . "</td>
            </tr>
            <tr>
              <td align='right'>" . $locale['ccp141'] . ":&nbsp;</td>
              <td align='left'>&nbsp;" . $data['iban'] . "</td>
            </tr>
            <tr>
              <td align='right'>" . $locale['ccp142'] . ":&nbsp;</td>
              <td align='left'>&nbsp;" . $data['swift'] . "</td>
            </tr>
            <tr>
              <td align='right'><br>" . $locale['ccp156'] . ":&nbsp;</td>
              <td align='left'><br>&nbsp;" . $data['zweck'] . "</td>
            </tr>
            </table><br>";
    if ($paypal != '0' && $data['paypal_email'] != '') {
        echo" <a href='" . INFUSIONS . "clancash_panel/ccp_paypal.php?id=" . $data['id'] . "'><img src='" . $data['paypal_button'] . "' border='0'></a>";
    }
}
echo"</td></tr></table></div>
          <div id='box_view'";
if ($openview == "off") {
    echo "style='display:none'";
} echo ">\n";
require_once "ccp_beitrag.php";
echo"</div>";
echo "<div id='box_graph'";
if ($opengraph == "off") {
    echo "style='display:none'";
} echo ">\n";
echo "<center><img src='" . INFUSIONS . "clancash_panel/ccp_graph.php?year='$view_jahr' alt='" . $locale['ccp161'] . "' title='" . $locale['ccp161'] . "'></center>";
echo"</div>";
?>
