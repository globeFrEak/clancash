<?php

/* --------------------------------------------------------------+
  | PHP-Fusion 7 Content Management System             			|
  +--------------------------------------------------------------+
  | Copyright © 2002 - 2013 Nick Jones                 			|
  | http://www.php-fusion.co.uk/                       			|
  +--------------------------------------------------------------+
  | Infusion: ClanCash                                 			|
  | Filename: ccp_graph.php                      			|
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
  +-------------------------------------------------------------- */
require_once "../../../maincore.php";
require_once THEMES . "templates/header.php";
include INFUSIONS . "clancash_panel/infusion_db.php";

add_to_head("<link rel='stylesheet' type='text/css' href='" . INFUSIONS . "clancash_panel/graph/jquery.jqplot.min.css'>");
add_to_head("<script src='" . INFUSIONS . "clancash_panel/graph/jquery.jqplot.min.js'></script>");
add_to_head("<script src='" . INFUSIONS . "clancash_panel/graph/jqplot.barRenderer.min.js'></script>");
add_to_head("<script src='" . INFUSIONS . "clancash_panel/graph/jqplot.categoryAxisRenderer.min.js'></script>");
add_to_head("<script src='" . INFUSIONS . "clancash_panel/graph/jqplot.highlighter.min.js'></script>");


add_to_head('<style type="text/css">
    .jqplot-highlighter-tooltip{font-size:1em;}
</style>');



if (file_exists(INFUSIONS . "clancash_panel/locale/" . $settings['locale'] . ".php")) {
    include INFUSIONS . "clancash_panel/locale/" . $settings['locale'] . ".php";
} else {
    include INFUSIONS . "clancash_panel/locale/English.php";
}

$akt_jahr = date('Y');
$view_jahr = ($_GET['year'] ? $_GET['year'] : $akt_jahr);

$result = dbquery("SELECT SUM(valuta) AS total, monat FROM " . DB_CCP_BUCHUNGEN . " WHERE jahr=$view_jahr AND valuta > 0 AND geloescht='0' GROUP BY monat ORDER BY monat ASC");
$totalein = array_fill(0, 12, 0);

while ($db_total = dbarraynum($result)) {
    $monat = $db_total[1] - 1;
    $totalein[$monat] = round($db_total[0], 2);    
}
$totalein = json_encode($totalein);

$result = dbquery("SELECT SUM(valuta) AS total, monat FROM " . DB_CCP_BUCHUNGEN . " WHERE jahr=$view_jahr AND valuta < 0 AND geloescht='0' GROUP BY monat ORDER BY monat ASC");
$totalaus = array_fill(0, 12, 0);

while ($db_total = dbarraynum($result)) {
    $monat = $db_total[1] - 1;    
    $totalaus[$monat] = round($db_total[0], 2);
}
$totalaus = json_encode($totalaus);
echo "<div id='chart'></div>";

add_to_head("<script class='code' type='text/javascript'>
$(document).ready(function(){
    var s1 = " . $totalein . ";
    var s2 = " . $totalaus . ";
    
    var ticks = ['" . $locale['ccp_jan'] . "',
        '" . $locale['ccp_feb'] . "',
        '" . $locale['ccp_mar'] . "', 
        '" . $locale['ccp_apr'] . "',
        '" . $locale['ccp_may'] . "',
        '" . $locale['ccp_jun'] . "',
        '" . $locale['ccp_jul'] . "',
        '" . $locale['ccp_aug'] . "',
        '" . $locale['ccp_sep'] . "',
        '" . $locale['ccp_okt'] . "',
        '" . $locale['ccp_nov'] . "',
        '" . $locale['ccp_dez'] . "']; 
    
    var plot1 = $.jqplot('chart', [s1, s2], {        
        stackSeries: true, 
        seriesColors:['#089629', '#980F0F'],
        seriesDefaults:{        
            renderer:$.jqplot.BarRenderer,
            rendererOptions: {fillToZero: true,varyBarColor: true},            
        },          
        series:[            
            {label:'Ein'},
            {label:'Aus', useNegativeColors: false}
        ],        
        legend: {
            show: true,
            location: 'e',
            placement: 'outsideGrid'
        },
        highlighter: {
            show: true,
            tooltipAxes: 'y',            
            bringSeriesToFront: true
        },
        axes: {            
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                ticks: ticks
            },           
            yaxis: {                
                tickOptions: {formatString: '€%d'}
            }
        }
    });
});
</script>");

require_once THEMES . "templates/footer.php";
?>