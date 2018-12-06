<?php

class Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Department extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Department constructor.
     */
    public function __construct()
    {
        $this->_controller = 'helpdesk_department';
        $this->_blockGroup = 'betanet_helpdesk_adminhtml';
        $this->_headerText = $this->__('Department Management');

        parent::__construct();

        if (!Mage::getSingleton('admin/session')->isAllowed('betanet_helpdesk/department/save')) {
            $this->removeButton('add');
        }
    }
}
