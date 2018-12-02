<?php

class Betanet_HelpDesk_Block_Adminhtml_Status extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     *
     * Betanet_HelpDesk_Block_Adminhtml_Status constructor.
     */
    public function __construct()
    {
        $this->_controller = 'adminhtml_status';
        $this->_headerText = Mage::helper('betanet_helpdesk')->__('Status Management');
        $this->_blockGroup = 'betanet_helpdesk';
        parent::__construct();

//        if ($this->_isAllowedAction('save')) {
//            $this->_updateButton('add', 'label', Mage::helper('betanet_helpdesk')->__('Add New Status'));
//        } else {
//            $this->_removeButton('add');
//        }

    }
}
