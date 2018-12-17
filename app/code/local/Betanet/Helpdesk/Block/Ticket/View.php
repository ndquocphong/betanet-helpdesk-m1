<?php

class Betanet_Helpdesk_Block_Ticket_View extends Mage_Core_Block_Template
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->setTemplate('betanet_helpdesk/default/ticket/view.phtml');


        $this->setData('ticket', Mage::registry('betanet_helpdesk/ticket'));

        parent::_construct();
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

        $this->setData('ticket', Mage::registry('betanet_helpdesk/ticket'));

        return $this->getData('ticket');
    }

    /**
     * Get reply collection
     *
     * @return Betanet_Helpdesk_Model_Resource_Reply_Collection
     */
    public function getReplyCollection()
    {
        if ($this->hasData('reply_collection')) {
            return $this->getData('reply_collection');
        }

        $collection = Mage::getModel('betanet_helpdesk/reply')->getCollection()
            ->addFieldToFilter('ticket_id', $this->getTicket()->getId());
        $this->setData('reply_collection', $collection);

        return $this->getData('reply_collection');
    }

    /**
     * Get current customer id
     *
     * @return int
     */
    public function getCurrentCustomerId()
    {
        return Mage::getSingleton('customer/session')->getCustomerId();
    }
}
