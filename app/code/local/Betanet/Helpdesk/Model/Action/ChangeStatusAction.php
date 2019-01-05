<?php

class Betanet_Helpdesk_Model_Action_ChangeStatusAction extends Betanet_Helpdesk_Model_AbstractAction
{
    /**
     * {@inheritdoc}
     *
     * @param $ticket
     * @throws Exception
     */
    public function execute($ticket)
    {
        if (!$ticket instanceof Betanet_Helpdesk_Model_Ticket) {
            return;
        }

        $ticket->setData('status_id', $this->getValue());
        $ticket->save();
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getInputValueHtml()
    {
        $source =  Mage::getSingleton('betanet_helpdesk/config_source_status')->toOptionArray();
        $html = '<select class="select" style="width: 100%" name="[value]">';
        foreach ($source as $item) {
            $html .= "<option value=\"{$item['value']}\">{$item['label']}</option>";
        }
        $html .= '</select>';

        return $html;
    }
}
