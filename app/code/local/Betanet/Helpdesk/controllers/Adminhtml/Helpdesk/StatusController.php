<?php

class Betanet_Helpdesk_Adminhtml_Helpdesk_StatusController extends Mage_Adminhtml_Controller_Action
{
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        switch ($this->getRequest()->getRequestedActionName()) {
            case 'edit':
            case 'new':
            case 'save':
                return Mage::getSingleton('admin/session')->isAllowed('betanet_helpdesk/status/save');

            case 'delete':
                return Mage::getSingleton('admin/session')->isAllowed('betanet_helpdesk/status/delete');

            default:
                return parent::_isAllowed();
        }
    }

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
            $this->_getSession()->setFormData(false);
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
            $this->_getSession()->addError($this->__('The Status [%s] does not exist.', $id));
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

    public function massDeleteAction()
    {
        if (!$this->getRequest()->isPost()) {
            return $this->_redirect('*/*/');
        }

        $success = [];
        $statusIds = $this->getRequest()->getParam('status_ids');
        foreach ($statusIds as $statusId) {
            $model = Mage::getModel('betanet_helpdesk/status');
            $model->load($statusId);
            if (!$model->getId()) {
                $this->_getSession()->addError($this->__('The Status [%s] does not exist.', $statusId));
                return $this->_redirect('*/*');
            }

            try {
                $model->delete();
                $success[] = $statusId;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->_getSession()->addException($e, $this->__('An error occurred while deleting the status.'));
            }
        }

        if ($success) {
            $this->_getSession()->addSuccess($this->__('%s of %s have been deleted successfully.', count($success), count($statusIds)));
        }

        return $this->_redirect('*/*/');
    }
}
