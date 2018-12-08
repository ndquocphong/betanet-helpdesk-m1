<?php

class Betanet_Helpdesk_Model_Ticket extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('betanet_helpdesk/ticket');
    }
}