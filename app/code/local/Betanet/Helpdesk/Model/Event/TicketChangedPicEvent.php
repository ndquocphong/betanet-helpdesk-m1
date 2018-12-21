<?php

class Betanet_Helpdesk_Model_Event_TicketChangedPicEvent extends Betanet_Helpdesk_Model_AbstractEvent
{
    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getId()
    {
        return 'betanet_helpdesk/event_ticketChangedEvent';
    }

    /**
     * {@inheritdoc}
     *
     * @return Betanet_Helpdesk_Model_ConditionInterface[]
     */
    public function getAllowConditions()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     *
     * @return Betanet_Helpdesk_Model_ActionInterface[]
     */
    public function getAllowActions()
    {
        return [];
    }
}
