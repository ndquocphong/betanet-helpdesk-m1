<?php

class Betanet_Helpdesk_Model_Condition_TicketStatusCondition extends Betanet_Helpdesk_Model_AbstractCondition
{
    /**
     * {@inheritdoc}
     *
     * @param $event
     * @return bool
     */
    public function isValid($event)
    {
        return true;
    }
}
