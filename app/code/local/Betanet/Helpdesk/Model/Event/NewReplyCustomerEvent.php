<?php

class Betanet_Helpdesk_Model_Event_NewReplyCustomerEvent extends Betanet_Helpdesk_Model_AbstractEvent
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
            new Betanet_Helpdesk_Model_Condition_TicketStatusCondition(),
            new Betanet_Helpdesk_Model_Condition_DepartmentCondition(),
            new Betanet_Helpdesk_Model_Condition_TotalReplyCondition(),
            new Betanet_Helpdesk_Model_Condition_TotalReplyPicCondition(),
            new Betanet_Helpdesk_Model_Condition_TotalReplyCustomerCondition(),
            new Betanet_Helpdesk_Model_Condition_LastReplyByCondition(),
            new Betanet_Helpdesk_Model_Condition_LastReplyHoursCondition(),
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
            new Betanet_Helpdesk_Model_Action_ChangeDepartmentAction(),
            new Betanet_Helpdesk_Model_Action_ChangePicAction(),
            new Betanet_Helpdesk_Model_Action_ChangePriorityAction(),
            new Betanet_Helpdesk_Model_Action_ChangeStatusAction(),
            new Betanet_Helpdesk_Model_Action_SendEmailCustomerAction(),
            new Betanet_Helpdesk_Model_Action_SendEmailPicAction()
        ];
        $result = [];

        foreach ($collection as $action) {
            $result[$action->getId()] = $action;
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     *
     * @param Betanet_Helpdesk_Model_ConditionInterface $condition
     * @return mixed
     * @throws Mage_Core_Exception
     */
    public function getConditionArgs(Betanet_Helpdesk_Model_ConditionInterface $condition)
    {
        switch (get_class($condition)) {
            case Betanet_Helpdesk_Model_Condition_CustomerGroupCondition::class:
                return $this->getReply()->getCustomer();

            default:
                throw new Mage_Core_Exception('Unsupported condition');
        }
    }

    /**
     * {@inheritdoc}
     *
     * @param Betanet_Helpdesk_Model_ActionInterface $action
     * @return mixed
     * @throws Mage_Core_Exception
     */
    public function getActionArgs(Betanet_Helpdesk_Model_ActionInterface $action)
    {
        switch (get_class($action)) {
            case Betanet_Helpdesk_Model_Action_ChangeStatusAction::class:
            case Betanet_Helpdesk_Model_Action_ChangeDepartmentAction::class:
            case Betanet_Helpdesk_Model_Action_ChangePriorityAction::class:
            case Betanet_Helpdesk_Model_Action_ChangePicAction::class:
                return $this->getReply()->getTicket();

            default:
                throw new Mage_Core_Exception('Unsupported action');
        }
    }
}
