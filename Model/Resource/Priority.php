<?php

class Betanet_HelpDesk_Model_Resource_Priority extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('betanet_helpdesk/priority', 'priority_id');
    }
}
