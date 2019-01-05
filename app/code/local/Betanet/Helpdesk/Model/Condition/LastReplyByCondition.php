<?php

class Betanet_Helpdesk_Model_Condition_LastReplyByCondition extends Betanet_Helpdesk_Model_AbstractCondition
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
            return (bool)$reply->getData($this->getValue());
        }

        return false;
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getInputValueHtml()
    {
        $source = [
            [
                'value' => 'customer_id',
                'label' => Mage::helper('core')->__('Customer')
            ],
            [
                'value' => 'pic_ic',
                'label' => Mage::helper('core')->__('PIC')
            ]
        ];
        $html = '<select class="select" style="width: 100%" name="[value]">';
        foreach ($source as $item) {
            $html .= "<option value=\"{$item['value']}\">{$item['label']}</option>";
        }
        $html .= '</select>';

        return $html;
    }
}
