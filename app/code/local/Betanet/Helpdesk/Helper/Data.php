<?php

class Betanet_Helpdesk_Helper_Data extends Mage_Core_Helper_Data
{
    public function renderStatusCssClass()
    {
        $css = '';
        $collection = Mage::getModel('betanet_helpdesk/status')->getCollection();
        /** @var Betanet_Helpdesk_Model_Status $status */
        foreach ($collection as $status) {
            $css .= $status->generateCssClass();
        }
        return $css;
    }

    public function renderPriorityCssClass()
    {
        $css = '';
        $collection = Mage::getModel('betanet_helpdesk/priority')->getCollection();
        /** @var Betanet_Helpdesk_Model_Priority $priority */
        foreach ($collection as $priority) {
            $css .= $priority->generateCssClass();
        }
        return $css;
    }
}
