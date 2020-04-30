<?php

/* +********************************************************************************
 * The content of this file is subject to the Reports 4 You license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 * ****************************************************************************** */

require_once('modules/ITS4YouReports/ITS4YouReports.php');
require_once('modules/ITS4YouReports/models/ITS4YouReportsListHeader.php');

Class ITS4YouReports_EditKeyMetricsRow_View extends Vtiger_Edit_View {

    function __construct() {
        parent::__construct();
    }

    public function checkPermission(Vtiger_Request $request) {
        $moduleName = $request->getModule();
        $moduleModel = ITS4YouReports_ITS4YouReports_Model::getInstance($moduleName);

        $currentUserPriviligesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
        if (!$currentUserPriviligesModel->hasModulePermission($moduleModel->getId())) {
            throw new AppException('LBL_PERMISSION_DENIED');
        }
        
        /*
        $record = $request->get('record');
        if ($record) {
            $reportModel = ITS4YouReports_Record_Model::getCleanInstance($record);
            if (!$reportModel->isEditable()) {
                throw new AppException('LBL_PERMISSION_DENIED');
            }
        }
        */
    }
    
    function preProcess(Vtiger_Request $request, $display=true) {

        parent::preProcess($request, false);
        $viewer = $this->getViewer($request);

        $kmNameRow = self::getKMRow($request);
        if (!empty($kmNameRow)) {
            $kmNameValue = $kmNameRow["name"];
            $kmsmcreatorid = $kmNameRow["smcreatorid"];
        }
        $viewer->assign("KM_ID", $request->get('km_id'));
        $viewer->assign("KM_NAME", $kmNameValue);
        $viewer->assign("KM_SMCREATOR", $kmsmcreatorid);

        if ($display) {
            $this->preProcessDisplay($request);
        }
    }

    /**
     * function to get Key Metric information by ID
     * @param Vtiger_Request $request
     *
     * @return array
     */
    private static function getKMRow(Vtiger_Request $request) {
        return ITS4YouReports_KeyMetricsRows_View::getKMRow($request);
    }

    public function process(Vtiger_Request $request) {
        
        $km_id = $request->get('km_id');
        if($km_id!=""){
            $mode = "SelectReport";
            $this->$mode($request);
        }else{
            $this->dieDuePermissions();
        }
    }
    
    private function dieDuePermissions(){
        throw new AppException('LBL_PERMISSION_DENIED');
    }
    
    function SelectReport(Vtiger_Request $request) {
        $adb = PearDatabase::getInstance();

        $viewer = $this->getViewer($request);

        $moduleName = $request->getModule();
        $km_id = $request->get('km_id');
        $viewer->assign('KM_ID', $km_id);
        $viewer->assign('METRICS_MODEL', ITS4YouReports_KeyMetrics_Model::getInstanceById($km_id));

        $id = $request->get('id');
        $viewer->assign('ID', $id);
        
        $search_params[][0] = array("reporttype","e","tabular");
        $reportsListArray = $cvListArray = array();
        $reportsList = ITS4YouReports::sgetRptsforFldr(false,false,$search_params);
        if(!empty($reportsList)){
            foreach($reportsList as $fi => $farray){
                $farray = $farray[0];
                $reportsListArray[$farray["foldername"]][$farray["reportid"]] = $farray["reportname"];
            }
        }

        // NEW /*
		$cvResult = ITS4YouReports_CVRecord_Helper::getAllByGroup();
		if(!empty($cvResult)) {
			foreach($cvResult as $cvType => $cvData) {
				foreach($cvData as $cvRecord) {
					//$cvRecord->get('cvid')
					$viewname = $cvRecord->get('viewname');
					if('All' !== $viewname) {
						$name = $cvRecord->get('entitytype');
						$cv_key = vtranslate($name,$name)." - ".vtranslate("LBL_VIEW_NAME");
		                $cvid = "cv_".$cvRecord->get('cvid');
		                $cvListArray[$cv_key][$cvid] = $viewname;
	                }
        		}
			}
			ksort($cvListArray);
		}
		// OLD 
		/*
		$cvResult = ITS4YouKeyMetrics_KeyMetrics_Action::getKeyMetricsCustomViewResult();
        
        if ($adb->num_rows($cvResult) > 0) {
            while ($cv_row = $adb->fetchByAssoc($cvResult)) {
                $cv_key = vtranslate($cv_row["entitytype"],$cv_row["entitytype"])." - ".vtranslate("LBL_VIEW_NAME");
                $cvid = "cv_".$cv_row["cvid"];
                $cvListArray[$cv_key][$cvid] = $cv_row["viewname"];
            }
        }
        /*
		*/
        $viewer->assign('reportsList', $reportsListArray);
        $viewer->assign('cvList', $cvListArray);
        
        $label = $reportid = $column_str = $col_options = $metrics_type = "";
        if($id!=""){
            $editResult = $adb->pquery("SELECT label, reportid, metrics_type, column_str FROM its4you_reports4you_key_metrics_rows WHERE km_id=? AND id=?",array($km_id,$id));
            if ($adb->num_rows($editResult) > 0) {
                $row = $adb->fetchByAssoc($editResult,0);
                $label = $row["label"];
                $reportid = $row["reportid"];
                $column_str = $row["column_str"];
                $metrics_type = $row["metrics_type"];
                
                $col_options = ITS4YouReports_Record_Model::getKeyMetricsColumnOptions($reportid);
            }
        }else{
            $reportid = $request->get('reportid');
        }
        $viewer->assign('label', $label);
        $viewer->assign('reportid', $reportid);
        $viewer->assign('column_str_value', $column_str);
        $viewer->assign('metrics_type', $metrics_type);

        $viewer->assign('col_options', $col_options);
        
        $viewer->view('KeyMetricsReportsType.tpl', $moduleName);
    }
    
    function editKeyMetricsRow(Vtiger_Request $request) {
        
    }

    /**
     * Function to get the list of Script models to be included
     * @param Vtiger_Request $request
     * @return <Array> - List of Vtiger_JsScript_Model instances
     */
    function getHeaderScripts(Vtiger_Request $request) {
        $layout = Vtiger_Viewer::getDefaultLayoutName();
        $headerScriptInstances = parent::getHeaderScripts($request);
        $moduleName = $request->getModule();

        $jsFileNames = array(
            "modules.Vtiger.resources.List",
            "modules.$moduleName.resources.List",
        );
        $jsFileNames[] = "modules.$moduleName.resources.KeyMetricsList";
        $jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
        $headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
        return $headerScriptInstances;
    }

}
