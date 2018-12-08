<?php

class Betanet_Helpdesk_Model_Resource_Ticket extends Betanet_Helpdesk_Model_Resource_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('betanet_helpdesk/ticket', 'ticket_id');
    }
}
