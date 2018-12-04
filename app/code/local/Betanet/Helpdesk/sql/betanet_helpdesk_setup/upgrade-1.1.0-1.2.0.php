<?php

/** @var Betanet_Helpdesk_Model_Resource_Setup $installer */
$installer = $this;
$installer->startSetup();
$connection = $installer->getConnection();
$roleTableName = $installer->getTable('admin/role');
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
    ->addColumn('view_role_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'nullable' => false,
        'unsigned' => true,
    ])
    ->addColumn('edit_role_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'nullable' => false,
        'unsigned' => true,
    ])
    ->addColumn('assign_role_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'nullable' => false,
        'unsigned' => true,
    ])
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null)
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null)
    ->addIndex($installer->getIdxName($priorityTableName, ['title'], Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE), ['title'], [
        'type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
    ])
    ->addForeignKey($installer->getFkName($departmentTableName, 'view_role_id', $roleTableName, 'role_id'), 'view_role_id', $roleTableName, 'role_id')
    ->addForeignKey($installer->getFkName($departmentTableName, 'edit_role_id', $roleTableName, 'role_id'), 'edit_role_id', $roleTableName, 'role_id')
    ->addForeignKey($installer->getFkName($departmentTableName, 'assign_role_id', $roleTableName, 'role_id'), 'assign_role_id', $roleTableName, 'role_id');

$connection->createTable($departmentTable);

$storeTableName = $installer->getTable('core/store');
$departmentStoreTableName = $installer->getTable('betanet_helpdesk/department_store');
$departmentStoreTable = $connection->newTable($departmentStoreTableName)
    ->addColumn('department_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'nullable' => false,
        'unsigned' => true,
        'primary' => true,
    ])
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'nullable' => false,
        'unsigned' => true,
        'primary' => true,
    ])
    ->addForeignKey($installer->getFkName($departmentStoreTableName, 'department_id', $departmentTableName, 'department_id'), 'department_id', $departmentTableName, 'department_id')
    ->addForeignKey($installer->getFkName($departmentStoreTableName, 'store_id', $storeTableName, 'store_id'), 'store_id', $storeTableName, 'store_id');
$connection->createTable($departmentStoreTable);
$installer->endSetup();
