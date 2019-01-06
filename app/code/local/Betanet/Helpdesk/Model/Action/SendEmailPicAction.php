<?php

class Betanet_Helpdesk_Model_Action_SendEmailPicAction extends Betanet_Helpdesk_Model_AbstractAction
{
    /**
     * @param $ticket
     * @throws Mage_Core_Exception
     */
    public function execute($ticket)
    {
        if (!$ticket instanceof Betanet_Helpdesk_Model_Ticket) {
            return;
        }

        if (empty($ticket->getPicId())) {
            return;
        }

        $translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(false);

        /** @var Mage_Core_Model_Email_Template $email */
        $email = Mage::getModel('core/email_template');
        $recipient = $ticket->getPic()->getUser()->getEmail();
        $email->sendTransactional(
            $this->getValue(),
            Mage::getStoreConfig('contacts/email/sender_email_identity'),
            $recipient,
            null
        );

        $translate->setTranslateInline(true);
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
        foreach (Mage_Core_Model_Email_Template::getDefaultTemplatesAsOptionsArray() as $item) {
            $html .= "<option value=\"{$item['value']}\">{$item['label']}</option>";
        }
        $html .= '</select>';

        return $html;
    }
}
