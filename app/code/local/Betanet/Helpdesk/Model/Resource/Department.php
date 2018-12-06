<?php

class Betanet_Helpdesk_Model_Resource_Department extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('betanet_helpdesk/department', 'department_id');
    }

    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        if ($object->getId()) {
            $stores = $this->lookupStoreIds($object->getId());
            $object->setData('store_id', $stores);
            $object->setData('stores', $stores);
        }

        return parent::_afterLoad($object);
    }

    /**
     * Get store ids from department id
     *
     * @param $departmentId
     * @return array
     */
    public function lookupStoreIds($departmentId)
    {
        $adapter = $this->_getReadAdapter();
        $select = $adapter->select()
            ->from($this->getTable('betanet_helpdesk/department_store'), ['store_id'])
            ->where('department_id = :department_id');
        $binds = [
            ':department_id' => (int)$departmentId
        ];

        return $adapter->fetchCol($select, $binds);
    }
}
