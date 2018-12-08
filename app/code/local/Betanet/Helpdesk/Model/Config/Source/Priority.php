<?php

class Betanet_Helpdesk_Model_Config_Source_Priority
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
            $this->data = [];
            /** @var Mage_Admin_Model_Resource_Role_Collection $collection */
            $collection = Mage::getModel('betanet_helpdesk/priority')
                ->getCollection()
                ->addFieldToSelect(['priority_id', 'title']);

            foreach ($collection->getData() as $role) {
                $this->data[$role['priority_id']] = $role['title'];
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
