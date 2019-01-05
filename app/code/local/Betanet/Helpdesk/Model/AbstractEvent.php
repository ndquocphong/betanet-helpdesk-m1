<?php

abstract class Betanet_Helpdesk_Model_AbstractEvent extends Varien_Object implements Betanet_Helpdesk_Model_EventInterface
{
    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        if (!$this->hasData('id')) {
            $id = implode("_", array_map(function ($v) {return lcfirst($v);}, explode('_', get_class($this))));
            $id = str_replace('_model_', '/', $id);
            $this->setData('id', $id);
        }

        return $this->getData('id');
    }

    /**
     * Dispatch event
     */
    public function dispatch()
    {
        /** @var Betanet_Helpdesk_Model_Workflow $workflow */
        foreach ($this->getEnabledWorkflows() as $workflow) {
            if ($workflow->canExecute($this)) {
                $workflow->execute($this);
            }
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
