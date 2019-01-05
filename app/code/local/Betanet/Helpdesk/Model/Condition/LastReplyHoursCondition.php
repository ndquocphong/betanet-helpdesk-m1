<?php

class Betanet_Helpdesk_Model_Condition_LastReplyHoursCondition extends Betanet_Helpdesk_Model_AbstractCondition
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

        $reply = Mage::getModel('betanet_helpdesk/reply')->getCollection()
            ->addFieldToFilter('ticket_id', $ticket->getId())
            ->addFilterLastReply()
            ->getFirstItem();

        if ($reply->getId()) {
            $now = time();
            $createdAt = strtotime($reply->getCreatedAt());
            $hours = floor(abs($now - $createdAt) / 3600);

            $operator = '';
            $value = '';

            foreach ((string)$this->getValue() as $c) {
                if (is_numeric($c)) {
                    $value .= $c;
                } else {
                    $operator .= $c;
                }
            }

            switch ($operator) {
                case '>':
                    return $hours > $value;

                case '>=':
                case '=>':
                    return $hours >= $value;

                case '<':
                    return $hours < $value;

                case '<=':
                case '=<':
                    return $hours <= $value;

                default:
                    return $hours == $value;
            }
        }

        return false;
    }
}
