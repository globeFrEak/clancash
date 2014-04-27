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

$view_jahr = (isset($_POST['filter_jahr'])) && $_POST['filter_jahr'] != 'all' ? mysql_real_escape_string($_POST['filter_jahr']) : date('Y');
$view_konto = (isset($_POST['filter_jahr'])) && $_POST['filter_konto'] != 'all' ? "AND konto_id = '" . mysql_real_escape_string($_POST['filter_konto']) . "'" : "";


//
// Übertrag aus Vorjahren
$result = dbquery("SELECT ROUND(SUM(valuta), 2) AS total FROM " . DB_CCP_BUCHUNGEN . " WHERE valuta IS NOT NULL AND jahr < $view_jahr AND geloescht='0' $view_konto");
if (dbrows($result) > 0) {
    $gesamt = dbarraynum($result);
    $uebertrag = (double) $gesamt[0];
} else {
    $uebertrag = (double) 0;
}

//
// Einnahmen pro Monat
$result = dbquery("SELECT SUM(valuta) AS total, monat FROM " . DB_CCP_BUCHUNGEN . " WHERE jahr=$view_jahr AND valuta > 0 AND geloescht='0' $view_konto GROUP BY monat ORDER BY monat ASC");
$totalein = array_fill(0, 12, 0);

while ($db_total = dbarraynum($result)) {
    $monat = $db_total[1] - 1;
    $totalein[$monat] = (double) $db_total[0];
}
//
// Ausgaben pro Monat
$result = dbquery("SELECT SUM(valuta) AS total, monat FROM " . DB_CCP_BUCHUNGEN . " WHERE jahr=$view_jahr AND valuta < 0 AND geloescht='0' $view_konto GROUP BY monat ORDER BY monat ASC");
$totalaus = array_fill(0, 12, 0);

while ($db_total = dbarraynum($result)) {
    $monat = $db_total[1] - 1;
    $totalaus[$monat] = (double) $db_total[0];
}
//
// Monats Kalkulation abzueglich der Ausgaben
if ($view_jahr == date('Y')){
    $monat = date('n');
    $for_monat = $monat - 1;
} else {
    $monat = 12;
    $for_monat = $monat - 1;
}
$totalmonat = array_fill(0, $monat, 0);
$ticksmonat = array_fill(0, $monat, 0);
for ($m = 0; $m <= $for_monat; $m++) {
    if ($totalein[$m] === 0) {
        $totalmonat[$m] = (double) $totalaus[$m];
    } elseif ($totalaus[$m] === 0) {
        $totalmonat[$m] = (double) $totalein[$m];
    } else {
        $totalmonat[$m] = round($totalein[$m] - abs($totalaus[$m]), 2);
    }
    // Addiere den Übertrag der Vorjahre auf den ersten Monat und Addiere den Übertrag Monat für Monat
    if ($m === 0) {
        $totalmonat[$m] = round($totalmonat[$m] + $uebertrag, 2);
    } else {
        $i = $m - 1;
        $totalmonat[$m] = round($totalmonat[$m] + $totalmonat[$i], 2);
    }    
    $totalaus[$m] = round($totalaus[$m], 2);
    $totalein[$m] = round($totalein[$m], 2);
    // erzeuge die Monate aus der locales
    $mon = $m + 1;
    $ticksmonat[$m] = $locale['ccp_monat_'."$mon"];
}
//
// Arrays in JSON Enkodieren
$totalein_json = json_encode($totalein);
$totalaus_json = json_encode($totalaus);
$totalmonat_json = json_encode($totalmonat);
$ticksmonat_json = json_encode($ticksmonat);

// Graph definition als Javascript
add_to_footer("<script type='text/javascript'>
$(document).ready(function(){
    var s1 = " . $totalein_json . ";
    var s2 = " . $totalaus_json . ";
    var m1 = " . $totalmonat_json . "; 
    var m_ticks = " . $ticksmonat_json . ";
    
    var ticks = ['" . $locale['ccp_monat_1'] . "',
        '" . $locale['ccp_monat_2'] . "',
        '" . $locale['ccp_monat_3'] . "', 
        '" . $locale['ccp_monat_4'] . "',
        '" . $locale['ccp_monat_5'] . "',
        '" . $locale['ccp_monat_6'] . "',
        '" . $locale['ccp_monat_7'] . "',
        '" . $locale['ccp_monat_8'] . "',
        '" . $locale['ccp_monat_9'] . "',
        '" . $locale['ccp_monat_10'] . "',
        '" . $locale['ccp_monat_11'] . "',
        '" . $locale['ccp_monat_12'] . "'];
            
    $.jqplot.sprintf.thousandsSeparator = '" . $locale['ccp007'] . "';
    $.jqplot.sprintf.decimalMark = '" . $locale['ccp006'] . "';
    
    plot1 = $.jqplot('box_graph', [s1, s2], { 
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
            showMarker: false,
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
                tickOptions: {formatString: '%\'.2f " . $set_symbol . "'}
            }
        },
        grid: {
            background: 'transparent'
        }
    });
    
    plot2 = $.jqplot('box_graph_2', [m1], { 
        title: '" . $locale['ccp_graph2_title'] . $view_jahr . " (" . $locale['ccp_graph2_uebertrag'] . $uebertrag . "&nbsp;" . $set_symbol . ")',
        stackSeries: true, 
        seriesColors:['#089629'],
        negativeSeriesColors: ['#980F0F'],
        seriesDefaults:{
            renderer:$.jqplot.BarRenderer,
            rendererOptions: {fillToZero: true, varyBarColor: true},
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
            showMarker: false,
            tooltipLocation: 'n',
            tooltipAxes: 'y',
            bringSeriesToFront: true,
            tooltipOffset: 9
        },
        axes: {
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                ticks: m_ticks
            },
            yaxis: {
                tickOptions: {formatString: '%\'.2f " . $set_symbol . "'}
            }
        },
        grid: {
            background: 'transparent'
        }
    });
});

$(window).resize(function() {
    $.each(plot1.series, function(index, series) {series.barWidth = undefined;});
    plot1.replot( {resetAxes: true } );
    $.each(plot2.series, function(index, series) {series.barWidth = undefined;});
    plot2.replot( {resetAxes: true } );        
});

</script>");
?>