<?php

class Betanet_HelpDesk_Model_Resource_Priority_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('betanet_helpdesk/priority');
    }
}
