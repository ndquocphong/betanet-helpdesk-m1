<?php

abstract class Betanet_Helpdesk_Model_AbstractEvent extends Varien_Object implements Betanet_Helpdesk_Model_EventInterface
{

    /**
     * Dispatch event
     *
     * @param $eventArgs
     */
    public function dispatch($eventArgs)
    {
        /** @var Betanet_Helpdesk_Model_Workflow $workflow */
        foreach ($this->getEnabledWorkflows() as $workflow) {
            $workflow->execute($eventArgs);
        }
    }

    /**
     * Get workflow
     *
     * @return Betanet_Helpdesk_Model_Resource_Workflow_Collection
     */
    public function getWorkflows()
    {
        $collection = Mage::getModel('betanet_helpdesk/workflow')
                ->getCollection()
                ->addFieldToFilter('event_id', $this->getId());

        return $collection;
    }

    /**
     * Get enabled workflow
     *
     * @return Betanet_Helpdesk_Model_Resource_Workflow_Collection
     */
    public function getEnabledWorkflows()
    {
        $collection = $this->getWorkflows();
        $collection->addFieldToFilter('enabled', true);

        return $collection;
    }
}
