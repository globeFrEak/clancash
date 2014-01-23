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
require_once "../../maincore.php";
include INFUSIONS."clancash_panel/infusion_db.php";

$akt_jahr = date('Y');
$view_jahr = ($_GET['year'] ? $_GET['year'] : $akt_jahr);

$result = dbquery("SELECT SUM(valuta) AS total, monat FROM ".DB_CCP_BUCHUNGEN." WHERE jahr=$view_jahr AND valuta > 0 AND geloescht='0' GROUP BY monat ORDER BY monat ASC");    
$totalein = array_fill(0,12,0);

while ($db_total = dbarraynum($result))
{    
    $monat = $db_total[1] - 1;
    $totalein[$monat]= round($db_total[0],2);      
}

$result = dbquery("SELECT SUM(valuta) AS total, monat FROM ".DB_CCP_BUCHUNGEN." WHERE jahr=$view_jahr AND valuta < 0 AND geloescht='0' GROUP BY monat ORDER BY monat ASC");    
$totalaus = array_fill(0,12,0);

while ($db_total = dbarraynum($result))
{    
    $monat = $db_total[1] - 1;
    $totalaus[$monat]= round($db_total[0],2);      
}

// Library settings
 define("CLASS_PATH", INFUSIONS."clancash_panel/pChart/class");
 define("FONT_PATH", INFUSIONS."clancash_panel/pChart/fonts");

 // pChart library inclusions
 include(CLASS_PATH."/pData.class.php");
 include(CLASS_PATH."/pDraw.class.php");
 include(CLASS_PATH."/pImage.class.php");
 
 
 // Data object
 if (file_exists(INFUSIONS."clancash_panel/locale/".$settings['locale']."_graph.php")) {
    include INFUSIONS."clancash_panel/locale/".$settings['locale']."_graph.php";
} else {
    include INFUSIONS."clancash_panel/locale/English_graph.php";
} 
 

 // Create the pChart object 
 $myPicture = new pImage(700,230,$MyData);
 $myPicture->drawGradientArea(0,0,700,230,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100));
 $myPicture->drawGradientArea(0,0,700,230,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20));
 $myPicture->drawRectangle(0,0,699,229,array("R"=>0,"G"=>0,"B"=>0));
 $myPicture->setFontProperties(array("FontName"=>FONT_PATH."/pf_arma_five.ttf","FontSize"=>6));

 // Draw the scale  
 $myPicture->setGraphArea(50,30,680,200);
 $myPicture->drawScale(array("CycleBackground"=>TRUE,"DrawSubTicks"=>TRUE,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10));

 // Turn on shadow computing  
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

 // Draw the chart 
 $settings = array("Gradient"=>TRUE,"DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"DisplayR"=>255,"DisplayG"=>255,"DisplayB"=>255,"DisplayShadow"=>TRUE,"Surrounding"=>20,"InnerSurrounding"=>-20);
 $myPicture->drawBarChart($settings);

 // Write the chart legend 
 $myPicture->drawLegend(580,12,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));

 // Render the picture (choose the best way) 
 $myPicture->autoOutput(INFUSIONS."clancash_panel/pChart/cache/BarChart.png");
?>