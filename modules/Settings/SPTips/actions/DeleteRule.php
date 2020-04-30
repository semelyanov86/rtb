<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: SalesPlatform Ltd
 * The Initial Developer of the Original Code is SalesPlatform Ltd.
 * All Rights Reserved.
 * If you have any questions or comments, please email: devel@salesplatform.ru
 ************************************************************************************/

class Settings_SPTips_DeleteRule_Action extends Settings_Vtiger_Index_Action {
    
    public function process (Vtiger_Request $request) {
        $ruleModel = Settings_SPTips_Rule_Model::getInstanceById($request->get('record'));
        if($ruleModel != null) {
            $ruleModel->delete();
        }
        $response = new Vtiger_Response();
        $response->setResult(['success' => true]);
        $response->emit();
    }
}