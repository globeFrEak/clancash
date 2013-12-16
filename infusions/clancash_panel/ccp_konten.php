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
require_once "../../maincore.php";
require_once THEMES . "templates/header.php";
include INFUSIONS . "clancash_panel/infusion_db.php";

if (file_exists(INFUSIONS . "clancash_panel/locale/" . $settings['locale'] . ".php")) {
    include INFUSIONS . "clancash_panel/locale/" . $settings['locale'] . ".php";
} else {
    include INFUSIONS . "clancash_panel/locale/English.php";
}
include_once INFUSIONS . "clancash_panel/ccp_functions.php";

add_to_head("<style type='text/css'>
.paypal {    
    margin: 0px 10px 0px 0px;
}
</style>");

add_to_head("<script type=\"text/javascript\">
$(document).ready(function() {
$(\"#chasadmin\").submit( function() { 
var email = jQuery.trim($('#paypal_email').val());
var regex = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
if (email.length > 0){
  if(!regex.test(email)) {
     alert(\"" . $locale['ccp201'] . "\");
     return false;
     } else { return true;} 
   };
  }); 
});

function updatePaypal() {    
    var paypal_btn = $('#paypal_btn').val();
    if (paypal_btn.length < 3 || checkUrl(paypal_btn) == false ){
        paypal_btn = 'https://www.paypalobjects.com/de_DE/DE/i/btn/btn_donate_LG.gif';
    }
    $('#paypal_btn_img').fadeOut('slow', function() {
	$('#paypal_btn_img').attr('src', paypal_btn);
	$('#paypal_btn_img').fadeIn('slow');
    });
}

function updatePaypalSubmit() {    
    var paypal_btn = $('#paypal_submit_btn').val();
    if (paypal_btn.length < 3 || checkUrl(paypal_btn) == false ){
        paypal_btn = 'https://www.paypalobjects.com/de_DE/DE/i/btn/btn_donateCC_LG.gif';
    }
    $('#paypal_submit_btn_img').fadeOut('slow', function() {
	$('#paypal_submit_btn_img').attr('src', paypal_btn);
	$('#paypal_submit_btn_img').fadeIn('slow');
    });
}
function checkUrl(url){
    return url.match(/(http|ftp|https):\/\/[\w\-_]+(\.[\w\-_]+)+([\w\-\.,@?^=%&amp;:/~\+#]*[\w\-\@?^=%&amp;/~\+#])?/);
}
</script>");

$del = (isset($_POST['del'])) ? $_POST['del'] : "";
$edit = (isset($_POST['edit'])) ? $_POST['edit'] : "";
$konto_id = (isset($_POST['konto_id']) && is_numeric($_POST['konto_id'])) ? $_POST['konto_id'] : "";
$name = (isset($_POST['name'])) ? $_POST['name'] : "";
$zweck = (isset($_POST['zweck'])) ? $_POST['zweck'] : "";
$inhaber = (isset($_POST['inhaber'])) ? $_POST['inhaber'] : "";
$blz = (isset($_POST['blz']) && is_numeric($_POST['blz'])) ? $_POST['blz'] : "";
$iban = (isset($_POST['iban'])) ? $_POST['iban'] : "";
$swift = (isset($_POST['swift'])) ? $_POST['swift'] : "";
$bank = (isset($_POST['bank'])) ? $_POST['bank'] : "";
$paypal_email = (isset($_POST['paypal_email'])) && VerifyMail($_POST['paypal_email']) ? $_POST['paypal_email'] : "";
$paypal_button = (isset($_POST['paypal_button'])) ? $_POST['paypal_button'] : "";
$paypal_submit_button = (isset($_POST['paypal_submit_button'])) ? $_POST['paypal_submit_button'] : "";
$paypal_cancel_url = (isset($_POST['paypal_cancel_url'])) ? $_POST['paypal_cancel_url'] : "";
$paypal_thanks_url = (isset($_POST['paypal_thanks_url'])) ? $_POST['paypal_thanks_url'] : "";
$paypal_beitrag_checked = (isset($_POST['paypal_beitrag_checked'])) ? $_POST['paypal_beitrag_checked'] : "";
$don_amount_checked = (isset($_POST['don_amount_checked'])) ? $_POST['don_amount_checked'] : "";

$ed_konto_id = (isset($_POST['ed_konto_id']) && is_numeric($_POST['ed_konto_id'])) ? $_POST['ed_konto_id'] : "";
$ed_name = (isset($_POST['ed_name'])) ? $_POST['ed_name'] : "";
$ed_inhaber = (isset($_POST['ed_inhaber'])) ? $_POST['ed_inhaber'] : "";
$ed_id = (isset($_POST['ed_id'])) ? $_POST['ed_id'] : "";
$ed_blz = (isset($_POST['ed_blz']) && is_numeric($_POST['ed_blz'])) ? $_POST['ed_blz'] : "";
$ed_iban = (isset($_POST['ed_iban'])) ? $_POST['ed_iban'] : "";
$ed_swift = (isset($_POST['ed_swift'])) ? $_POST['ed_swift'] : "";
$ed_bank = (isset($_POST['ed_bank'])) ? $_POST['ed_bank'] : "";
$ed_zweck = (isset($_POST['ed_zweck'])) ? $_POST['ed_zweck'] : "";
$ed_paypal_email = (isset($_POST['ed_paypal_email'])) && VerifyMail($_POST['ed_paypal_email']) ? $_POST['ed_paypal_email'] : "";
$ed_paypal_button = (isset($_POST['ed_paypal_button'])) ? $_POST['ed_paypal_button'] : "";
$ed_paypal_submit_button = (isset($_POST['ed_paypal_submit_button'])) ? $_POST['ed_paypal_submit_button'] : "";
$ed_paypal_cancel_url = (isset($_POST['ed_paypal_cancel_url'])) ? $_POST['ed_paypal_cancel_url'] : "";
$ed_paypal_thanks_url = (isset($_POST['ed_paypal_thanks_url'])) ? $_POST['ed_paypal_thanks_url'] : "";
$ed_paypal_beitrag_checked = (isset($_POST['ed_paypal_beitrag_checked'])) ? $_POST['ed_paypal_beitrag_checked'] : "";

if (!checkgroup($set_admin_id))
    redirect("../../login.php");

if ((isset($_GET['del'])) != '') {
    $del = $_GET['del'];
    if (dbrows(dbquery("SELECT * FROM " . DB_CCP_BUCHUNGEN . " WHERE konto_id='$del'")) == 0) {
        dbquery("DELETE FROM " . DB_CCP_KONTEN . " WHERE ID='$del'");
        echo $geloescht;
    } else {
        echo $ngeloescht;
    }
}

if ((isset($_GET['edit'])) != '') {
    $edit = $_GET['edit'];
    $update = dbarray(dbquery("SELECT * FROM " . DB_CCP_KONTEN . " WHERE id='$edit'"));
    $ed_konto_id = $update['konto_id'];
    $ed_name = $update['name'];
    $ed_inhaber = $update['inhaber'];
    $ed_blz = $update['blz'];
    $ed_iban = $update['iban'];
    $ed_swift = $update['swift'];
    $ed_bank = $update['bank'];
    $ed_zweck = $update['zweck'];
    $ed_paypal_email = $update['paypal_email'];
    $ed_paypal_button = $update['paypal_button'];
    $ed_paypal_submit_button = $update['paypal_submit_button'];
    $ed_paypal_cancel_url = $update['paypal_cancel_url'];
    $ed_paypal_thanks_url = $update['paypal_thanks_url'];
    $ed_paypal_beitrag_checked = $update['paypal_beitrag_checked'];    
}

if (isset($_POST['save'])) {
    if ($_POST['konto_id'] == '' || $_POST['name'] == '' || $_POST['inhaber'] == '' || $_POST['blz'] == '' || $_POST['zweck'] == '') {
        echo $ngespeichert;
    } else {
        dbquery("INSERT " . DB_CCP_KONTEN . " SET
konto_id = '" . stripinput($konto_id) . "',
name = '" . stripinput($name) . "',
inhaber = '" . stripinput($inhaber) . "',
blz = '" . stripinput($blz) . "',
iban = '" . stripinput($iban) . "',
swift = '" . stripinput($swift) . "',
bank = '" . stripinput($bank) . "',
zweck = '" . stripinput($zweck) . "',
paypal_email = '" . stripinput($paypal_email) . "',
paypal_button = '" . stripinput($paypal_button) . "',
paypal_submit_button = '" . stripinput($paypal_submit_button) . "',
paypal_cancel_url = '" . stripinput($paypal_cancel_url) . "',
paypal_thanks_url = '" . stripinput($paypal_thanks_url) . "',
paypal_beitrag_checked = '" . stripinput($paypal_beitrag_checked) . "'");
        echo $gespeichert;
    }
}

if (isset($_POST['update'])) {
    if ($_POST['konto_id'] == '' || $_POST['name'] == '' || $_POST['inhaber'] == '' || $_POST['blz'] == '' || $_POST['zweck'] == '') {
        echo $ngespeichert;
    } else {
        dbquery("UPDATE " . DB_CCP_KONTEN . " SET
konto_id = '" . stripinput($konto_id) . "',
name = '" . stripinput($name) . "',
inhaber = '" . stripinput($inhaber) . "',
blz = '" . stripinput($blz) . "',
iban = '" . stripinput($iban) . "',
swift = '" . stripinput($swift) . "',
bank = '" . stripinput($bank) . "',
zweck = '" . stripinput($zweck) . "',
paypal_email = '" . stripinput($paypal_email) . "',
paypal_button = '" . stripinput($paypal_button) . "',
paypal_submit_button = '" . stripinput($paypal_submit_button) . "',
paypal_cancel_url = '" . stripinput($paypal_cancel_url) . "',
paypal_thanks_url = '" . stripinput($paypal_thanks_url) . "',
paypal_beitrag_checked = '" . stripinput($paypal_beitrag_checked) . "' WHERE id='$ed_id'");
    }

    $var_don_amount_1 = stripinput($_POST['var_don_amount_1']);
    $var_don_amount_2 = stripinput($_POST['var_don_amount_2']);
    $var_don_amount_3 = stripinput($_POST['var_don_amount_3']);
    $var_don_amount_4 = stripinput($_POST['var_don_amount_4']);

    $result = dbquery("UPDATE " . DB_CCP_PAYPAL . " SET value='$var_don_amount_1' WHERE subtype=1");
    $result = dbquery("UPDATE " . DB_CCP_PAYPAL . " SET value='$var_don_amount_2' WHERE subtype=2");
    $result = dbquery("UPDATE " . DB_CCP_PAYPAL . " SET value='$var_don_amount_3' WHERE subtype=3");
    $result = dbquery("UPDATE " . DB_CCP_PAYPAL . " SET value='$var_don_amount_4' WHERE subtype=4");
    echo $gespeichert;
}

opentable($locale['ccp_a000']);
include_once "ccp_navigation.php";
closetable();
opentable($locale['ccp135']);
$result = dbquery("SELECT * FROM " . DB_CCP_KONTEN . " ORDER BY name");
if (dbrows($result) > 0) {
    echo"<table align='center' class='tbl-border' width='100%'>";
    while ($data = dbarray($result)) {
        $cell_color = ($i % 2 == 0 ? "tbl1" : "tbl2");
        $i++;
        echo"<tr>
        <td class='$cell_color' align='center' width='70%'>" . $data['name'] . "</td>
        <td class='$cell_color' align='center' width='30%'><a href='" . FUSION_SELF . "?edit=" . $data['id'] . "'>" . $locale['ccp113'] . "</a>";
        if (dbrows(dbquery("SELECT * FROM " . DB_CCP_BUCHUNGEN . " WHERE konto_id='" . $data['id'] . "'")) == 0) {
            echo " -- <a href='" . FUSION_SELF . "?del=" . $data['id'] . "' onclick='return ccp_ask_first(this)'>" . $locale['ccp114'] . "</a>";
        } else {
            echo " -- <span style='text-decoration:line-through;'>" . $locale['ccp114'] . "</span>";
        }
        echo"</td></tr>";
    }
    echo"</table>";
} else {
    echo $keintrag;
}
echo "<hr></hr>";
echo"<form name='chasadmin' id='chasadmin' method='post' enctype='multipart/form-data' action='" . FUSION_SELF . "'>";
echo"<table class='tbl-border' width='100%'>";
echo"<tr>
            <td class='tbl1'>" . $locale['ccp136'] . ":$required</td>
            <td class='tbl1'><input name='name' class='textbox' value='$ed_name' maxlength='15' style='width:100%;'></td>
        </tr>
        <tr>
            <td class='tbl1'>" . $locale['ccp137'] . ":$required</td>
            <td class='tbl1'><input name='inhaber' class='textbox' value='$ed_inhaber' maxlength='40' style='width:100%;'></td>
        </tr>
        <tr>
            <td class='tbl1'>" . $locale['ccp138'] . ":$required</td>
            <td class='tbl1'><input name='konto_id' class='textbox' value='$ed_konto_id' maxlength='15' style='width:100%;'></td>
        </tr>
        <tr>
            <td class='tbl1'>" . $locale['ccp139'] . ":$required</td>
            <td class='tbl1'><input name='blz' class='textbox' value='$ed_blz' maxlength='10' style='width:100%;'></td>
        </tr>
        <tr>
            <td class='tbl1'>" . $locale['ccp140'] . ":</td>
            <td class='tbl1'><input name='bank' class='textbox' value='$ed_bank' maxlength='40' style='width:100%;'></td>
        </tr>
        <tr>
            <td class='tbl1'>" . $locale['ccp156'] . ":$required</td>
            <td class='tbl1'><input name='zweck' class='textbox' value='$ed_zweck' maxlength='54' style='width:100%;'></td>
        </tr>
        <tr>
            <td class='tbl1'>" . $locale['ccp141'] . ":</td>
            <td class='tbl1'><input name='iban' class='textbox' value='$ed_iban' maxlength='34' style='width:100%;'></td>
        </tr>
        <tr>
            <td class='tbl1'>" . $locale['ccp142'] . ":</td>
            <td class='tbl1'><input name='swift' class='textbox' value='$ed_swift' maxlength='11' style='width:100%;'></td>
        </tr>";
if ($paypal != '0') {
    echo"<tr>
            <td class='tbl1' colspan='2' align='center'><h4>" . $locale['ccp188'] . "</h4></td>
        </tr>
        <tr>
            <td class='tbl1'>" . $locale['ccp183'] . "</td>
            <td class='tbl1'><input name='paypal_email' id='paypal_email' class='textbox' value='$ed_paypal_email' maxlength='200' style='width:100%;'></td>
        </tr>
        <tr>
            <td class='tbl1'>" . $locale['ccp184'] . "</td>";
    echo"<td title='" . $locale['ccp192'] . "' class='tbl1' style='vertical-align: middle;'><input onchange='updatePaypal();' id='paypal_btn' name='paypal_button' class='textbox paypal' value='" . (($ed_paypal_button == '') ? "https://www.paypalobjects.com/de_DE/DE/i/btn/btn_donate_LG.gif" : $ed_paypal_button ) . "' maxlength='300' style='width:100%;'><img id='paypal_btn_img' src='" . (($ed_paypal_button == '') ? "https://www.paypalobjects.com/de_DE/DE/i/btn/btn_donate_LG.gif" : $ed_paypal_button ) . "' alt='paypal_button' style='max-height:80px; max-width:80px;'/></td></tr>";
    echo"<tr>
            <td class='tbl1'>" . $locale['ccp185'] . "</td>";
    echo"<td title='" . $locale['ccp192'] . "' class='tbl1' style='vertical-align: middle;'><input onchange='updatePaypalSubmit();' id='paypal_submit_btn' name='paypal_submit_button' class='textbox paypal' value='" . (($ed_paypal_submit_button == '') ? "https://www.paypalobjects.com/de_DE/DE/i/btn/btn_donateCC_LG.gif" : $ed_paypal_submit_button) . "' maxlength='300' style='width:100%;'><img id='paypal_submit_btn_img' src='" . (($ed_paypal_button == '') ? "https://www.paypalobjects.com/de_DE/DE/i/btn/btn_donateCC_LG.gif" : $ed_paypal_button ) . "' alt='paypal_button' style='max-height:80px; max-width:80px;'/></td></tr>";
    echo"<tr>
            <td class='tbl1'>" . $locale['ccp186'] . "</td>
            <td class='tbl1'><input name='paypal_cancel_url' class='textbox' value='$ed_paypal_cancel_url' maxlength='200' style='width:100%;'></td>
        </tr>
        <tr>
            <td class='tbl1'>" . $locale['ccp187'] . "</td>
            <td class='tbl1'><input name='paypal_thanks_url' class='textbox' value='$ed_paypal_thanks_url' maxlength='200' style='width:100%;'></td>
        </tr>";

    if (!isset($_GET['step'])) {
        $step = "donationoptions";
    } else {
        $step = $_GET['step'];
    }
    include INFUSIONS . "clancash_panel/ccp_paypal_admin_form.php";
}
if ($edit != "") {
    echo"<tr><td align='center' class='tbl2' colspan='2'><input type='hidden' name='ed_id' value='$edit'><input type='submit' name='update' class='button' value='" . $locale['ccp108'] . "'></td></tr>";
} else {
    echo"<tr><td align='center' class='tbl2' colspan='2'><input type='submit' name='save' class='button' value='" . $locale['ccp110'] . "'></td></tr>";
}
echo"<tr>
            <td class='tbl1' align='center' colspan='2'>" . $locale['ccp111'] . "</td></tr>
    </table></form>";
closetable();
include_once "ccp_copyright.php";
include_once THEMES . "templates/footer.php";
?>
