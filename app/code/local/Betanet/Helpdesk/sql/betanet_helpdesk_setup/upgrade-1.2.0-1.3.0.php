<?php

/** @var Betanet_Helpdesk_Model_Resource_Setup $installer */
$installer = $this;
$installer->startSetup();
$connection = $installer->getConnection();
$departmentTableName = $installer->getTable('betanet_helpdesk/department');

$connection->dropColumn($departmentTableName, 'view_role_id');
$connection->dropColumn($departmentTableName, 'edit_role_id');
$connection->dropColumn($departmentTableName, 'assign_role_id');

$roleTableName = $installer->getTable('admin/role');
$departmentRoleTableName = $installer->getTable('betanet_helpdesk/department_role');
$departmentRoleTable = $connection->newTable($departmentRoleTableName)
    ->addColumn('department_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'unsigned' => true,
        'primary' => true,
        'nullable' => false
    ])
    ->addColumn('role_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'unsigned' => true,
        'primary' => true,
        'nullable' => false
    ])
    ->addColumn('action', Varien_Db_Ddl_Table::TYPE_VARCHAR, 64, [
        'primary' => true,
        'nullable' => false
    ]);
$connection->createTable($departmentRoleTable);

$installer->endSetup();
