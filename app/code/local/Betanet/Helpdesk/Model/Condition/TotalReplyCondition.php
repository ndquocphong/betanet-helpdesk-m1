<?php

class Betanet_Helpdesk_Model_Condition_TotalReplyCondition extends Betanet_Helpdesk_Model_AbstractCondition
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

        $total = Mage::getModel('betanet_helpdesk/reply')->getCollection()
            ->addFieldToFilter('ticket_id', $ticket->getId())
            ->getSize();

        $operator = '';
        $value = '';

        foreach (str_split($this->getValue()) as $c) {
            if (is_numeric($c)) {
                $value .= $c;
            } else {
                $operator .= $c;
            }
        }

        switch ($operator) {
            case '>':
                return $total > $value;

            case '>=':
                return $total >= $value;

            case '<':
                return $total < $value;

            case '<=':
                return $total <= $value;

            default:
                return $total == $value;
        }
    }
}
