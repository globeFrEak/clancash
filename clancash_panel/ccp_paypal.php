<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: contact.php
| Author: Nick Jones (Digitanium)
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
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
		
    $AMOUNTS = "";
    $result = dbquery("SELECT * from " . DB_CCP_PAYPAL . " ORDER BY subtype");
    while ($data = dbarray($result)) {
        if (is_numeric($data['value']) && $data['value'] > 0) {
            $AMOUNTS .= '<input type="radio" name="amount" value="'. $data['value'] . '" '. (($data['subtype'] == $paypal_beitrag_checked) ? 'checked="checked"' : '') . ' /> '
                     . sprintf('&#8364;%.02f', $data['value']) . "\n" . $data['name'] . '<br />';
        }
    }

opentable($locale['ccp196']);
echo "

<form name'paypal_form' action=\"https://www.paypal.com/cgi-bin/webscr\" target=\"paypal\" method=\"post\">

<input type=\"hidden\" name=\"cmd\" value=\"_xclick\" /> 
<input type=\"hidden\" name=\"business\" value=\"".$paypal_email."\" />
<input type=\"radio\" name=\"amount\" value=\"\" />
<input type=\"text\" name=\"amount\" value=\"0.00\" size=\"6\" />&#8364; <input type='textbox' name='f_beitrag' size='31' maxlength='30'><br/>
$AMOUNTS ";
/*
if ($DONATION_AMOUNTS !="" or $DONATION_AMOUNTS !=0){
echo "<input type=\"hidden\" name=\"item_name\" value=\"".$data['name']." von ".$userdata['user_name']." \" />";
}
else {
echo "<input type=\"hidden\" name=\"item_name\" value=\"".$f_beitrag." von ".$userdata['user_name']." \" />";
}*/
echo "
<input type=\"hidden\" name=\"rm\" value=\"2\" />
<input type=\"hidden\" name=\"no_shipping\" value=\"0\" />
<input type=\"hidden\" name=\"currency_code\" value=\"EUR\" />
<input type=\"hidden\" name=\"cancel_return\" value=\"".$paypal_cancel_url."\" /> 
<input type=\"hidden\" name=\"return\" value=\"".$paypal_thanks_url."\" />
 
<center><input type=\"image\" src=\"http://www.paypal.com/de_DE/i/btn/x-click-but04.gif\" style='border-width:0' name=\"I1\" /></center>

</form>";

closetable();
}
} else {
    opentable($locale['ccp199']);
    echo "<h3>" . $locale['ccp200'] . "</h3>";
    closetable();
}
require_once THEMES."templates/footer.php";
?>
