<?php

class Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Workflow extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Workflow constructor.
     */
    public function __construct()
    {
        $this->_controller = 'helpdesk_workflow';
        $this->_blockGroup = 'betanet_helpdesk_adminhtml';
        $this->_headerText = $this->__('Workflow Management');

        parent::__construct();

        if (!Mage::getSingleton('admin/session')->isAllowed('betanet_helpdesk/workflow/save')) {
            $this->removeButton('add');
        }
    }
}
