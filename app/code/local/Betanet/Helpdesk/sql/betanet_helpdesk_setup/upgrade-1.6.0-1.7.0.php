<?php

/** @var Betanet_Helpdesk_Model_Resource_Setup $installer */
$installer = $this;
$installer->startSetup();
$connection = $installer->getConnection();

$userTableName = $installer->getTable('admin/user');
$picTableName = $installer->getTable('betanet_helpdesk/pic');
$ticketTableName = $installer->getTable('betanet_helpdesk/ticket');

$picTable = $connection->newTable($picTableName);
$picTable->addColumn('pic_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
    'unsigned' => true,
    'nullable' => false,
    'identity' => true,
    'primary' => true
]);
$picTable->addColumn('user_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
    'unsigned' => true,
    'nullable' => true,
]);
$picTable->addForeignKey($installer->getFkName($picTableName, 'user_id', $userTableName, 'user_id'), 'user_id', $userTableName, 'user_id', Varien_Db_Ddl_Table::ACTION_SET_NULL);
$picTable->addIndex($installer->getIdxName($picTableName, ['user_id'], Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE), ['user_id'], [
    'type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
]);
$connection->createTable($picTable);

$connection->dropForeignKey($ticketTableName, $installer->getFkName($ticketTableName, 'pic', $userTableName, 'user_id'));
$connection->addForeignKey($installer->getFkName($ticketTableName, 'pic', $picTableName, 'pic_id'), $ticketTableName, 'pic', $picTableName, 'pic_id');


$installer->endSetup();