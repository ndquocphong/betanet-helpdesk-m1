<?php

class Betanet_Helpdesk_Model_Condition_LastReplyByCondition extends Betanet_Helpdesk_Model_AbstractCondition
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
