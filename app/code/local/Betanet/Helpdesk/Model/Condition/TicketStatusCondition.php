<?php

class Betanet_Helpdesk_Model_Condition_TicketStatusCondition extends Betanet_Helpdesk_Model_AbstractCondition
{
    /**
     * {@inheritdoc}
     *
     * @param $status
     * @return bool
     */
    public function isValid($status)
    {
        if (!$status instanceof Betanet_Helpdesk_Model_Status) {
            return false;
        }

        return in_array($status->getId(), explode(',', $this->getValue()));
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getInputValueHtml()
    {
        $source =  Mage::getSingleton('betanet_helpdesk/config_source_status')->toOptionArray();
        $html = '<select class="select" style="width: 100%" name="[value][]" multiple>';
        foreach ($source as $item) {
            $html .= "<option value=\"{$item['value']}\">{$item['label']}</option>";
        }
        $html .= '</select>';

        return $html;
    }
}
