<?php

class Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Ticket_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Ticket_Edit_Tabs constructor.
     * @param array $args
     */
    public function __construct(array $args = array())
    {
        parent::__construct($args);

        $this->setId('ticket_tabs');
        $this->setDestElementId('edit_form');
    }
}
