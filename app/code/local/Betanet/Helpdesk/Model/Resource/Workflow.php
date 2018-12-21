<?php

class Betanet_Helpdesk_Model_Resource_Workflow extends Betanet_Helpdesk_Model_Resource_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('betanet_helpdesk/workflow', 'workflow_id');
    }
}
