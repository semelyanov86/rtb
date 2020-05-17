<?php
chdir('../');
$Vtiger_Utils_Log = true;
require_once('vtlib/Vtiger/Module.php');
require_once('vtlib/Vtiger/Block.php');
require_once('vtlib/Vtiger/Field.php');
$module = Vtiger_Module::getInstance('Stats');
if ($module) {
    $block = Vtiger_Block::getInstance('System Information', $module);
    if ($block) {
        $field = Vtiger_Field::getInstance('assigned_group', $module);
        if (!$field) {
            $field               = new Vtiger_Field();
            $field->name         = 'assigned_group';
            $field->table        = $module->basetable;
            $field->label        = 'Assigned To Group';
            $field->column       = 'assigned_group';
            $field->columntype   = 'VARCHAR(255)';
            $field->uitype       = 53;
            $field2->displaytype = 3;
            $field->typeofdata   = 'V~M';
            $block->addField($field);
        }
    } else {
        echo "No block";
    }
} else {
    echo "No module";
}

?>