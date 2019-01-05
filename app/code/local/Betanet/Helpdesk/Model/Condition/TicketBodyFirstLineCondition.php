<?php

class Betanet_Helpdesk_Model_Condition_TicketBodyFirstLineCondition extends Betanet_Helpdesk_Model_AbstractCondition
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

        $firstLine = strtok($ticket->getBody(), "\n");

        return strpos($firstLine, $this->getValue()) !== false;
    }
}
