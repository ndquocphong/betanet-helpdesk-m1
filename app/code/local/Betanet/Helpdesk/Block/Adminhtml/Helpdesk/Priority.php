<?php

class Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Priority extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Priority constructor.
     */
    public function __construct()
    {
        $this->_controller = 'helpdesk_priority';
        $this->_headerText = $this->__('Priority Management');
        $this->_blockGroup = 'betanet_helpdesk_adminhtml';

        parent::__construct();

        if (!Mage::getSingleton('admin/session')->isAllowed('betanet_helpdesk/priority/save')) {
            $this->removeButton('add');
        }
    }
}
