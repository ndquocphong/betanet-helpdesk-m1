<?php

class Betanet_Helpdesk_Model_Action_ChangePicAction extends Betanet_Helpdesk_Model_AbstractAction
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

        $ticket->setData('pic_id', $this->getValue());
        $ticket->save();
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getInputValueHtml()
    {
        $source =  Mage::getSingleton('betanet_helpdesk/config_source_pic')->toOptionArray();
        $html = '<select class="select" style="width: 100%" name="[value]">';
        foreach ($source as $item) {
            $html .= "<option value=\"{$item['value']}\">{$item['label']}</option>";
        }
        $html .= '</select>';

        return $html;
    }
}
