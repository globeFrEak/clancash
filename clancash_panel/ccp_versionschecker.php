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
function cURLcheck() {
    if (function_exists("curl_exec"))
        return "curl";
    elseif (file_get_contents(__FILE__))
        return "file_get";
    else
        return false;
}

function getTag($use, $url) {
    if ($use === "curl") {
        $ch = curl_init();
        $timeout = 5; // 0 wenn kein Timeout
        $t_vers = curl_version();
        curl_setopt($ch, CURLOPT_USERAGENT, 'curl/' . $t_vers['version']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $file_content = curl_exec($ch);
        curl_close($ch);
        return $file_content = json_decode($file_content, true);
    } elseif ($use === "file_get") {
        $url = "https://api.github.com/repos/globeFrEak/clancash/releases";
        $options = array('http' => array('user_agent' => $_SERVER['HTTP_USER_AGENT']));
        $context = stream_context_create($options);
        $file_content = file_get_contents($url, false, $context);
        return $file_content = json_decode($file_content, true);
    }
}

if (cURLcheck()) {
    $url = "https://api.github.com/repos/globeFrEak/clancash/releases";
    //echo cURLcheck(); 					// Ausgabe des cURLcheck
    //echo "<br>";							// Ausgabe Zeilenumbruch
    $file_content = getTag(cURLcheck(), $url);
    $new_version = $file_content['0']['tag_name'];
    //echo $file_content['0']['tag_name']; // Ausgabe der Versionsnummer
}
?>