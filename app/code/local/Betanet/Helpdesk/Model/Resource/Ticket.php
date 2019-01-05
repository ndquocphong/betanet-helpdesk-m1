<?php

class Betanet_Helpdesk_Model_Resource_Ticket extends Betanet_Helpdesk_Model_Resource_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('betanet_helpdesk/ticket', 'ticket_id');
    }

    /**
     * {@inheritdoc}
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Betanet_Helpdesk_Model_Resource_Abstract
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if ($object->getData('pic_id') === '-1') {
            $object->setData('pic_id', new Zend_Db_Expr('NULL'));
        }

        return parent::_beforeSave($object);
    }

    /**
     * {@inheritdoc}
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Mage_Core_Model_Resource_Db_Abstract
     */
    public function _afterSave(Mage_Core_Model_Abstract $object)
    {
        // TODO: change event dispatch location
//        if (!$object->getOrigData('ticket_id')) {
//            if ($object->getCreatedBy()) {
//                $pic = Mage::getModel('betanet_helpdesk/pic')->load($object->getCreatedBy(), 'user_id');
//                if ($pic->getId()) {
//                    Mage::getSingleton('betanet_helpdesk/event_newTicketPicEvent')
//                        ->setTicket($object)
//                        ->dispatch();
//                }
//            } elseif ($object->getCustomerId()) {
//                Mage::getSingleton('betanet_helpdesk/event_newTicketCustomerEvent')
//                    ->setTicket($object)
//                    ->dispatch();
//            }
//        } else { // update ticket
//            if ($object->dataHasChangedFor('pic_id')) {
//                Mage::getSingleton('betanet_helpdesk/event_ticketChangedPicEvent')
//                    ->setTicket($object)
//                    ->dispatch();
//            }
//        }

        return parent::_afterSave($object);
    }
}
