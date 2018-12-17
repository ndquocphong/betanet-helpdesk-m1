<?php

class Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Ticket_Edit_Tab_Reply extends Mage_Adminhtml_Block_Template implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getTabLabel()
    {
        return $this->__('Replies');
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('Replies');
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function canShowTab()
    {
        $model = Mage::registry('betanet_helpdesk/ticket');
        if (!$model || !$model->getId()) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        parent::_construct();

        $this->setTemplate('betanet_helpdesk/default/reply/replies.phtml');
    }

    /**
     * Get ticket
     *
     * @return Betanet_Helpdesk_Model_Ticket
     */
    public function getTicket()
    {
        return Mage::registry('betanet_helpdesk/ticket');
    }

    /**
     * Get status config source
     *
     * @return Betanet_Helpdesk_Model_Config_Source_Status
     */
    public function getStatusSource()
    {
        return Mage::getSingleton('betanet_helpdesk/config_source_status');
    }

    /**
     * Get current logged user id
     *
     * @return int
     */
    public function getCurrentUserId()
    {
        return Mage::helper('adminhtml')->getCurrentUserId();
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

        $ticket = $this->getTicket();
        $collection = Mage::getModel('betanet_helpdesk/reply')->getCollection()
            ->addFieldToFilter('ticket_id', $ticket->getId());

        $this->setData('reply_collection', $collection);

        return $this->getData('reply_collection');
    }
}
