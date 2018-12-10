<?php

/** @var Betanet_Helpdesk_Model_Resource_Setup $installer */
$installer = $this;
$installer->startSetup();
$connection = $installer->getConnection();

$ticketTableName = $installer->getTable('betanet_helpdesk/ticket');

$connection->modifyColumn($ticketTableName, 'customer_id', [
    'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'unsigned' => true,
    'nullable' => true,
    'comment' => 'Customer Id'
]);
$connection->modifyColumn($ticketTableName, 'user_id', [
    'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'unsigned' => true,
    'nullable' => true,
    'comment' => 'User Id'
]);
$connection->addColumn($ticketTableName, 'customer_email', [
    'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
    'length' => 255,
    'nullable' => false,
    'comment' => 'Customer Email'
]);
$connection->addColumn($ticketTableName, 'customer_name', [
    'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
    'length' => 255,
    'nullable' => false,
    'comment' => 'Customer Name'
]);

$installer->endSetup();