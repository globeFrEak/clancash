/*=============================================================*\   
|| ########################################################### ||   
|| #        BS-Fusion - Content Management System            # ||   
|| #                    Version 1.x                          # ||   
|| # ------------------------------------------------------- # ||   
|| # Copyright ©2009 BS-Fusion All rights reserved.          # ||   
|| # Author: Manuel Kurz                                     # ||   
|| # ------------------------------------------------------- # ||   
|| # This program is released as open source software under  # ||   
|| # the Affero GPL license (version 3).                     # ||   
|| # License: http://www.gnu.org/licenses/agpl-3.0.html.     # ||   
|| # Removal of this copyright header is strictly prohibited # ||   
|| # without written permission from the original author(s). # ||   
|| # -------- BS-FUSION IS AN OPEN SOURCE SOFTWARE --------- # ||   
|| #    http://www.bs-fusion.de | http://www.bsfusion.de     # ||   
|| # ------------------------------------------------------- # ||   
|| # Infusion: Clankasse                                     # ||   
|| # Version: 1.2                                            # ||   
|| # Autor: RedDragon                                        # ||
|| # Homepage: http://www.bs-fusion.de                       # ||
|| #                                                         # ||
|| # Umgeschrieben auf PHP-Fusion 7.x von globeFrEak         # ||
|| # Homepage: http://www.cwclan.de                          # || 
|| # Email: globefreak@cwclan.de                             # ||
|| #                                                         # ||
|| # Überarbeitet für PHP-Fusion 7.02 von Sonic              # ||
|| # Homepage: http://www.germanys-united-legends.de         # ||
|| #                                                         # ||     
|| # File: readme.txt                                        # ||   
|| ########################################################### ||   
\*=============================================================*/   

Installation:
-Kopiere den kompletten Inhalt in den Infusions Ordner
-Installiere die Infusion
-Erstelle mindestens zwei Benutzergruppen 
-->Gruppe der Beitragszahler oder die, die Zahlungen sehen dürfen
-->Gruppe von Kassenwarten, die Zahlungen tätigen dürfen (brauch keinen Admin-Status zu haben)
-Aktiviere das clancash_panel über die Panel Administration
-->Die Gruppe bestimmt die Sichtbarkeit, wie üblich
-->Details sind nur den Beitragszahlern und Kassenwarten/Superadmins zugänglich

Module:
Buchungen - Erstellen/Löschen und Editieren von Buchungsvorgängen (Zugang: Kassenwart : Superadmin)
-->Kotokontakt - Anzeige der angelegten Konten
-->Beitragsübersicht - Anzeige von Buchungen, die einem Beitragszahler zugeordnet sind
Kategorien - Zuordnung von Buchungen (Zugang: Kassenwart : Superadmin)
Konten - Erstellen/Löschen und Editieren von Konten (Zugang: Kassenwart : Superadmin)
Budgetplanung - Planung von Zahlungsvorgängen (Zugang: Kassenwart : Superadmin)
Einstellungen - Übergeordnet (Zugang: Admin mit InfusionPanel : Superadmin)

Einstellungen:
-Wechsle zu den Einstellungen im Clankassen Admin Panel
-->Weise die Gruppen der Kassenadmin zu
-->Weise die Gruppen der Beitragszahler zu
-->Dargestelle Buchungen in Zeilen auf der Buchungsseite
-->Angabe der lokalen Währung
-->Checkbox, ob die Beitragszahler aller Buchungen sehen dürfen,
oder ob sie nur allgeimene und ihre eigenen sehen dürfen.

Konten:
-Lege ein oder mehrere Konten für Zahlungsvorgänge an

Kategorien:
-Lege eine oder mehrere Kategorien für Buchungszuweisungen an

Buchungen:
Nun können Buchungen angelegt werden. Die Filterfunktion ist für Beitragszahler
nur eingeschränkt nutzbar. 
Filter für Beitragszahler
-Monat
-Jahr
zusätzlich für Kassenwarte & Superadmins
-Beitragszahler
-Konto
-Kategorie

Budgetplanug:
Hier können Ein.- und Ausgaben geplant werden.