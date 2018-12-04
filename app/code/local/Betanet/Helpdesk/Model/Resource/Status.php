<?php

class Betanet_HelpDesk_Model_Resource_Status extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('betanet_helpdesk/status', 'status_id');
    }
}
