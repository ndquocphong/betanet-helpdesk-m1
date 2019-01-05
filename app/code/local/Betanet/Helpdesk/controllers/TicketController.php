<?php

class Betanet_Helpdesk_TicketController extends Mage_Core_Controller_Front_Action
{
    /**
     * {@inheritdoc}
     *
     * @return Mage_Core_Controller_Front_Action
     */
    public function preDispatch()
    {
        parent::preDispatch();

        if (!$this->getRequest()->isDispatched()) {
            return $this;
        }

        switch ($this->getRequest()->getActionName()) {
            case 'index':
            case 'view':
                if (!Mage::getSingleton('customer/session')->authenticate($this)) {
                    $this->setFlag('', 'no-dispatch', true);
                }
                break;
        }

        return $this;
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->_title($this->__('Help Desk'))->_title($this->__('Ticket History'));
        $this->getLayout()->getBlock('customer_account_navigation')->setActive('helpdesk/ticket');
        $this->renderLayout();
    }

    public function viewAction()
    {
        $ticketId = $this->getRequest()->getParam('ticket_id');
        $ticket = Mage::getModel('betanet_helpdesk/ticket')->load($ticketId);
        if (!$ticket->getId()) {
            Mage::getSingleton('core/session')->addError(sprintf("The request ticket #%s does not exist.", $ticketId));
            return $this->_redirect('*/*/');
        }

        $customerId = Mage::getSingleton('customer/session')->getCustomerId();
        if ($ticket->getData('customer_id') != $customerId) {
            Mage::getSingleton('core/session')->addError(sprintf("The request ticket #%s does not exist.", $ticketId));
            return $this->_redirect('*/*/');
        }

        Mage::register('betanet_helpdesk/ticket', $ticket);

        $this->loadLayout();
        $this->_title($this->__('Help Desk'))->_title($this->__('Ticket #%s', $ticket->getId()));
        $this->getLayout()->getBlock('customer_account_navigation')->setActive('helpdesk/ticket');

        $this->renderLayout();
    }

    public function submitAction()
    {
        $customerId = Mage::getSingleton('customer/session')->getCustomerId();
        $model = Mage::getModel('betanet_helpdesk/ticket');
        $data = $this->getRequest()->getPost();
        if (!empty($data)) {
            Mage::getSingleton('core/session')->setFormData($data);
            if (!$this->_validateFormKey()) {
                Mage::getSingleton('core/session')->addError("Invalid form key.");
            } else {
                $model->setData('customer_name', $data['customer_name']);
                $model->setData('customer_email', $data['customer_email']);
                $model->setData('department_id', $data['department_id']);
                $model->setData('title', $data['title']);
                $model->setData('body', $data['body']);

                if ($customerId) {
                    $model->setData('customer_id', $customerId);
                }

                try {
                    $model->save();

                    if ($model->getCustomerId()) {
                        Mage::getSingleton('betanet_helpdesk/event_newTicketCustomerEvent')
                            ->setTicket($model)
                            ->dispatch();
                    }

                    Mage::getSingleton('core/session')->setFormData(false);
                    Mage::getSingleton('core/session')->addSuccess($this->__('The ticket was submitted successfully.'));
                } catch (Mage_Core_Exception $e) {
                    Mage::getSingleton('core/session')->addError($e->getMessage());
                } catch (Exception $e) {
                    echo $e;
                    Mage::getSingleton('core/session')->addException($e, $this->__('An error occurred while saving.'));
                }
            }
        }

        $this->loadLayout();
        $this->_title($this->__('Help Desk'))->_title($this->__('Submit New Ticket'));
        if (!$customerId) {
            $this->getLayout()->getBlock('root')->setTemplate('page/1column.phtml');
        } else {
            $this->getLayout()->getBlock('customer_account_navigation')->setActive('helpdesk/ticket');
        }

        $this->renderLayout();
    }

}
