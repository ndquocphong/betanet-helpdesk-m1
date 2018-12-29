<?php

class Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Workflow_Edit_Widget extends Mage_Adminhtml_Block_Template
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('betanet_helpdesk/form/workflow/widget.phtml');
    }

    /**
     * Get events as json
     *
     * @return string
     */
    public function getEventsJson()
    {
        return Mage::getSingleton('betanet_helpdesk/config_source_event')->toOptionJson();
    }

    /**
     * Get conditions as json
     *
     * @return string
     */
    public function getConditionsJson()
    {
        return json_encode(array_values(Mage::getSingleton('betanet_helpdesk/condition_collection')->toArray()));
    }

    /**
     * Get actions as json
     *
     * @return string
     */
    public function getActionsJson()
    {
        return json_encode(array_values(Mage::getSingleton('betanet_helpdesk/action_collection')->toArray()));
    }

    /**
     * Get events - conditions relationship
     *
     * @return array
     */
    public function getEventConditionRelations()
    {
        $result = [];
        foreach (Mage::getSingleton('betanet_helpdesk/event_collection')->getData() as $event) {
            $result[$event->getId()] = array_keys($event->getAllowConditions());
        }

        return $result;
    }

    /**
     * Get events - conditions relationship as json
     *
     * @return string
     */
    public function getEventConditionRelationsJson()
    {
        return json_encode($this->getEventConditionRelations());
    }

    /**
     * Get events - actions relationship
     *
     * @return array
     */
    public function getEventActionRelations()
    {
        $result = [];
        foreach (Mage::getSingleton('betanet_helpdesk/event_collection')->getData() as $event) {
            $result[$event->getId()] = array_keys($event->getAllowActions());
        }

        return $result;
    }

    /**
     * Get events - actions relationship as json
     *
     * @return string
     */
    public function getEventActionRelationsJson()
    {
        return json_encode($this->getEventActionRelations());
    }

    /**
     * Get conditions of workflow as json
     *
     * @return string
     */
    public function getInitConditionsJson()
    {
        return json_encode(Mage::registry('betanet_helpdesk/workflow')->getConditions());
    }

    /**
     * Get actions of workflow as json
     *
     * @return string
     */
    public function getInitActionsJson()
    {
        return json_encode(Mage::registry('betanet_helpdesk/workflow')->getActions());
    }
}
