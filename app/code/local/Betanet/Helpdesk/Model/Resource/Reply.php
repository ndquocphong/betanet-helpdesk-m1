<?php

class Betanet_Helpdesk_Model_Resource_Reply extends Betanet_Helpdesk_Model_Resource_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('betanet_helpdesk/reply', 'reply_id');
    }

    /**
     * {@inheritdoc}
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Mage_Core_Model_Resource_Db_Abstract
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        if (!$object->getOrigData('reply_id')) { // new ticket
            if ($object->getPicId()) {
                Mage::getSingleton('betanet_helpdesk/event_newReplyPicEvent')
                    ->setTicket($object)
                    ->dispatch();
            }

            if ($object->getCustomerId()) {
                Mage::getSingleton('betanet_helpdesk/event_newReplyCustomerEvent')
                    ->setTicket($object)
                    ->dispatch();
            }
        }

        return parent::_afterSave($object);
    }
}
