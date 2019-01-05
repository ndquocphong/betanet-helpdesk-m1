<?php

class Betanet_Helpdesk_Model_Condition_TotalReplyPicCondition extends Betanet_Helpdesk_Model_AbstractCondition
{
    /**
     * {@inheritdoc}
     *
     * @param $event
     * @return bool
     */
    public function isValid($event)
    {
        if (!$ticket instanceof Betanet_Helpdesk_Model_Ticket) {
            return false;
        }

        $total = Mage::getModel('betanet_helpdesk/reply')->getCollection()
            ->addFieldToFilter('ticket_id', $ticket->getId())
            ->addFieldToFilter('pic_id', new Zend_Db_Expr('NOT NULL'))
            ->getSize();

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
