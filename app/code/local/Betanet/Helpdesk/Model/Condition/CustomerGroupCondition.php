<?php

class Betanet_Helpdesk_Model_Condition_CustomerGroupCondition extends Betanet_Helpdesk_Model_AbstractCondition
{
    /**
     * {@inheritdoc}
     *
     * @param $event
     * @return bool
     */
    public function isValid($customer)
    {
        if (!$customer instanceof Mage_Customer_Model_Customer) {
            return false;
        }

        return in_array($customer->getGroupId(), explode(',', $this->getValue()));
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getInputValueHtml()
    {
        $source =  Mage::getSingleton('adminhtml/system_config_source_customer_group_multiselect')->toOptionArray();
        $html = '<select class="select" style="width: 100%" name="[value][]" multiple>';
        foreach ($source as $item) {
            $html .= "<option value=\"{$item['value']}\">{$item['label']}</option>";
        }
        $html .= '</select>';

        return $html;
    }
}
