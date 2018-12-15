<?php

class Betanet_Helpdesk_Model_Ticket extends Mage_Core_Model_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('betanet_helpdesk/ticket');
    }

    /**
     * Get department model
     *
     * @return Betanet_Helpdesk_Model_Department|Mage_Core_Model_Abstract
     */
    public function getDepartment()
    {
        if ($this->getData('department') instanceof Betanet_Helpdesk_Model_Department) {
            return $this->getData('department');
        }

        $this->setData('department', Mage::getModel('betanet_helpdesk/department')->load($this->getData('department_id')));

        return $this->getData('department');
    }

    /**
     * Get status model
     *
     * @return Betanet_Helpdesk_Model_Department|Mage_Core_Model_Abstract
     */
    public function getStatus()
    {
        if ($this->getData('status') instanceof Betanet_Helpdesk_Model_Status) {
            return $this->getData('status');
        }

        $this->setData('status', Mage::getModel('betanet_helpdesk/status')->load($this->getData('status_id')));

        return $this->getData('status');
    }
}