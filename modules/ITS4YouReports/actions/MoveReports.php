<?php

/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class ITS4YouReports_MoveReports_Action extends Vtiger_Mass_Action {

    public function checkPermission(Vtiger_Request $request) {
        $moduleName = $request->getModule();
        $moduleModel = ITS4YouReports_Module_Model::getInstance($moduleName);

        $currentUserPriviligesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
        if (!$currentUserPriviligesModel->hasModulePermission($moduleModel->getId())) {
            throw new AppException(vtranslate('LBL_PERMISSION_DENIED'));
        }
    }

    public function process(Vtiger_Request $request) {

        $parentModule = $request->getModule();
        $reportIdsList = ITS4YouReports_Record_Model::getRecordsListFromRequest($request);
        $folderId = $request->get('folderid');
        $viewname = $request->get('viewname');
        if ($folderId == $viewname) {
            $sameTargetFolder = 1;
        }
        if (!empty ($reportIdsList)) {
            foreach ($reportIdsList as $reportId) {
                $reportModel = ITS4YouReports_Record_Model::getInstanceById($reportId);
                if (!$reportModel->isDefault() && $reportModel->isEditable()) {
                    $reportModel->move($folderId);
                } else {
                    $reportsMoveDenied[] = vtranslate($reportModel->getName(), $parentModule);
                }
            }
        }
        $response = new Vtiger_Response();
        if ($sameTargetFolder) {
            $result = ['success' => false, 'message' => vtranslate('LBL_SAME_SOURCE_AND_TARGET_FOLDER', $parentModule)];
        } else if (empty ($reportsMoveDenied)) {
            $result = ['success' => true, 'message' => vtranslate('LBL_REPORTS_MOVED_SUCCESSFULLY', $parentModule)];
        } else {
            $result = ['success' => false, 'message' => vtranslate('LBL_DENIED_REPORTS', $parentModule), 'denied' => $reportsMoveDenied];
        }
        $response->setResult($result);
        $response->emit();
    }
}