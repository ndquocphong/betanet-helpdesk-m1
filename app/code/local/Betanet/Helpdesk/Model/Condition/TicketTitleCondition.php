<?php

class Betanet_Helpdesk_Model_Condition_TicketTitleCondition extends Betanet_Helpdesk_Model_AbstractCondition
{
    /**
     * {@inheritdoc}
     *
     * @param $ticket
     * @return bool
     */
    public function isValid($ticket)
    {
        if (!$ticket instanceof Betanet_Helpdesk_Model_Ticket) {
            return false;
        }

        return strpos($ticket->getTitle(), $this->getValue()) !== false;
    }
}
