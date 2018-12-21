<?php

interface Betanet_Helpdesk_Model_EventInterface
{
    /**
     * Execute logic
     *
     * @param $eventArgs
     * @return void
     */
    public function dispatch($eventArgs);

    /**
     * Get allowed conditions
     *
     * @return Betanet_Helpdesk_Model_ConditionInterface[]
     */
    public function getAllowConditions();

    /**
     * Get allowed actions
     *
     * @return Betanet_Helpdesk_Model_ActionInterface[]
     */
    public function getAllowActions();

    /**
     * Get id
     *
     * @return string
     */
    public function getId();
}
