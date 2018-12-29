<?php

class Betanet_Helpdesk_Model_Event_NewTicketPicEvent extends Betanet_Helpdesk_Model_AbstractEvent
{
    /**
     * {@inheritdoc}
     *
     * @return Betanet_Helpdesk_Model_ConditionInterface[]
     */
    public function getAllowConditions()
    {
        $collection = [
            new Betanet_Helpdesk_Model_Condition_CustomerGroupCondition(),
            new Betanet_Helpdesk_Model_Condition_DepartmentCondition(),
            new Betanet_Helpdesk_Model_Condition_TicketTitleCondition(),
            new Betanet_Helpdesk_Model_Condition_TicketBodyFirstLineCondition(),
        ];
        $result = [];

        foreach ($collection as $condition) {
            $result[$condition->getId()] = $condition;
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     *
     * @return Betanet_Helpdesk_Model_ActionInterface[]
     */
    public function getAllowActions()
    {
        $collection = [
            new Betanet_Helpdesk_Model_Action_SendEmailAction(),
            new Betanet_Helpdesk_Model_Action_SendEmailCustomerAction(),
            new Betanet_Helpdesk_Model_Action_SendEmailPicAction()
        ];
        $result = [];

        foreach ($collection as $action) {
            $result[$action->getId()] = $action;
        }

        return $result;
    }
}
