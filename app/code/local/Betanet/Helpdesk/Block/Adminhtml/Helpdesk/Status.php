<?php

class Betanet_HelpDesk_Block_Adminhtml_Helpdesk_Status extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     *
     * Betanet_HelpDesk_Block_Adminhtml_Status constructor.
     */
    public function __construct()
    {
        $this->_controller = 'helpdesk_status';
        $this->_headerText = Mage::helper('betanet_helpdesk')->__('Status Management');
        $this->_blockGroup = 'betanet_helpdesk_adminhtml';

        parent::__construct();

        if (!Mage::getSingleton('admin/session')->isAllowed('betanet_helpdesk/status/save')) {
            $this->_removeButton('add');
        }
    }
}
