<?php

class Betanet_HelpDesk_Adminhtml_Helpdesk_StatusController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('betanet_helpdesk/status');
        $this->_title($this->__('Help Desk'))->_title($this->__('Status Management'));
        $this->_addBreadcrumb($this->__('Status Management'), $this->__('Status Management'));
        $this->renderLayout();
    }
}
