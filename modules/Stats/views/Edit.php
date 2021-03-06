<?php

class Stats_Edit_View extends Vtiger_Edit_View
{
    public function checkPermission(Vtiger_Request $request)
    {
        $record = $request->get('record');
        if ($record) {
            $recordModel = Vtiger_Record_Model::getInstanceById($record, 'Stats');
            if ($recordModel->get('assigned_user_id') == Users_Record_Model::getCurrentUserModel()->getId()) {
                if ($recordModel->get('cf_1124') < date('Y-m-d')) {
                    throw new AppException(vtranslate('LBL_PERMISSION_DENIED'));
                }
            }
        }
        parent::checkPermission($request); // TODO: Change the autogenerated stub
    }
}