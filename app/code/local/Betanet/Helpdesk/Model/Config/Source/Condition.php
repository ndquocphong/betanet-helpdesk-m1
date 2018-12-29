<?php

class Betanet_Helpdesk_Model_Config_Source_Condition
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
            $collection = Mage::getModel('betanet_helpdesk/condition_collection');
            foreach ($collection->getData() as $condition) {
                $this->data[$condition->getId()] = Mage::helper('core')->__('title_' . $condition->getId());
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

    /**
     * To json [{"value":"", "label": ""}]
     *
     * @return string
     */
    public function toOptionJson()
    {
        return json_encode($this->toOptionArray());
    }
}
