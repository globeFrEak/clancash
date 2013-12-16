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
if (!defined("IN_FUSION")) {
    die("Access Denied");
}

include INFUSIONS . "clancash_panel/infusion_db.php";

if (file_exists(INFUSIONS . "clancash_panel/locale/" . $settings['locale'] . ".php")) {
    include INFUSIONS . "clancash_panel/locale/" . $settings['locale'] . ".php";
} else {
    include INFUSIONS . "clancash_panel/locale/English.php";
}

// Infusion general information
$inf_title = $locale['ccp000'];
$inf_version = $locale['ccp002'];
$inf_developer = "RedDragon (v6) | globefreak & Sonic since v1.3 (v7)";
$inf_weburl = "https://github.com/globeFrEak/clancash";
$inf_email = "globefreak@cwclan.de";
$inf_folder = "clancash_panel";
$inf_description = $locale['ccp001'];

$inf_newtable[1] = DB_CCP_BUCHUNGEN . "(
id int(11) NOT NULL auto_increment,
user_id int(6) default NULL,
valuta float NOT NULL,
kat_id int(6) NOT NULL,
tag int(2) NOT NULL,
monat int(2) NOT NULL,
jahr int(4) NOT NULL,
comment varchar(100) NOT NULL,
geloescht int(1) default '0',
konto_id int(15) default NULL,
PRIMARY KEY  (id)
)ENGINE=MyISAM;";

$inf_newtable[2] = DB_CCP_BUDGET . "(
id int(11) NOT NULL auto_increment,
anzahl int(6) NOT NULL,
betrag float NOT NULL default '0',
zweck varchar(54) default NULL,
art int(1) NOT NULL default '1',
bmonat float default NULL,
PRIMARY KEY  (id)
)ENGINE=MyISAM;";

$inf_newtable[3] = DB_CCP_KATEGORIEN . "(
id int(11) NOT NULL auto_increment,
kat_klartext varchar(40) NOT NULL,
PRIMARY KEY  (id)
)ENGINE=MyISAM;";

$inf_newtable[4] = DB_CCP_KONTEN . "(
id int(11) NOT NULL auto_increment,
konto_id int(15) NOT NULL,
name varchar(15) NOT NULL,
inhaber varchar(40) NOT NULL,
blz int(10) NOT NULL,
iban varchar(34) default NULL,  
swift varchar(11) default NULL,  
bank varchar(40) NOT NULL,  
zweck varchar(54) NOT NULL,
paypal_email varchar(200) NOT NULL,
paypal_button varchar(200) NOT NULL,
paypal_submit_button varchar(200) NOT NULL,
paypal_cancel_url varchar(200) default NULL,
paypal_thanks_url varchar(200) default NULL,
paypal_beitrag_checked tinyint(2) NOT NULL default '1',
PRIMARY KEY  (id)
)ENGINE=MyISAM;";

$inf_newtable[5] = DB_CCP_SETTINGS . "(
id int(11) NOT NULL auto_increment,
cashadmin_groupid int(6) NOT NULL,
member_groupid int(6) NOT NULL,
zeilen int(2) NOT NULL default '15',
waehrung varchar(5) default 'EUR',
member_show_all BOOL NOT NULL,
member_show_names BOOL NOT NULL,
placeholder_name varchar(15) default 'xxxxx',
paypal BOOL NOT NULL,
standard_konto int(11) default '1',
version VARCHAR(20) NOT NULL,
PRIMARY KEY  (id)
)ENGINE=MyISAM;";

$inf_newtable[6] = DB_CCP_PAYPAL . " (
id int(11) NOT NULL auto_increment,
name varchar(32) default NULL,
subtype varchar(32) default NULL,
value decimal(8,2) NOT NULL default '10.00',
PRIMARY KEY  (id)
) ENGINE=MyISAM;";

$inf_altertable[1] = DB_CCP_SETTINGS . "ADD
    member_show_names BOOL NOT NULL,
    placeholder_name varchar(15) default 'xxxxx',
    paypal BOOL NOT NULL,
    standard_konto int(11) default '1'
";
$inf_altertable[2] = DB_CCP_KONTEN . "ADD
    paypal_email varchar(200) NOT NULL,
    paypal_button varchar(200) NOT NULL,
    paypal_submit_button varchar(200) NOT NULL,
    paypal_cancel_url varchar(200) default NULL,
    paypal_thanks_url varchar(200) default NULL,
    paypal_beitrag_checked tinyint(2) NOT NULL default '1'
";

$inf_droptable[1] = DB_CCP_BUCHUNGEN;
$inf_droptable[2] = DB_CCP_BUDGET;
$inf_droptable[3] = DB_CCP_KATEGORIEN;
$inf_droptable[4] = DB_CCP_KONTEN;
$inf_droptable[5] = DB_CCP_SETTINGS;
$inf_droptable[6] = DB_CCP_PAYPAL;

$inf_insertdbrow[1] = DB_CCP_SETTINGS . " SET cashadmin_groupid='103', member_groupid='101', zeilen='15', waehrung='€', member_show_all='1', member_show_names='0', placeholder_name='xxxxx', paypal='1', version='" . $locale['ccp002'] . "'";

$inf_insertdbrow[2] = DB_CCP_KATEGORIEN . " VALUES ('1','" . $locale['ccp003'] . "')";  
$inf_insertdbrow[3] = DB_CCP_KATEGORIEN . " VALUES ('2','" . $locale['ccp004'] . "')";
$inf_insertdbrow[4] = DB_CCP_KATEGORIEN . " VALUES ('3','" . $locale['ccp005'] . "')";

$inf_insertdbrow[5] = DB_CCP_PAYPAL . " VALUES ('1','Betrag', '1', '5.00')";
$inf_insertdbrow[6] = DB_CCP_PAYPAL . " VALUES ('2','Betrag', '2', '10.00')";
$inf_insertdbrow[7] = DB_CCP_PAYPAL . " VALUES ('3','Betrag', '3', '15.00')";
$inf_insertdbrow[8] = DB_CCP_PAYPAL . " VALUES ('4','Betrag', '4', '20.00')";

$inf_adminpanel[1] = array(
    "title" => $locale['ccp000'],
    "image" => "ccp_admin_logo.gif",
    "panel" => "ccp_settings_panel.php",
    "rights" => "CCP"
);
?>
