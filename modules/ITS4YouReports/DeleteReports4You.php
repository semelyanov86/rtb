<?php

/*+********************************************************************************
 * The content of this file is subject to the Reports 4 You license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 ********************************************************************************/

require_once('modules/ITS4YouReports/ITS4YouReports.php');

$ITS4YouReports = new ITS4YouReports();

if(isset($_REQUEST['idlist']) && $_REQUEST['idlist']!=""){
    if ($ITS4YouReports->CheckPermissions("DELETE") == false){
        $ITS4YouReports->DieDuePermission();
    }

    $id_array = array();
    $idlist = trim($_REQUEST['idlist'],";");
    $id_array = explode(";", $idlist);

    for ($i = 0; $i < count($id_array); $i++) {
        $ITS4YouReports->deleteReports4You($id_array[$i]);
    }
}elseif(isset($_REQUEST['record']) && $_REQUEST['record']!=""){
    $recordid = vtlib_purify($_REQUEST['record']);
	$r_permitted = $ITS4YouReports->CheckReportPermissions($ITS4YouReports->primarymodule, $ITS4YouReports->record);
	$ITS4YouReports->deleteSingleReports4You();
}
header("Location:index.php?module=ITS4YouReports&action=index&parenttab=Tools");
exit;
