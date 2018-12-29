<?php

/** @var Betanet_Helpdesk_Model_Resource_Setup $installer */
$installer = $this;
$installer->startSetup();
$connection = $installer->getConnection();

$workflowTableName = $installer->getTable('betanet_helpdesk/workflow');
$workflowConditionTableName = $installer->getTable('betanet_helpdesk/workflow_condition');
$workflowActionTableName = $installer->getTable('betanet_helpdesk/workflow_action');

$workflowTable = $connection->newTable($workflowTableName)
    ->addColumn('workflow_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' => true
    ])
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, [
        'nullable' => false,
    ])
    ->addColumn('enabled', Varien_Db_Ddl_Table::TYPE_BOOLEAN, null, [
        'nullable' => false,
        'default' => 1
    ])
    ->addColumn('priority', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'nullable' => false,
        'default' => 0
    ])
    ->addColumn('event_id', Varien_Db_Ddl_Table::TYPE_TEXT, 255, [
        'nullable' => false,
    ])
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, [
        'nullable' => true
    ])
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, [
        'nullable' => true
    ])
    ->addIndex($connection->getIndexName($workflowTableName, ['event_id']), ['event_id']);
$connection->createTable($workflowTable);

$workflowConditionTable = $connection->newTable($workflowConditionTableName)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' => true
    ])
    ->addColumn('workflow_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'unsigned' => true,
        'nullable' => false,
    ])
    ->addColumn('condition_id', Varien_Db_Ddl_Table::TYPE_TEXT, 255, [
        'nullable' => false,
    ])
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_TEXT, null, [
        'nullable' => false,
    ])
    ->addForeignKey($connection->getForeignKeyName($workflowConditionTableName, 'workflow_id', $workflowTableName, 'workflow_id'), 'workflow_id', $workflowTableName, 'workflow_id');
$connection->createTable($workflowConditionTable);

$workflowActionTable = $connection->newTable($workflowActionTableName)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' => true
    ])
    ->addColumn('workflow_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'unsigned' => true,
        'nullable' => false,
    ])
    ->addColumn('action_id', Varien_Db_Ddl_Table::TYPE_TEXT, 255, [
        'nullable' => false,
    ])
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_TEXT, null, [
        'nullable' => false,
    ])
    ->addForeignKey($connection->getForeignKeyName($workflowActionTable, 'workflow_id', $workflowTableName, 'workflow_id'), 'workflow_id', $workflowTableName, 'workflow_id');
$connection->createTable($workflowActionTable);

$installer->endSetup();