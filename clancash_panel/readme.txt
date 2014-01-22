 +--------------------------------------------------------------+
 | PHP-Fusion 7 Content Management System             		|
 +--------------------------------------------------------------+
 | Copyright © 2002 - 2013 Nick Jones                 		|
 | http://www.php-fusion.co.uk/                       		|
 +--------------------------------------------------------------+
 | Infusion: ClanCash                                 		|
 | Filename: ccp_admin_panel.php                      		|
 | Author:                                            		|
 | RedDragon(v6) 	http://www.efc-funclan.de      		|
 | globeFrEak (v7) 	http://www.cwclan.de           		|
 | GUL-Sonic (v7.02)	http://www.germanys-united-legends.de 	|
 +--------------------------------------------------------------+
 | This program is released as free software under the		|
 | Affero GPL license. You can redistribute it and/or		|
 | modify it under the terms of this license which you		|
 | can read by viewing the included agpl.txt or online		|
 | at www.gnu.org/licenses/agpl.html. Removal of this		|
 | copyright header is strictly prohibited without		|
 | written permission from the original author(s).		|
 +--------------------------------------------------------------+

Installation:
-Kopiere den kompletten Inhalt in den Infusions Ordner
-Installiere die Infusion
-Erstelle mindestens zwei Benutzergruppen 
-->Gruppe der Beitragszahler oder die, die Zahlungen sehen dürfen
-->Gruppe von Kassenwarten, die Zahlungen tätigen dürfen (brauch keinen Admin-Status zu haben)
-Aktiviere das clancash_panel über die Panel Administration
-->Die Gruppe bestimmt die Sichtbarkeit, wie üblich
-->Details sind nur den Beitragszahlern und Kassenwarten/Superadmins zugänglich

Update:
von v1.2 --> v1.3
- Kopiere den kompletten Inhalt in den Infusions Ordner
- Gehe in das Adminmenü der ClanKasse unter Einstellungen und klicke auf den Link: "Datenbank-Update verfügbar".

von v1.3 --> v1.4
- Kopiere den kompletten Inhalt in den Infusions Ordner
- Gehe in das Adminmenü der ClanKasse unter Einstellungen und klicke auf den Link: "Datenbank-Update verfügbar".

Hinweis: Während des Updates könnten einige "Fehler" in den Fehlerlog von php-fusion geschrieben werden, diese können nach erfolgtem Update gelöscht werden und treten nicht erneut auf! 

Module:
Buchungen - Erstellen/Löschen und Editieren von Buchungsvorgängen (Zugang: Kassenwart : Superadmin)
-->Kotokontakt - Anzeige der angelegten Konten
-->Beitragsübersicht - Anzeige von Buchungen, die einem Beitragszahler zugeordnet sind
Kategorien - Zuordnung von Buchungen (Zugang: Kassenwart : Superadmin)
Konten - Erstellen/Löschen und Editieren von Konten (Zugang: Kassenwart : Superadmin)
Budgetplanung - Planung von Zahlungsvorgängen (Zugang: Kassenwart : Superadmin)
Einstellungen - Übergeordnet (Zugang: Admin mit InfusionPanel : Superadmin)

Buchungen:
Die Filterfunktion ist für Beitragszahler
nur eingeschränkt nutzbar. 
Filter für Beitragszahler:
-Monat
-Jahr
zusätzlich für Kassenwarte & Superadmins:
Anlegen von Buchungen
-Datum der Buchung
-Kategorie (Einzahlung / Auszahlung)
-Buchungsbetrag
-Kommentar (optional)
-Konto
-Mitgliedsname für diese Buchung

Kategorien:
-Lege eine oder mehrere Kategorien für Buchungszuweisungen an

Konten:
-Lege ein oder mehrere Konten für Zahlungsvorgänge an
-Paypalfunktion optional nutzbar !!!Achtung!!! Paypal ist nur für das Standardkonto aktiv!

Budgetplanug:
Hier können Ein.- und Ausgaben geplant werden.

Einstellungen:
-->Weise die Gruppen der Kassenadmin zu
-->Weise die Gruppen der Beitragszahler zu
-->Dargestelle Buchungen in Zeilen auf der Buchungsseite
-->Angabe der lokalen Währung
-->Checkbox, ob die Beitragszahler aller Buchungen sehen dürfen,
   oder ob sie nur allgeimene und ihre eigenen sehen dürfen.
-->Bei Verwendung mehrerer Konten Wahl des Standardkontos (für Paypalzahlungen)
-->Paypal-Funktion aktivieren
-->Auswahl ob die Buchungen für alle Mitglieder sichtbar sind -> wenn ja ->
-->Auswahl ob die Benutzernamen der Beitragszahler angezeigt werden sollen -> wenn nein ->
-->Auswahl was anstelle der Benutzernamen angezeigt werden soll Standard = "XXXXX"
