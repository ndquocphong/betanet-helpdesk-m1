<?php

class Betanet_Helpdesk_Model_Status extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('betanet_helpdesk/status');
    }

    /**
     * Generate Css Class
     *
     * @return string
     */
    public function generateCssClass()
    {
        $style = 'text-transform:uppercase;font-size:80%;margin:1px;min-width:80px;text-align:center;font-weight:700; color:#'.$this->getColor().';'.'; border: 1px solid #'
            . $this->getColor() . '; padding:1px 4px; display: inline-block;border-radius: 4px';
        return '.status_id-' . $this->getId() . '{'.$style.'}';
    }
}
