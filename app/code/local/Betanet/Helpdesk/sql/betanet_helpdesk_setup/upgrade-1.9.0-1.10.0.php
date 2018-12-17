<?php

/** @var Betanet_Helpdesk_Model_Resource_Setup $installer */
$installer = $this;
$installer->startSetup();
$connection = $installer->getConnection();

$ticketTableName = $installer->getTable('betanet_helpdesk/ticket');
$statusTableName = $installer->getTable('betanet_helpdesk/status');
$customerTableName = $installer->getTable('customer/entity');
$picTableName = $installer->getTable('betanet_helpdesk/pic');
$replyTableName = $installer->getTable('betanet_helpdesk/reply');

$replyTable = $connection->newTable($replyTableName)
    ->addColumn('reply_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' => true
    ])
    ->addColumn('ticket_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'unsigned' => true,
        'nullable' => false,
    ])
    ->addColumn('status_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'unsigned' => true,
        'nullable' => true
    ])
    ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'unsigned' => true,
        'nullable' => true
    ])
    ->addColumn('pic_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'unsigned' => true,
        'nullable' => true
    ])
    ->addColumn('message', Varien_Db_Ddl_Table::TYPE_TEXT, null, [
        'nullable' => true
    ])
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, [
        'nullable' => true
    ])
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, [
        'nullable' => true
    ])
    ->addForeignKey($installer->getFkName($replyTableName, 'ticket_id', $ticketTableName, 'ticket_id'), 'ticket_id', $ticketTableName, 'ticket_id')
    ->addForeignKey($installer->getFkName($replyTableName, 'status_id', $statusTableName, 'status_id'), 'status_id', $statusTableName, 'status_id')
    ->addForeignKey($installer->getFkName($replyTableName, 'customer_id', $customerTableName, 'entity_id'), 'customer_id', $customerTableName, 'entity_id')
    ->addForeignKey($installer->getFkName($replyTableName, 'pic_id', $picTableName, 'pic_id'), 'pic_id', $picTableName, 'pic_id');
$connection->createTable($replyTable);

$installer->endSetup();