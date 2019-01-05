<?php

class Betanet_Helpdesk_Model_Action_SendEmailCustomerAction extends Betanet_Helpdesk_Model_AbstractAction
{
    /**
     * @param $event
     */
    public function execute($event)
    {
        // TODO: Implement execute() method.
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getInputValueHtml()
    {
        $source =  Mage::getSingleton('adminhtml/system_config_source_email_template')->toOptionArray();
        $html = '<select class="select" style="width: 100%" name="[value]">';
        foreach ($source as $item) {
            $html .= "<option value=\"{$item['value']}\">{$item['label']}</option>";
        }
        $html .= '</select>';

        return $html;
    }
}
