<?php

class Betanet_Helpdesk_Model_Workflow extends Mage_Core_Model_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('betanet_helpdesk/workflow');
        $this->setData('conditions', []);
        $this->setOrigData('conditions', []);
        $this->setData('actions', []);
        $this->setOrigData('actions', []);
    }

    /**
     * Check workflow can execute
     *
     * @param Betanet_Helpdesk_Model_EventInterface $event
     * @return bool
     */
    public function canExecute(Betanet_Helpdesk_Model_EventInterface $event)
    {
        foreach ($this->getConditions() as $condition) {
            $conditionModel = Mage::getModel($condition['condition_id'])->setValue($condition['value']);

            $isValid = $conditionModel->isValid($event->getConditionArgs($conditionModel));
            if (!$isValid) {
                return false;
            }
        }

        return true;
    }

    /**
     * Execute logic of workflow
     *
     * @param Betanet_Helpdesk_Model_EventInterface
     */
    public function execute(Betanet_Helpdesk_Model_EventInterface $event)
    {
        foreach ($this->getActions() as $action) {
            $actionModel = Mage::getModel($action['action_id']);
            $actionModel->setValue($action['value'])
                ->execute($event->getActionArgs($actionModel));
        }
    }
}
