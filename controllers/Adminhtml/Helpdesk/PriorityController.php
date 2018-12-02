<?php

class Betanet_HelpDesk_Adminhtml_Helpdesk_PriorityController extends Mage_Adminhtml_Controller_Action
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
                return $this->_getSession()->isAllowed('betanet_helpdesk/priority/save');

            case 'delete':
                return $this->_getSession()->isAllowed('betanet_helpdesk/priority/delete');

            default:
                return parent::_isAllowed();
        }
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('betanet_helpdesk/priority');
        $this->_title($this->__('Help Desk'))->_title($this->__('Priority Management'));
        $this->_addBreadcrumb($this->__('Priority Management'), $this->__('Priority Management'));
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('betanet_helpdesk/priority');

        $model = Mage::getModel('betanet_helpdesk/priority');
        $id = $this->getRequest()->getParam('priority_id');
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->_getSession()->addError($this->__('The Priority [%s] does not exist.', $id));
                return $this->_redirect('*/*');
            }
        }

        Mage::register('betanet_helpdesk/priority', $model);

        $formData = $this->_getSession()->getFormData(true);
        if (!empty($formData)) {
            $model->setData($formData);
        }

        $title = $model->getId()
            ? $this->__('Edit [%s] Priority', $model->getTitle())
            : $this->__('Create new Priority');
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

        $model = Mage::getModel('betanet_helpdesk/priority');
        if (!empty($data['priority_id'])) {
            $model->load($data['priority_id']);
        }

        $model->setData($data);
        $this->_getSession()->setFormData($data);

        try {
            $model->save();
            $this->_getSession()->setFormData(false);
            $this->_getSession()->addSuccess($this->__('The Priority have been saved successfully.'));
            if ($this->getRequest()->getParam('back') === 'edit') {
                return $this->_redirect('*/*/edit', ['priority_id' => $model->getId()]);
            }
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->_getSession()->addException($e, $this->__('An error occurred while saving the priority.'));
        }

        return $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('priority_id');
        if (!$this->getRequest()->isPost() || !$id) {
            return $this->_redirect('*/*/');
        }

        $model = Mage::getModel('betanet_helpdesk/priority');
        $model->load($id);
        if (!$model->getId()) {
            $this->_getSession()->addError($this->__('The Priority [%s] does not exist.', $id));
            return $this->_redirect('*/*');
        }

        try {
            $title = $model->getTitle();
            $model->delete();
            $this->_getSession()->addSuccess($this->__('The Priority [%s] have been deleted successfully.', $title));
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->_getSession()->addException($e, $this->__('An error occurred while deleting the priority.'));
        }

        return $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        if (!$this->getRequest()->isPost()) {
            return $this->_redirect('*/*/');
        }

        $success = [];
        $statusIds = $this->getRequest()->getParam('priority_ids');
        foreach ($statusIds as $statusId) {
            $model = Mage::getModel('betanet_helpdesk/priority');
            $model->load($statusId);
            if (!$model->getId()) {
                $this->_getSession()->addError($this->__('The Priority [%s] does not exist.', $statusId));
                return $this->_redirect('*/*');
            }

            try {
                $model->delete();
                $success[] = $statusId;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->_getSession()->addException($e, $this->__('An error occurred while deleting the priority.'));
            }
        }

        if ($success) {
            $this->_getSession()->addSuccess($this->__('%s of %s have been deleted successfully.', count($success), count($statusIds)));
        }

        return $this->_redirect('*/*/');
    }
}
