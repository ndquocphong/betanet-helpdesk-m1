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
}
