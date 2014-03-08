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

require_once INFUSIONS . "clancash_panel/ccp_graph.php";

$openkonten = (isset($_POST['view_jahr'])) ? "on" : "off";
$openview = (isset($_POST['view_jahr'])) ? "on" : "off";
$opengraph = (isset($_POST['view_jahr'])) ? "on" : "off";
$openstats = (isset($_POST['stats_jahr'])) ? "on" : "off";
$view_jahr = (isset($_POST['view_jahr'])) ? $_POST['view_jahr'] : $akt_jahr;
$stats_jahr = (isset($_POST['stats_jahr'])) ? $_POST['stats_jahr'] : $akt_jahr;

add_to_head("<script>		  
	  $(document).ready(function(){		
		$('a.tab').click(function () {
                        $('.active').removeClass('tbl-border');
			$('.active').removeClass('active');                        
			$(this).addClass('active');
                        $(this).addClass('tbl-border');
			$('.tab_content').slideUp();			
			var content_show = $(this).attr('title');
			$('#'+content_show).slideDown();		  
		});	
	  });
  </script>");

echo "<div id='tabbed_box_1' class='tabbed_box'>";
echo "<div class='tabbed_area'>";
echo "<ul class='ccp_tabs'>";
if (checkgroup("$set_admin_id") || $show_all == 1) {
    echo "<li><a href='#' title='content_1' class='tab active tbl-border'><img border='0' src='" . INFUSIONS . "clancash_panel/images/graph.png'>" . $locale['ccp161'] . "</a></li>";
    echo "<li><a href='#' title='content_2' class='tab'><img border='0' src='" . INFUSIONS . "clancash_panel/images/beitrag.png'>" . $locale['ccp158'] . "</a></li>";
}
echo "<li><a href='#' title='content_3' class='tab'><img border='0' src='" . INFUSIONS . "clancash_panel/images/konto.png'>" . $locale['ccp151'] . "</a></li>";
if (checkgroup("$set_admin_id") || $show_all == 1) {
    echo "<li><span>" . $locale['ccp152'] . ": $valuta</span></li>";
}
echo "</ul>";

/** Graph **/
echo "<div id='content_1' class='tbl-border tab_content'>";
echo "<div id='box_graph'></div>";
echo "</div>";

/** Beiträge **/
echo "<div id='content_2' class='tbl-border tab_content'>";
require_once "ccp_beitrag.php";
echo "</div>";

/** Kontakt **/
echo "<div id='content_3' class='tbl-border tab_content'>";
echo "<table class='tbl-border' width='100%'>
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
echo"</td></tr></table>";
echo "</div>";
echo "</div>";
echo "</div>";
?>