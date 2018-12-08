<?php

/** @var Betanet_Helpdesk_Model_Resource_Setup $installer */
$installer = $this;
$installer->startSetup();
$connection = $installer->getConnection();

$userTableName = $installer->getTable('admin/user');
$customerTableName = $installer->getTable('customer/entity');
$statusTableName = $installer->getTable('betanet_helpdesk/status');
$priorityTableName = $installer->getTable('betanet_helpdesk/priority');
$departmentTableName = $installer->getTable('betanet_helpdesk/department');
$ticketTableName = $installer->getTable('betanet_helpdesk/ticket');

$ticketTable = $connection->newTable($ticketTableName)
    ->addColumn('ticket_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'unsigned' => true,
        'primary' => true,
        'nullable' => false,
        'identity' => true
    ])
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, [
        'nullable' => false
    ])
    ->addColumn('body', Varien_Db_Ddl_Table::TYPE_TEXT, null, [
        'nullable' => false
    ])
    ->addColumn('status_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'unsigned' => true,
        'nullable' => false
    ])
    ->addColumn('priority_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'unsigned' => true,
        'nullable' => false
    ])
    ->addColumn('department_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'unsigned' => true,
        'nullable' => false
    ])
    ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'unsigned' => true,
        'nullable' => false,
        'default' => 0
    ])
    ->addColumn('user_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'unsigned' => true,
        'nullable' => false,
        'default' => 0
    ])
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null)
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null)
    ->addForeignKey($installer->getFkName($ticketTableName, 'status_id', $statusTableName, 'status_id'), 'status_id', $statusTableName, 'status_id')
    ->addForeignKey($installer->getFkName($ticketTableName, 'priority_id', $priorityTableName, 'priority_id'), 'priority_id', $priorityTableName, 'priority_id')
    ->addForeignKey($installer->getFkName($ticketTableName, 'department_id', $departmentTableName, 'department_id'), 'department_id', $departmentTableName, 'department_id')
    ->addForeignKey($installer->getFkName($ticketTableName, 'customer_id', $customerTableName, 'entity_id'), 'customer_id', $customerTableName, 'entity_id')
    ->addForeignKey($installer->getFkName($ticketTableName, 'user_id', $userTableName, 'user_id'), 'user_id', $userTableName, 'user_id');
$connection->createTable($ticketTable);

$installer->endSetup();
