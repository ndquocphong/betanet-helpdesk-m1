<?php

interface Betanet_Helpdesk_Model_EventInterface
{
    /**
     * Execute logic
     * @return void
     */
    public function dispatch();

    /**
     * Get allowed conditions
     *
     * @return Betanet_Helpdesk_Model_ConditionInterface[]
     */
    public function getAllowConditions();

    /**
     * Get args for condition
     *
     * @param Betanet_Helpdesk_Model_ConditionInterface $condition
     * @return mixed
     */
    public function getConditionArgs(Betanet_Helpdesk_Model_ConditionInterface $condition);

    /**
     * Get allowed actions
     *
     * @return Betanet_Helpdesk_Model_ActionInterface[]
     */
    public function getAllowActions();

    /**
     * Get args for action
     *
     * @param Betanet_Helpdesk_Model_ActionInterface $action
     * @return mixed
     */
    public function getActionArgs(Betanet_Helpdesk_Model_ActionInterface $action);

    /**
     * Get id
     *
     * @return string
     */
    public function getId();
}
