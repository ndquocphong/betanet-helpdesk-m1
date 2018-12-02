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

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('betanet_helpdesk/status');

        $model = Mage::getModel('betanet_helpdesk/status');
        $id = $this->getRequest()->getParam('status_id');
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')
                    ->addError($this->__('The Status [%s] does not exist.', $id));
                return $this->_redirect('*/*');
            }
        }

        Mage::register('betanet_helpdesk/status', $model);

        $formData = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($formData)) {
            $model->setData($formData);
        }

        $title = $model->getId()
            ? $this->__('Edit [%s] Status', $model->getTitle())
            : $this->__('Create new Status');
        $this->_title($title);

        $this->_addBreadcrumb($title, $title);
        $this->renderLayout();
    }

    public function saveAction()
    {
        $data = $this->getRequest()->getPost();
        if (!$data) {
            return $this->_redirect('*/*/');
        }

        $model = Mage::getModel('betanet_helpdesk/status');
        if (!empty($data['status_id'])) {
            $model->load($data['status_id']);
        }

        $model->setData($data);
        $this->_getSession()->setFormData($data);

        try {
            $model->save();
            $this->_getSession()->addSuccess($this->__('The Status have been saved successfully.'));
            if ($this->getRequest()->getParam('back') === 'edit') {
                return $this->_redirect('*/*/edit', ['status_id' => $model->getId()]);
            }
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->_getSession()->addException($e, $this->__('An error occurred while saving the status.'));
        }

        return $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('status_id');
        if (!$this->getRequest()->isPost() || !$id) {
            return $this->_redirect('*/*/');
        }

        $model = Mage::getModel('betanet_helpdesk/status');
        $model->load($id);
        if (!$model->getId()) {
            Mage::getSingleton('adminhtml/session')
                ->addError($this->__('The Status [%s] does not exist.', $id));
            return $this->_redirect('*/*');
        }

        try {
            $title = $model->getTitle();
            $model->delete();
            $this->_getSession()->addSuccess($this->__('The Status [%s] have been deleted successfully.', $title));
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->_getSession()->addException($e, $this->__('An error occurred while deleting the status.'));
        }

        return $this->_redirect('*/*/');
    }
}
