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
// Create and populate the pData object
 $MyData = new pData();  
 $MyData->addPoints($totalein,"Einnahmen");
 $MyData->addPoints($totalaus,"Ausgaben"); 
 $MyData->setAxisName(0,"Ein-/Ausgaben");
 $MyData->addPoints(array('Januar','Februar','März','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember'),"Monate");
 $MyData->setSerieDescription("Monate","Monat");
 $MyData->setAbscissa("Monate");
?>
