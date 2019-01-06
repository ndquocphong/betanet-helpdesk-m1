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
//            new Betanet_Helpdesk_Model_Event_RecurringEvent()
        ];

        $collection = [];
        foreach ($events as $event) {
            $collection[$event->getId()] = $event;
        }

        return $collection;
    }

    /**
     * To array
     *
     * @param array $arrAttributes
     * @return array
     */
    public function toArray(array $arrAttributes = ['id' => 'value', 'title' => 'label', 'inputValueHtml' => 'html'])
    {
        $result = [];
        foreach ($this->getData() as $item) {
            $arr = [];
            if (isset($arrAttributes['id'])) {
                $arr[$arrAttributes['id']] = $item->getId();
            }
            if (isset($arrAttributes['title'])) {
                $arr[$arrAttributes['title']] = Mage::helper('core')->__('title_' . $item->getId());
            }
            if (isset($arrAttributes['inputValueHtml'])) {
                $arr[$arrAttributes['inputValueHtml']] = Mage::helper('core')->jsQuoteEscape($item->getInputValueHtml(), '"');
            }

            $result[$item->getId()] = $arr;
        }

        return $result;
    }
}
