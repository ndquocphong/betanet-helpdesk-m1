<?php

/** @var Betanet_Helpdesk_Model_Resource_Setup $installer */
$installer = $this;
$installer->startSetup();
$connection = $installer->getConnection();

$picTableName = $installer->getTable('betanet_helpdesk/pic');
$ticketTableName = $installer->getTable('betanet_helpdesk/ticket');

$connection->dropForeignKey($ticketTableName, $installer->getFkName($ticketTableName, 'pic', $picTableName, 'pic_id'));
$connection->changeColumn($ticketTableName, 'pic', 'pic_id', [
    'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'unsigned' => true,
    'nullable' => true,
    'comment' => 'Person In Charge'
]);
$connection->addForeignKey($installer->getFkName($ticketTableName, 'pic_id', $picTableName, 'pic_id'), $ticketTableName, 'pic_id', $picTableName, 'pic_id');

$installer->endSetup();