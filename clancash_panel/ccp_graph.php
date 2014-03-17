<?php

/* --------------------------------------------------------------+
  | PHP-Fusion 7 Content Management System             		|
  +--------------------------------------------------------------+
  | Copyright © 2002 - 2013 Nick Jones                 		|
  | http://www.php-fusion.co.uk/                       		|
  +--------------------------------------------------------------+
  | Infusion: ClanCash                                 		|
  | Author:                                            		|
  | RedDragon(v6) 	    http://www.efc-funclan.de      	|
  | globeFrEak (v7) 		http://www.cwclan.de           	|
  | GUL-Sonic (v7.02)	http://www.germanys-united-legends.de 	|
  +--------------------------------------------------------------+
  | This program is released as free software under the		|
  | Affero GPL license. You can redistribute it and/or		|
  | modify it under the terms of this license which you		|
  | can read by viewing the included agpl.txt or online		|
  | at www.gnu.org/licenses/agpl.html. Removal of this		|
  | copyright header is strictly prohibited without		|
  | written permission from the original author(s).		|
  +-------------------------------------------------------------- */
if (!defined("IN_FUSION") || !IN_FUSION)
    die("Access denied!");

add_to_head("<script src='" . INFUSIONS . "clancash_panel/graph/jquery.jqplot.min.js'></script>");
add_to_head("<script src='" . INFUSIONS . "clancash_panel/graph/jqplot.barRenderer.min.js'></script>");
add_to_head("<script src='" . INFUSIONS . "clancash_panel/graph/jqplot.categoryAxisRenderer.min.js'></script>");
add_to_head("<script src='" . INFUSIONS . "clancash_panel/graph/jqplot.highlighter.min.js'></script>");

$view_jahr = (isset($_POST['filter_jahr'])) && $_POST['filter_jahr'] != 'all' ? $_POST['filter_jahr'] : date('Y');

// Einnahmen pro Monat
$result = dbquery("SELECT SUM(valuta) AS total, monat FROM " . DB_CCP_BUCHUNGEN . " WHERE jahr=$view_jahr AND valuta > 0 AND geloescht='0' GROUP BY monat ORDER BY monat ASC");
$totalein = array_fill(0, 12, 0);

while ($db_total = dbarraynum($result)) {
    $monat = $db_total[1] - 1;
    $totalein[$monat] = round($db_total[0], 2);
}
$totalein_json = json_encode($totalein);

// Ausgaben pro Monat
$result = dbquery("SELECT SUM(valuta) AS total, monat FROM " . DB_CCP_BUCHUNGEN . " WHERE jahr=$view_jahr AND valuta < 0 AND geloescht='0' GROUP BY monat ORDER BY monat ASC");
$totalaus = array_fill(0, 12, 0);

while ($db_total = dbarraynum($result)) {
    $monat = $db_total[1] - 1;
    $totalaus[$monat] = round($db_total[0], 2);
}
$totalaus_json = json_encode($totalaus);

// Monats Kalkulation abzueglich der Ausgaben
$totalmonat = array_fill(0, 12, 0);
for ($m = 0; $m < 11; $m++) {
    if ($totalein[$m] === 0) {
        $totalmonat[$m] = $totalaus[$m];
    } elseif ($totalaus[$m] === 0) {
        $totalmonat[$m] = $totalein[$m];
    } else {
        $totalmonat[$m] = round($totalein[$m] - abs($totalaus[$m]), 2);
    }
}
$totalmonat_json = json_encode($totalmonat);

// Graph definition als Javascript
add_to_footer("<script type='text/javascript'>
$(document).ready(function(){
    var s1 = " . $totalein_json . ";
    var s2 = " . $totalaus_json . ";
    var m1 = " . $totalmonat_json . ";
    
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
    
    var plot1 = $.jqplot('box_graph', [s1, s2], { 
        title: '" . $locale['ccp_graph_title'] . $view_jahr . "',
        stackSeries: true, 
        seriesColors:['#089629', '#980F0F'],
        seriesDefaults:{        
            renderer:$.jqplot.BarRenderer,
            rendererOptions: {fillToZero: true,varyBarColor: true},            
        },          
        series:[            
            {label:'" . $locale['ccp004'] . "'},
            {label:'" . $locale['ccp005'] . "', useNegativeColors: false}
        ],        
        legend: {
            show: false,
            location: 'sw',
            placement: 'insideGrid',
            border: 'border:none;'
        },
        highlighter: {
            show: true,
            tooltipLocation: 'n',
            tooltipAxes: 'y',            
            bringSeriesToFront: true,
            tooltipOffset: 9
        },
        axes: {            
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                ticks: ticks
            },           
            yaxis: {                
                tickOptions: {formatString: '%#.2f " . $set_symbol . "'}
            }
        }
    });
    
    var plot2 = $.jqplot('box_graph_2', [m1], { 
        title: '" . $locale['ccp_graph_title'] . $view_jahr . "',
        stackSeries: true, 
        seriesColors:['#089629'],
        negativeSeriesColors: ['#980F0F'],
        seriesDefaults:{        
            renderer:$.jqplot.BarRenderer,
            rendererOptions: {fillToZero: true,varyBarColor: true},            
        },          
        series:[            
            {label:'" . $locale['ccp004'] . "'}            
        ],        
        legend: {
            show: false,
            location: 'sw',
            placement: 'insideGrid',
            border: 'border:none;'
        },
        highlighter: {
            show: true,
            tooltipLocation: 'n',
            tooltipAxes: 'y',            
            bringSeriesToFront: true,
            tooltipOffset: 9
        },
        axes: {            
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                ticks: ticks
            },           
            yaxis: {                
                tickOptions: {formatString: '%#.2f " . $set_symbol . "'}
            }
        }
    });
});
</script>");
?>