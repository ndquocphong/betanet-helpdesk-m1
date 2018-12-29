<?php

class Betanet_Helpdesk_Model_Condition_Collection
{
    /**
     * Get collection
     *
     * @return Betanet_Helpdesk_Model_ConditionInterface[]
     */
    public function getData()
    {
        $items = [
            new Betanet_Helpdesk_Model_Condition_CustomerGroupCondition(),
            new Betanet_Helpdesk_Model_Condition_DepartmentCondition(),
            new Betanet_Helpdesk_Model_Condition_LastReplyByCondition(),
            new Betanet_Helpdesk_Model_Condition_LastReplyHoursCondition(),
            new Betanet_Helpdesk_Model_Condition_PicCondition(),
            new Betanet_Helpdesk_Model_Condition_TicketBodyFirstLineCondition(),
            new Betanet_Helpdesk_Model_Condition_TicketStatusCondition(),
            new Betanet_Helpdesk_Model_Condition_TicketTitleCondition(),
            new Betanet_Helpdesk_Model_Condition_TotalReplyCondition(),
            new Betanet_Helpdesk_Model_Condition_TotalReplyCustomerCondition(),
            new Betanet_Helpdesk_Model_Condition_TotalReplyPicCondition(),
        ];

        $collection = [];
        foreach ($items as $item) {
            $collection[$item->getId()] = $item;
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
