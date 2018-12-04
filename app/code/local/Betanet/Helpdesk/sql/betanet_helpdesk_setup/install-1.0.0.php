<?php
/** @var Betanet_HelpDesk_Model_Resource_Setup $installer */
$installer = $this;
$installer->startSetup();
$connection = $installer->getConnection();
$statusTableName = $installer->getTable('betanet_helpdesk/status');
$statusTable = $connection->newTable($statusTableName)
    ->addColumn('status_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' => true,
    ])
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 64, [
        'nullable' => false
    ])
    ->addColumn('color', Varien_Db_Ddl_Table::TYPE_VARCHAR, 7, [
        'default' => '000000'
    ])
    ->addIndex($installer->getIdxName($statusTableName, ['title'], Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE), ['title'], [
        'type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
    ]);

$connection->createTable($statusTable);
$installer->endSetup();
