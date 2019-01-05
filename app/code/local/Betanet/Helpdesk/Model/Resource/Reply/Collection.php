<?php

class Betanet_Helpdesk_Model_Resource_Reply_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('betanet_helpdesk/reply');
    }
    
    public function addFilterLastReply()
    {
        $this->setPageSize(1)
            ->setOrder('created_at');

        return $this;
    }
}
