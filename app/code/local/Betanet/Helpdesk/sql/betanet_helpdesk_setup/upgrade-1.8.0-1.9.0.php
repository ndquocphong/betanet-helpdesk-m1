<?php

/** @var Betanet_Helpdesk_Model_Resource_Setup $installer */
$installer = $this;
$installer->startSetup();
$connection = $installer->getConnection();

$ticketTableName = $installer->getTable('betanet_helpdesk/ticket');

$connection->modifyColumn($ticketTableName, 'status_id', [
    'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'unsigned' => true,
    'nullable' => true,
    'comment' => 'Status (Ref to betanet_helpdesk_status)'
]);

$connection->modifyColumn($ticketTableName, 'priority_id', [
    'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'unsigned' => true,
    'nullable' => true,
    'comment' => 'Priority (Ref to betanet_helpdesk_priority)'
]);

$installer->endSetup();