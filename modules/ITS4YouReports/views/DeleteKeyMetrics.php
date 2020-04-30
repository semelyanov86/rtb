<?php

/*+********************************************************************************
 * The content of this file is subject to the Reports 4 You license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 ********************************************************************************/

class ITS4YouReports_DeleteKeyMetrics_View extends Vtiger_IndexAjax_View {

	public function checkPermission(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$moduleModel = ITS4YouReports_Module_Model::getInstance($moduleName);

		$currentUserPriviligesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		if(!$currentUserPriviligesModel->hasModulePermission($moduleModel->getId())) {
			throw new AppException('LBL_PERMISSION_DENIED');
		}
	}

	public function process (Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$KeyMetricsId = $request->get('id');
        if($KeyMetricsId!=""){
            $KeyMetricsModel = ITS4YouReports_KeyMetrics_Model::getInstanceById($KeyMetricsId);
            $KeyMetricsModel->delete();
            
            $result = array('success' => true, 'message' => vtranslate('LBL_KeyMetrics_DELETED', $moduleName), 'info' => array());
            $response = new Vtiger_Response();
    		$response->setResult($result);
    		$response->emit();
        }
	}
}