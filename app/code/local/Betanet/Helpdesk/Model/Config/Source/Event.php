<?php

class Betanet_Helpdesk_Model_Config_Source_Event
{
    /**
     * @var null|array
     */
    protected $data = null;

    /**
     * To array ['value' => 'label']
     *
     * @return array
     */
    public function toArray()
    {
        if (!isset($this->data)) {
            $collection = Mage::getModel('betanet_helpdesk/event_collection');
            foreach ($collection->getData() as $event) {
                $this->data[$event->getId()] = Mage::helper('core')->__('title_' . $event->getId());
            }
        }

        return $this->data;
    }

    /**
     * To array ['value' => , 'label' => ]
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        foreach ($this->toArray() as $value => $label) {
            $options[] = [
                'value' => $value,
                'label' => $label
            ];
        }

        return $options;
    }
}
