<?php

class Betanet_Helpdesk_Model_Resource_Department extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('betanet_helpdesk/department', 'department_id');
    }
}
