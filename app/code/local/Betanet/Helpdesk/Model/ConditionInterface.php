<?php

interface Betanet_Helpdesk_Model_ConditionInterface
{
    /**
     * Validate event parameter
     *
     * @param $eventArgs
     * @return bool
     */
    public function isValid($eventArgs);
}
