<?php

class Betanet_Helpdesk_Model_Config_Source_Pic
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
            $this->data = [
                '-1' => Mage::helper('betanet_helpdesk')->__('Unassigned')
            ];
            /** @var Mage_Admin_Model_Resource_Role_Collection $collection */
            $collection = Mage::getModel('admin/user')
                ->getCollection()
                ->addFieldToSelect(['user_id', 'username']);
            $collection->getSelect()
                ->joinLeft(
                    ['pic_table' => $collection->getTable('betanet_helpdesk/pic')],
                    'pic_table.user_id = main_table.user_id',
                    ['pic_id']
                )
                ->where('pic_table.user_id IS NOT NULL');

            foreach ($collection->getData() as $role) {
                $this->data[$role['pic_id']] = $role['username'];
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
