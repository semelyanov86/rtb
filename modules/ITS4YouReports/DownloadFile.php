<?php

/*+********************************************************************************
 * The content of this file is subject to the Reports 4 You license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 ********************************************************************************/

require_once('config.php');
require_once('include/database/PearDatabase.php');

$adb = PearDatabase::getInstance();

$filepath = vtlib_purify($_REQUEST['filepath']);
$name = vtlib_purify($_REQUEST['filename']);

if($filepath != "")
{
    $filesize = filesize($filepath);
    if(!fopen($filepath, "r"))
    {
        echo 'unable to open file';
    }
    else
    {
        $fileContent = fread(fopen($filepath, "r"), $filesize);
    }
    header("Content-type: $fileType");
    header("Content-length: $filesize");
    header("Cache-Control: private");
    header("Content-Disposition: attachment; filename=$name");
    header("Content-Description: PHP Generated Data");
    echo $fileContent;
}
else
{
    echo "Record doesn't exist.";
}