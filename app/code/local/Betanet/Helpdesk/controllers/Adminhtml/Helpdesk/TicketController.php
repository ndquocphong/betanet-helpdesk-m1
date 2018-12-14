<?php

class Betanet_Helpdesk_Adminhtml_Helpdesk_TicketController extends Mage_Adminhtml_Controller_Action
{
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        switch ($this->getRequest()->getActionName()) {
            case 'new':
            case 'edit':
            case 'save':
                return Mage::getSingleton('admin/session')->isAllowed('betanet_helpdesk/ticket/save');

            case 'delete':
            case 'massDelete':
                return Mage::getSingleton('admin/session')->isAllowed('betanet_helpdesk/ticket/delete');
        }

        return parent::_isAllowed();
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('betanet_helpdesk/ticket');
        $this->_title($this->__('Help Desk'))->_title($this->__('Ticket Management'));
        $this->_addBreadcrumb($this->__('Ticket Management'), $this->__('Ticket Management'));
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('betanet_helpdesk/ticket');

        $model = Mage::getModel('betanet_helpdesk/ticket');
        $id = $this->getRequest()->getParam('ticket_id', 0);
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->_getSession()->addError($this->__('The Ticket which title [%s] does not exist.', $id));
                return $this->_redirect('*/*');
            }
        }

        Mage::register('betanet_helpdesk/ticket', $model);

        $formData = $this->_getSession()->getFormData(true);
        if (!empty($formData)) {
            $model->setData($formData);
        }

        $title = $model->getId()
            ? $this->__('Edit [%s] Ticket', $model->getTitle())
            : $this->__('Create new Ticket');
        $this->_title($title);
        $this->_addBreadcrumb($title, $title);

        $this->renderLayout();
    }

    public function saveAction()
    {
        $data = $this->getRequest()->getPost();
        if (empty($data)) {
            return $this->_redirect('*/*/');
        }

        $model = Mage::getModel('betanet_helpdesk/ticket');
        if (!empty($data['ticket_id'])) {
            $model->load($data['ticket_id']);
        }

        $model->setData($data);
        $model->setData('created_by', Mage::helper('adminhtml')->getCurrentUserId());
        $this->_getSession()->setFormData($data);

        try {
            $model->save();
            $this->_getSession()->setFormData(false);
            $this->_getSession()->addSuccess($this->__('The saving have been executed successfully.'));
            if ($this->getRequest()->getParam('back') === 'edit') {
                return $this->_redirect('*/*/edit', ['ticket_id' => $model->getId()]);
            }

            return $this->_redirect('*/*/');
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Exception $e) {
            echo $e;
            $this->_getSession()->addException($e, $this->__('An error occurred while saving.'));
        }

        return $this->_redirect('*/*/edit');
    }

    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('ticket_id');
        if (!$this->getRequest()->isPost() || !$id) {
            return $this->_redirect('*/*/');
        }

        $model = Mage::getModel('betanet_helpdesk/ticket');
        $model->load($id);
        if (!$model->getId()) {
            $this->_getSession()->addError($this->__('The selected [%s] does not exist.', $id));
            return $this->_redirect('*/*');
        }

        try {
            $title = $model->getTitle();
            $model->delete();
            $this->_getSession()->addSuccess($this->__('The selected [%s] have been deleted successfully.', $title));
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->_getSession()->addException($e, $this->__('An error occurred while deleting the selected.'));
        }

        return $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        if (!$this->getRequest()->isPost()) {
            return $this->_redirect('*/*/');
        }

        $success = [];
        $ids = $this->getRequest()->getParam('ticket_ids');
        foreach ($ids as $id) {
            $model = Mage::getModel('betanet_helpdesk/ticket');
            $model->load($id);
            if (!$model->getId()) {
                $this->_getSession()->addError($this->__('The selected [%s] does not exist.', $id));
                return $this->_redirect('*/*');
            }

            try {
                $model->delete();
                $success[] = $id;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->_getSession()->addException($e, $this->__('An error occurred while deleting the selected.'));
            }
        }

        if ($success) {
            $this->_getSession()->addSuccess($this->__('%s of %s have been deleted successfully.', count($success), count($ids)));
        }

        return $this->_redirect('*/*/');
    }
}

