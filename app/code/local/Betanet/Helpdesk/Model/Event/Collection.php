<?php

class Betanet_Helpdesk_Model_Event_Collection
{
    /**
     * Get events
     *
     * @return Betanet_Helpdesk_Model_EventInterface[]
     */
    public function getData()
    {
        $events = [
            new Betanet_Helpdesk_Model_Event_NewTicketCustomerEvent(),
            new Betanet_Helpdesk_Model_Event_NewTicketPicEvent(),
            new Betanet_Helpdesk_Model_Event_NewReplyCustomerEvent(),
            new Betanet_Helpdesk_Model_Event_NewReplyPicEvent(),
            new Betanet_Helpdesk_Model_Event_TicketChangedPicEvent(),
            new Betanet_Helpdesk_Model_Event_RecurringEvent()
        ];

        $collection = [];
        foreach ($events as $event) {
            $collection[$event->getId()] = $event;
        }

        return $collection;
    }
}
