<?php
// Create and populate the pData object
 $MyData = new pData();  
 $MyData->addPoints($totalein,"Einnahmen");
 $MyData->addPoints($totalaus,"Ausgaben"); 
 $MyData->setAxisName(0,"Ein-/Ausgaben");
 $MyData->addPoints(array('Januar','Februar','März','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember'),"Monate");
 $MyData->setSerieDescription("Monate","Monat");
 $MyData->setAbscissa("Monate");
?>
