<?php

/*+********************************************************************************
 * The content of this file is subject to the Reports 4 You license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 ********************************************************************************/

require_once('Smarty_setup.php');
require_once("data/Tracker.php");
require_once('include/logging.php');
require_once('include/utils/utils.php');
// ITS4YOU-CR SlOl 20.12.2010 R4U singlerow
require_once('modules/ITS4YouReports/ITS4YouReports.php');

//error_reporting(63);
//ini_set('display_errors', 1);
global $app_strings, $app_list_strings, $mod_strings;
// ITS4YOU-CR SlOl 20.12.2010 R4U singlerow
$current_module_strings = return_module_language($current_language, 'ITS4YouReports');

global $list_max_entries_per_page, $urlPrefix;

$log = LoggerManager::getLogger('report_type');

global $currentModule, $image_path, $theme;
$smarty_obj=new vtigerCRM_Smarty;
$smarty_obj->assign("MOD", $mod_strings);
$smarty_obj->assign("APP", $app_strings);
$smarty_obj->assign("IMAGE_PATH",$image_path);

$ITS4YouReports = ITS4YouReports::getStoredITS4YouReport();

$smarty_obj = $ITS4YouReports->getSelectedValuesToSmarty($smarty_obj,"ReportGrouping");

$smarty_obj->display(vtlib_getModuleTemplate($currentModule,"ReportGrouping.tpl"));
?>