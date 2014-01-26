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
// Infusion titles & description

$locale['ccp000'] = "ClanCash";
$locale['ccp001'] = "Panel f&uuml;r die Verwaltung der Clan- oder Vereins-kasse.";
$locale['ccp002'] = "1.4";
$locale['ccp003'] = "Spenden";
$locale['ccp004'] = "Einnahmen";
$locale['ccp005'] = "Ausgaben";

$locale['ccp100'] = "Verwaltung";
$locale['ccp101'] = "Datum";
$locale['ccp102'] = "Kategorie";
$locale['ccp103'] = "Bitte w&auml;hlen";
$locale['ccp104'] = "Betrag";
$locale['ccp105'] = "Kategorie";
$locale['ccp106'] = "Konto";
$locale['ccp107'] = "Mitglied";
$locale['ccp108'] = "Speichern";
$locale['ccp109'] = "Neu";
$locale['ccp110'] = "hinzuf&uuml;gen";
$locale['ccp111'] = "Felder mit <span style='color:red;'>*</span> m&uuml;ssen ausgef&uuml;llt werden!";
$locale['ccp112'] = "Buchung wurde gel&ouml;scht!";
$locale['ccp113'] = "Bearbeiten";
$locale['ccp114'] = "L&ouml;schen";
$locale['ccp115'] = "Budgetplanung";
$locale['ccp116'] = "Anzahl";
$locale['ccp117'] = "Ist Einnahme";
$locale['ccp118'] = "Ist Ausgabe";
$locale['ccp119'] = "Zahlungsart";
$locale['ccp120'] = "t&auml;glich";
$locale['ccp121'] = "monatlich";
$locale['ccp122'] = "Quartal";
$locale['ccp123'] = "halbjahr";
$locale['ccp124'] = "j&auml;hrlich";
$locale['ccp125'] = "Monat";
$locale['ccp126'] = "Jahr";
$locale['ccp127'] = "Kategorien";
$locale['ccp128'] = "Alle";
$locale['ccp129'] = "Filter aus";
$locale['ccp130'] = "Gespeichert!";
$locale['ccp131'] = "Gel&ouml;scht!";
$locale['ccp132'] = "Nicht gespeichert!<br>Daten nicht vollst&auml;ndig!";
$locale['ccp133'] = "Keine Eintr&auml;ge vorhanden!";
$locale['ccp134'] = "L&ouml;schen nicht m&ouml;glich!<br>Konto wird noch ben&ouml;tigt!";
$locale['ccp135'] = "Konten";
$locale['ccp136'] = "Kontoname";
$locale['ccp137'] = "Kontoinhaber";
$locale['ccp138'] = "Kontonummer";
$locale['ccp139'] = "Bankleitzahl";
$locale['ccp140'] = "Name der Bank";
$locale['ccp141'] = "IBAN";
$locale['ccp142'] = "SWIFT/BIC";
$locale['ccp143'] = "Buchungen";
$locale['ccp144'] = "Budgetplanung";
$locale['ccp145'] = "Einstellungen";
$locale['ccp146'] = "Es wurden noch keine Gruppen festgelegt!";
$locale['ccp147'] = "Gruppe der Kassenadminis";
$locale['ccp148'] = "Gruppe der Mitglieder";
$locale['ccp149'] = "Dargestellte Buchungen";
$locale['ccp150'] = "Lokale W&auml;hrung";
$locale['ccp151'] = "Kontokontakt";
$locale['ccp152'] = "Kontostand";
$locale['ccp153'] = "Klick f&uuml;r Details";
$locale['ccp154'] = "Navigation";
$locale['ccp155'] = "Kommentar";
$locale['ccp156'] = "Verwendungszweck";
$locale['ccp157'] = "Nicht gespeichert!<br>Eintrag ist schon vorhanden.";
$locale['ccp158'] = "Beitrags&uuml;bersicht";
$locale['ccp159'] = "Buchungen sichtbar";
$locale['ccp160'] = "entg&uuml;ltig L&ouml;schen";
$locale['ccp161'] = "Einnahmen/Ausgaben";
$locale['ccp162'] = "Du musst eingelogt sein um weitere Details angezeigt zu bekommen";

$locale['ccp180'] = "Namen sichtbar";
$locale['ccp181'] = "Anzeige wenn 'Namen sichtbar' deaktiviert' ist";
$locale['ccp182'] = "Paypal-Funktion aktivieren?";
$locale['ccp183'] = "Paypal-Emailadresse";
$locale['ccp184'] = "Paypal-Button";
$locale['ccp185'] = "Paypal-Submit-Button";
$locale['ccp186'] = "Paypal-Abbruch-URL";
$locale['ccp187'] = "Paypal-Best&auml;tigungs-URL";
$locale['ccp188'] = "Paypal-Einstellungen";
$locale['ccp189'] = "Standardbetrag w&auml;hlen";
$locale['ccp190'] = "Beitragsverwaltung";
$locale['ccp191'] = "Beitragsh&ouml;he angeben Bsp: 10.00";
$locale['ccp192'] = "Die Adresse muss mit  http://...  beginnen";
$locale['ccp193'] = "Nummer";
$locale['ccp194'] = "Betrag";
$locale['ccp195'] = "Bezeichnung";
$locale['ccp196'] = "Zahlung per Paypal";
$locale['ccp197'] = "Betrag ausw&auml;hlen und fortfahren";
$locale['ccp198'] = "Clanbeitrag";
$locale['ccp199'] = "Fehler";
$locale['ccp200'] = "Paypal-Konto konnte nicht erkannt werden!";
$locale['ccp201'] = "Paypal-Email wurde falsch oder nicht vollständig eingegeben!";

$locale['ccp250'] = "Standard Konto";
$locale['ccp251'] = "kein Konto gefunden!";

$locale['ccp300'] = "Versionspr&uuml;fung";
$locale['ccp301'] = "Aktuellste Version";
$locale['ccp302'] = "Installierte Version";
$locale['ccp303'] = "Ihre Version der ClanKasse ist die aktuelle Version";
$locale['ccp304'] = "Downloadlink";
$locale['ccp305'] = "Die automatische Versionspr&uuml;fung ist zur Zeit nicht m&ouml;glich!<br>Bitte klicken Sie auf den nachfolgenden Link um eine manuelle Versionspr&uuml;fung durchzuf&uuml;hren";
$locale['ccp306'] = "Datenbank-Update verf&uuml;gbar";
$locale['ccp307'] = "OK";
$locale['ccp308'] = "Fehler";
$locale['ccp309'] = "Es sind Fehler w&auml;hrend des Update-Vorgangs aufgetreten";
$locale['ccp310'] = "Update erfolgreich";
$locale['ccp311'] = "zur&uuml;ck";
$locale['ccp312'] = "Aktuellste Version auf github.com";

$locale['ccp999'] = "Wirklich löschen?";

$locale['ccp_a000'] = "ClanKasse - Administration";

$locale['ccp_graph_title'] = "Ein-/Ausgaben für das Jahr ";
$locale['ccp_jan'] = "Januar";
$locale['ccp_feb'] = "Februar";
$locale['ccp_mar'] = "M&auml;rz";
$locale['ccp_apr'] = "April";
$locale['ccp_may'] = "Mai";
$locale['ccp_jun'] = "Juni";
$locale['ccp_jul'] = "Juli";
$locale['ccp_aug'] = "August";
$locale['ccp_sep'] = "September";
$locale['ccp_okt'] = "Oktober";
$locale['ccp_nov'] = "November";
$locale['ccp_dez'] = "Dezember";
?>
