<?php

class Betanet_Helpdesk_Model_System_Config_Source_Role
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
            $collection = Mage::getModel('admin/role')
                ->getCollection()
                ->setRolesFilter();

            foreach ($collection->getData() as $role) {
                $this->data[$role['role_id']] = $role['role_name'];
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
