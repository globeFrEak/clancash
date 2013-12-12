<?php
$ch = curl_init();
$timeout = 5; // 0 wenn kein Timeout
$t_vers = curl_version();
curl_setopt($ch, CURLOPT_USERAGENT, 'curl/' . $t_vers['version']);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_URL, "https://api.github.com/repos/globeFrEak/clancash/releases");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$file_content = curl_exec($ch);
curl_close($ch);
$file_content = json_decode($file_content, true);
$version = $file_content['0']['tag_name'];

?>