<?php

class Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Ticket extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Ticket constructor.
     */
    public function __construct()
    {
        $this->_controller = 'helpdesk_ticket';
        $this->_blockGroup = 'betanet_helpdesk_adminhtml';
        $this->_headerText = $this->__('Ticket Management');

        parent::__construct();

        if (!Mage::getSingleton('admin/session')->isAllowed('betanet_helpdesk/department/save')) {
            $this->removeButton('add');
        }
    }
}
