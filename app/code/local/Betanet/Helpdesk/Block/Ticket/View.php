<?php

class Betanet_Helpdesk_Block_Ticket_View extends Mage_Core_Block_Template
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->setTemplate('betanet_helpdesk/default/ticket/view.phtml');


        $this->setData('ticket', Mage::registry('betanet_helpdesk/ticket'));

        parent::_construct();
    }

}
