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
require_once THEMES . "templates/header.php";

if (file_exists(INFUSIONS . "clancash_panel/locale/" . $settings['locale'] . ".php")) {
    include INFUSIONS . "clancash_panel/locale/" . $settings['locale'] . ".php";
} else {
    include INFUSIONS . "clancash_panel/locale/English.php";
}

if (!checkgroup($set_member_id))
    redirect("../../login.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $paypal_id = $_GET['id'];
    $user_name = '';
    $paypal_email = "";
    $paypal_button = "";
    $paypal_submit_button = "";
    $paypal_cancel_url = "";
    $paypal_thanks_url = "";
    $paypal_beitrag_checked = "";
//Get checked config
    $get_config = dbquery("SELECT * FROM " . DB_CCP_KONTEN . " WHERE id = $paypal_id");
    while ($data = dbarray($get_config)) {
        $paypal_email = $data['paypal_email'];
        $paypal_button = $data['paypal_button'];
        $paypal_submit_button = $data['paypal_submit_button'];
        $paypal_cancel_url = $data['paypal_cancel_url'];
        $paypal_thanks_url = $data['paypal_thanks_url'];
        $paypal_beitrag_checked = $data['paypal_beitrag_checked'];
    }
//Setup donations page with options and form
    $DONATION_AMOUNTS = "";
    $get_donation_amounts = dbquery("SELECT * from " . DB_CCP_PAYPAL . " WHERE name='Betrag' ORDER BY subtype");
    while ($data = dbarray($get_donation_amounts)) {
        if (is_numeric($data['value']) && $data['value'] > 0) {
            $DONATION_AMOUNTS .= '<input type="radio" name="amount" value="'
                    . $data['value'] . '" '
                    . (($data['subtype'] == $paypal_beitrag_checked) ? 'checked="checked"' : '') . ' /> '
                    . sprintf('&#8364;%.02f', $data['value']) . "\n" . $locale['ccp198'] . '<br />';
        }
    }
    opentable($locale['ccp196']);
    echo"<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" style=\"border-collapse: collapse\">
            <tr>
        <td><center>
        <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse; border-color='#111111'\" width='100%' id='AutoNumber1'>
               <tr>
                <td rowspan=\"6\" height=\"1\"><b><center><font size=\"4\">" . $locale['ccp197'] . "</center></font></b><br><br>
                    <form action=\"https://www.paypal.com/cgi-bin/webscr\" target=\"paypal\" method=\"post\">
                        <p> 
                            <input type=\"hidden\" name=\"cmd\" value=\"_xclick\" />
                            <input type=\"hidden\" name=\"business\" value=\"$paypal_email\" />
                            <input type=\"hidden\" name=\"item_name\" value=\"" . $locale['ccp198'] . "\" />
                            <input type=\"radio\" name=\"amount\" value=\"\" /> &#8364;
                            <input type=\"text\" name=\"amount\" value=\"0.00\" size=\"10\" /> Sonstiges
                            <input type=\"hidden\" name=\"rm\" value=\"2\" />
                            <br/>
                            $DONATION_AMOUNTS
                            <br/>
                        </p>
                        <input type=\"hidden\" name=\"on1\" value=\"Beitrag von\" />
                               <input type=\"hidden\" name=\"os1\" value=\"" . $userdata['user_name'] . "\" />
                        <input type=\"hidden\" name=\"no_shipping\" value=\"0\" />
                        <input type=\"hidden\" name=\"currency_code\" value=\"EUR\" />
                        <input type=\"hidden\" name=\"cn\" value=\"Comments\" />
                        <input type=\"hidden\" name=\"custom\" value=\"$user_name\" />
                        <input type=\"hidden\" name=\"cancel_return\" value=\"$paypal_cancel_url\" /> 
                        <input type=\"hidden\" name=\"return\" value=\"$paypal_thanks_url\" />
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                            <input type=\"image\" src=\"$paypal_submit_button\" style='border-width:0' name=\"I1\" />
                        </p>
                    </form>
                </td>
            </tr>
        </table>
        </td>
        </tr>
</table>
";
    closetable();
} else {
    opentable($locale['ccp199']);
    echo "<h3>" . $locale['ccp200'] . "</h3>";
    closetable();
}


require_once "ccp_copyright.php";
require_once THEMES . "templates/footer.php";
?>
