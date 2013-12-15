<?php
/* ---------------------------------------------------+
  | PHP-Fusion 7 Content Management System
  +----------------------------------------------------+
  | Copyright © 2002 - 2013 Nick Jones
  | http://www.php-fusion.co.uk/
  |----------------------------------------------------+
  | Infusion: ClanCash
  | Filename: ccp_admin_panel.php
  | Author:
  | RedDragon(v6) 	    http://www.efc-funclan.de
  | globeFrEak (v7) 	http://www.cwclan.de
  | Sonic (v7.02)		http://www.germanys-united-legends.de
  +----------------------------------------------------+
  | This program is released as free software under the
  | Affero GPL license. You can redistribute it and/or
  | modify it under the terms of this license which you
  | can read by viewing the included agpl.txt or online
  | at www.gnu.org/licenses/agpl.html. Removal of this
  | copyright header is strictly prohibited without
  | written permission from the original author(s).
  +---------------------------------------------------- */

if (!checkrights("CCP") || !defined("iAUTH") || !isset($_GET['aid']) || $_GET['aid'] != iAUTH) redirect("../../login.php");

switch ($ccp_config['version']): 

	case false:
	echo "<tr><td colspan='4' class='tbl1'><a href='".INFUSIONS."clancash_panel/update/update_from_v1.2.php".$aidlink."'>".$locale['ccp306'].": 1.2 => 1.3</a></td></tr>";
	break;
	
	default :
	$uptodate = 1;
	
endswitch;

?>