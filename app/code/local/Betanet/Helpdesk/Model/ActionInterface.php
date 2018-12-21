<?php

interface Betanet_Helpdesk_Model_ActionInterface
{
    /**
     * Execute logic
     *
     * @param $eventArgs
     * @return void
     */
    public function execute($eventArgs);
}
