<?php

/*+********************************************************************************
 * The content of this file is subject to the Reports 4 You license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 ********************************************************************************/

require_once("modules/ITS4YouReports/ITS4YouReports.php");
require_once("modules/ITS4YouReports/GenerateObj.php");

class Report4YouRun extends CRMEntity
{
    var $reportid;
    var $primarymodule;

    protected static $instances = false;

    function Report4YouRun($reportid)
    {
        $oReport = new ITS4YouReports($reportid);
        $this->reportid = $reportid;
        $this->primarymodule = $oReport->primodule;
        $this->secondarymodule = $oReport->secmodule;
        $this->reporttype = $oReport->reporttype;
        $this->reportname = $oReport->reportname;
    }

    public static function getInstance($reportid) {
        if (!isset(self::$instances[$reportid])) {
            if(ITS4YouReports::isStoredITS4YouReport()===true){
                $ogReport = ITS4YouReports::getStoredITS4YouReport();
            }else{
                $ogReport = new ITS4YouReports();
            }
            
            self::$instances[$reportid] = new GenerateObj($ogReport);
        }
        return self::$instances[$reportid];
    }
    
    // ITS4YOU-CR SlOl 18. 1. 2016 13:11:04 
    public static function getIntanceForKeyMetrics($reportid){
        if (!isset(self::$instances[$reportid])) {
            $obReport = new ITS4YouReports(true,$reportid);
            self::$instances[$reportid] = new GenerateObj($obReport);
        }
        return self::$instances[$reportid];
    }
    // ITS4YOU-END
        
}