<?php

class Betanet_Helpdesk_Model_Cron extends Mage_Core_Model_Abstract
{
    /**
     * Dispatch recurring task event
     */
    public function run()
    {
        Mage::getSingleton('betanet_helpdesk/event_recurringEvent')
            ->dispatch();
    }
}
