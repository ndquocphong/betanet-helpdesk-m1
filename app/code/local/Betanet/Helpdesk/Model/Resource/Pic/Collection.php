<?php

class Betanet_Helpdesk_Model_Resource_Pic_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('betanet_helpdesk/pic');
    }
}
