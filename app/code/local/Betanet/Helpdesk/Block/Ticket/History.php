<?php

class Betanet_Helpdesk_Block_Ticket_History extends Mage_Core_Block_Template
{
    /**
     * {@inheritdoc}
     */
    public function _construct()
    {
        $this->setTemplate('betanet_helpdesk/grid/ticket/history.phtml');
        parent::_construct();
    }

    /**
     * {@inheritdoc}
     *
     * @return $this|Mage_Core_Block_Abstract
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $pager = $this->getLayout()
            ->createBlock('page/html_pager', 'betanet_helpdesk_ticket_history_pager')
            ->setCollection($this->getTicketCollection());
        $this->setChild('pager', $pager);
        $this->getTicketCollection()->load();
        return $this;
    }

    /**
     * Get ticket collection
     *
     * @return Betanet_Helpdesk_Model_Resource_Ticket_Collection
     */
    public function getTicketCollection()
    {
        if ($this->getData('ticket_collection') instanceof Betanet_Helpdesk_Model_Resource_Ticket_Collection) {
            return $this->getData('ticket_collection');
        }

        $collection = Mage::getModel('betanet_helpdesk/ticket')
            ->getCollection()
            ->addFieldToFilter('customer_id', Mage::getSingleton('customer/session')->getCustomerId());
        $this->setData('ticket_collection', $collection);

        return $this->getData('ticket_collection');
    }

    /**
     * Get view url
     *
     * @param Betanet_Helpdesk_Model_Ticket $ticket
     * @return string
     */
    public function getViewUrl(Betanet_Helpdesk_Model_Ticket $ticket)
    {
        return $this->getUrl('helpdesk/ticket/view', ['ticket_id' => $ticket->getId()]);
    }
}
