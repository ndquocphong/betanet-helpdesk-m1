<?php

class Betanet_Helpdesk_Model_Condition_DepartmentCondition extends Betanet_Helpdesk_Model_AbstractCondition
{
    /**
     * {@inheritdoc}
     *
     * @param $event
     * @return bool
     */
    public function isValid($event)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getInputValueHtml()
    {
        $html = '<select style="width: 100%" multiple name="[value][]">';
        foreach (Mage::getSingleton('betanet_helpdesk/config_source_department')->toArray() as $value => $label) {
            $html .= "<option value=\"{$value}\">{$label}</option>";
        }
        $html .= '</select>';

        return $html;
    }
}
