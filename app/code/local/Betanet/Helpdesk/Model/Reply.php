<?php

class Betanet_Helpdesk_Model_Reply extends Mage_Core_Model_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('betanet_helpdesk/reply');
    }

    /**
     * Get customer model
     *
     * @return Mage_Customer_Model_Customer
     */
    public function getCustomer()
    {
        if ($this->hasData('customer')) {
            return $this->getData('customer');
        }

        $this->setData('customer', Mage::getModel('customer/customer')->load($this->getData('customer_id')));

        return $this->getData('customer');
    }

    /**
     * Get status model
     *
     * @return Betanet_Helpdesk_Model_Status|Mage_Core_Model_Abstract
     */
    public function getStatus()
    {
        if ($this->hasData('status')) {
            return $this->getData('status');
        }

        $this->setData('status', Mage::getModel('betanet_helpdesk/status')->load($this->getData('status_id')));

        return $this->getData('status');
    }

    /**
     * Get ticket model
     *
     * @return Betanet_Helpdesk_Model_Ticket
     */
    public function getTicket()
    {
        if ($this->hasData('ticket')) {
            return $this->getData('ticket');
        }

        $this->setData('ticket', Mage::getModel('betanet_helpdesk/ticket')->load($this->getData('ticket_id')));

        return $this->getData('ticket');
    }

    /**
     * Get pic model
     *
     * @return Betanet_Helpdesk_Model_Pic|Mage_Core_Model_Abstract
     */
    public function getPic()
    {
        if ($this->hasData('pic')) {
            return $this->getData('pic');
        }

        $this->setData('pic', Mage::getModel('betanet_helpdesk/pic')->load($this->getData('pic_id')));

        return $this->getData('pic');
    }

    /**
     * Get author full name
     *
     * @return string
     */
    public function getAuthorFullName()
    {
        if ($this->hasData('author_full_name')) {
            return $this->getData('author_full_name');
        }

        if ($this->getPic()->getId()) {
            $this->setData('author_full_name', $this->getPic()->getUserFullName());
        } else {
            $this->setData('author_full_name', $this->getTicket()->getCustomerName());
        }

        return $this->getData('author_full_name');
    }
}
