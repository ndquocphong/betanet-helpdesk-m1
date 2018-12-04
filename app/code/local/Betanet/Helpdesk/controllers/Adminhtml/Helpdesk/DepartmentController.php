<?php

class Betanet_Helpdesk_Adminhtml_Helpdesk_DepartmentController extends Mage_Adminhtml_Controller_Action
{
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        var_dump($this->getRequest()->getActionName());
        switch ($this->getRequest()->getActionName()) {
            case 'new':
            case 'edit':
            case 'save':
            case 'massEnable':
                return $this->_getSession()->isAllowed('betanet_helpdesk/department/save');

            case 'delete':
            case 'massDelete':
                return $this->_getSession()->isAllowed('betanet_helpdesk/department/delete');
        }

        return parent::_isAllowed();
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('betanet_helpdesk/department');
        $this->_title($this->__('Help Desk'))->_title($this->__('Department Management'));
        $this->_addBreadcrumb($this->__('Department Management'), $this->__('Department Management'));
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        die(__METHOD__);
    }

    public function saveAction()
    {
        die(__METHOD__);
    }

    public function deleteAction()
    {
        die(__METHOD__);
    }

    public function massDeleteAction()
    {
        die(__METHOD__);
    }

    public function massEnableAction()
    {
        die(__METHOD__);
    }
}

