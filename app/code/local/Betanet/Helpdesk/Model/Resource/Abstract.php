<?php

abstract class Betanet_Helpdesk_Model_Resource_Abstract extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * @var array
     */
    protected $_manyToMany = [];

    /**
     * {@inheritdoc}
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Mage_Core_Model_Resource_Db_Abstract
     */
    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        foreach ($this->_manyToMany as $fieldId => $table) {
            $object->setData($fieldId, $this->lookupManyToManyIds($object->getId(), $fieldId));
        }

        return parent::_afterLoad($object);
    }

    /**
     * {@inheritdoc}
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Mage_Cms_Model_Resource_Page
     */
    protected function _beforeDelete(Mage_Core_Model_Abstract $object)
    {
        foreach ($this->_manyToMany as $fieldId => $table) {
            if (is_array($table)) {
                list($table, $idFieldName, $extraColumns) = $table;
            }

            $condition = array(
                $object->getIdFieldName() .' = ?' => (int) $object->getId(),
            );

            $this->_getWriteAdapter()->delete($this->getTable($table), $condition);
        }

        return parent::_beforeDelete($object);
    }


    /**
     * {@inheritdoc}
     *
     * @param Mage_Core_Model_Abstract $object
     * @return $this|Mage_Core_Model_Resource_Db_Abstract
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if (!$object->getId()) {
            $object->setData('created_at', Mage::getSingleton('core/date')->gmtDate());
        }
        $object->setData('updated_at', Mage::getSingleton('core/date')->gmtDate());

        return parent::_beforeSave($object);
    }

    /**
     * {@inheritdoc}
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Mage_Core_Model_Resource_Db_Abstract
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        $adapter = $this->_getWriteAdapter();

        foreach ($this->_manyToMany as $fieldId => $table) {
            $oldValues = $this->lookupManyToManyIds($object->getId(), $fieldId);
            $newValues = (array) $object->getData($fieldId);

            if (is_array($table)) {
                list($table, $fieldId, $extraColumns) = $table;
            }

            $insert = array_diff($newValues, $oldValues);
            $delete = array_diff($oldValues, $newValues);

            if ($delete) {
                $where = [
                    $object->getIdFieldName() . ' = ?' => (int) $object->getId(),
                    $fieldId . ' IN (?)' => $delete
                ];
                $adapter->delete($this->getTable($table), $where);
            }

            if ($insert) {
                $data = [];
                foreach ($insert as $insertId) {
                    $row = [
                        $object->getIdFieldName() => (int) $object->getId(),
                        $fieldId => (int) $insertId
                    ];
                    if (isset($extraColumns)) {
                        foreach ($extraColumns as $column => $value) {
                            $row[$column] = $value;
                        }
                    }
                    $data[] = $row;
                }
                $adapter->insertMultiple($this->getTable($table), $data);
            }
        }

        return parent::_afterSave($object);
    }

    /**
     * Get store ids from department id
     *
     * @param $id
     * @param $fieldId
     * @return array
     */
    public function lookupManyToManyIds($id, $fieldId)
    {
        if (!isset($this->_manyToMany[$fieldId])) {
            return [];
        }

        $adapter = $this->_getReadAdapter();
        if (is_array($this->_manyToMany[$fieldId])) {
            list($tableName, $fieldId, $extraColumns) = $this->_manyToMany[$fieldId];
            $tableName = $this->getTable($tableName);
        } else {
            $tableName = $this->getTable($this->_manyToMany[$fieldId]);
        }
        
        $select = $adapter->select()
            ->from($tableName, [$fieldId])
            ->where($this->_idFieldName .' = :department_id');
        $binds = [
            ':' . $this->_idFieldName => (int)$id
        ];

        if (isset($extraColumns)) {
            foreach ($extraColumns as $column => $value) {
                $select->where($column . ' = :' . $column);
                $binds[':' . $column] = $value;
            }
        }

        return $adapter->fetchCol($select, $binds);
    }
}
