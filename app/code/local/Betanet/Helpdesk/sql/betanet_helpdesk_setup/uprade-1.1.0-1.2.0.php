<?php

/** @var Betanet_Helpdesk_Model_Resource_Setup $installer */
$installer = $this;
$installer->startSetup();
$connection = $installer->getConnection();
$departmentTableName = $installer->getTable('betanet_helpdesk/department');
$departmentTable = $connection->newTable($departmentTableName)
    ->addColumn('department_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' => true,
    ])
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, [
        'nullable' => false
    ])
    ->addColumn('enabled', Varien_Db_Ddl_Table::TYPE_BOOLEAN, null, [
        'nullable' => false
    ])
    ->addColumn('role_view', Varien_Db_Ddl_Table::TYPE_BOOLEAN, null, [
        'nullable' => false
    ])
    ->addIndex($installer->getIdxName($priorityTableName, ['title'], Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE), ['title'], [
        'type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
    ]);

$connection->createTable($departmentTable);
$installer->endSetup();
