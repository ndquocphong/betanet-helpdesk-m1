<?php

class Betanet_Helpdesk_Model_Resource_Workflow_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('betanet_helpdesk/workflow');
    }

    /**
     * {@inheritdoc}
     *
     * @return Mage_Core_Model_Resource_Db_Collection_Abstract
     */
    protected function _afterLoad()
    {
        foreach ($this->_items as $item) {
            $this->getResource()->afterLoad($item);
        }

        return parent::_afterLoad();
    }
}
