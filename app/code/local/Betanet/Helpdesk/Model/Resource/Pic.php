<?php

class Betanet_Helpdesk_Model_Resource_Pic extends Betanet_Helpdesk_Model_Resource_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('betanet_helpdesk/pic', 'pic_id');
    }
}
