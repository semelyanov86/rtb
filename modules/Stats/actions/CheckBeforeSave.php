<?php
class Stats_CheckBeforeSave_Action extends Vtiger_Action_Controller {

    function checkPermission(Vtiger_Request $request) {
        return;
    }

    public function process(Vtiger_Request $request) {
        global $adb;
        $dataArr = $request->get('checkBeforeSaveData');
        $response = "OK";
        $message = "";
        $selected_date = Vtiger_Date_UIType::getDBInsertedValue($dataArr['cf_1124']);
        $user = $dataArr['assigned_user_id'];
        if($request->get('editViewAjaxMode')) {
            $mode = $request->get('createMode');

            // On create or edit
            if (isset($mode) && (($mode == 'create') || ($mode == 'edit'))) {
                $res = $adb->pquery("SELECT vtiger_stats.statsid FROM vtiger_stats INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_stats.statsid INNER JOIN vtiger_statscf ON vtiger_stats.statsid = vtiger_statscf.statsid WHERE vtiger_crmentity.deleted = ? AND vtiger_crmentity.smcreatorid = ? AND vtiger_statscf.cf_1124 = ?", array(0, $user, $selected_date));
                if ($adb->num_rows($res) > 0) {
                    $response = "ALERT";
                    $message = "Вы уже вносили данные на текущую дату.";
                }
                if (!Users_Record_Model::getCurrentUserModel()->isAdminUser()) {
                    $curDate = date('Y-m-d');
                    if ($selected_date < $curDate) {
                        $response = "ALERT";
                        $message = "Вы не можете вносить данные задним числом.";
                    }
                    if ($selected_date > $curDate) {
                        $response = "ALERT";
                        $message = "Вы не можете вносить данные за будущий период.";
                    }
                }
            }
            echo json_encode(array("response" => $response, "message" => $message));
        }

        //Никакого окна подтверждения выведено не будет, карточка сохранится как обычно
        return;
    }
}