<?php

class Betanet_Helpdesk_Model_Action_Collection
{
    /**
     * Get collection
     *
     * @return Betanet_Helpdesk_Model_ActionInterface[]
     */
    public function getData()
    {
        $items = [
            new Betanet_Helpdesk_Model_Action_SendEmailPicAction(),
            new Betanet_Helpdesk_Model_Action_SendEmailCustomerAction(),
            new Betanet_Helpdesk_Model_Action_ChangeDepartmentAction(),
            new Betanet_Helpdesk_Model_Action_ChangePicAction(),
            new Betanet_Helpdesk_Model_Action_ChangePriorityAction(),
            new Betanet_Helpdesk_Model_Action_ChangeStatusAction(),
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
