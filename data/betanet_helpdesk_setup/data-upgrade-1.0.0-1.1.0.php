<?php
/** @var Betanet_HelpDesk_Model_Resource_Setup $installer */
$installer = $this;
$statusTbName = $installer->getTable('betanet_helpdesk/status');
$rows = [
    ['Open', '008000'],
    ['Processing', 'FF8C00'],
    ['Done', '1E90FF'],
];
$installer->getConnection()->insertArray($statusTbName, ['title', 'color'], $rows);

$priorityTbName = $installer->getTable('betanet_helpdesk/priority');
$rows = [
    ['Low', '696969'],
    ['Normal', '1E90FF'],
    ['High', 'DC143C'],
];
$installer->getConnection()->insertArray($priorityTbName, ['title', 'color'], $rows);
