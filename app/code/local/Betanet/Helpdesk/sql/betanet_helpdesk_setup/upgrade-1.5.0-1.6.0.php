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

$connection->dropForeignKey($ticketTableName, $installer->getFkName($ticketTableName, 'user_id', $userTableName, 'user_id'));
$connection->changeColumn($ticketTableName, 'user_id', 'created_by', [
    'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'unsigned' => true,
    'nullable' => true,
    'comment' => 'User Id'
]);
$connection->addForeignKey($installer->getFkName($ticketTableName, 'created_by', $userTableName, 'user_id'), $ticketTableName, 'created_by', $userTableName, 'user_id');

$connection->addColumn($ticketTableName, 'pic', [
    'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'unsigned' => true,
    'nullable' => true,
    'comment' => 'Person In Charge'
]);
$connection->addForeignKey($installer->getFkName($ticketTableName, 'pic', $userTableName, 'user_id'), $ticketTableName, 'pic', $userTableName, 'user_id');


$installer->endSetup();