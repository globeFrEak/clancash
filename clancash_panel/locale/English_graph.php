<?php
// Create and populate the pData object
 $MyData = new pData(); 
 $MyData->addPoints($totalein,"income");
 $MyData->addPoints($totalaus,"to spend"); 
 $MyData->setAxisName(0,"income/expenditure");
 $MyData->addPoints(array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sept','Oct','Nov','Dec'),"months");
 $MyData->setSerieDescription("months","month");
 $MyData->setAbscissa("months");
?>
