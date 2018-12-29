<?php

class Betanet_Helpdesk_Model_Workflow extends Mage_Core_Model_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('betanet_helpdesk/workflow');
        $this->setData('conditions', []);
        $this->setOrigData('conditions', []);
        $this->setData('actions', []);
        $this->setOrigData('actions', []);
    }

    /**
     * Execute logic of workflow
     *
     * @param $eventArgs
     */
    public function execute($eventArgs)
    {

    }
}
