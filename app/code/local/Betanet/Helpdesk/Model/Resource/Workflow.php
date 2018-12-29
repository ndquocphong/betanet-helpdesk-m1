<?php

class Betanet_Helpdesk_Model_Resource_Workflow extends Betanet_Helpdesk_Model_Resource_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('betanet_helpdesk/workflow', 'workflow_id');
    }

    /**
     * {@inheritdoc}
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Mage_Core_Model_Resource_Db_Abstract
     */
    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        $adapter = $this->_getReadAdapter();
        $select = $adapter->select()
            ->from($this->getTable('betanet_helpdesk/workflow_condition'), ['condition_id', 'value'])
            ->where('workflow_id = ?', $object->getId());


        $object->setData('conditions', $adapter->fetchAll($select));
        $object->setOrigData('conditions', $object->getData('conditions'));

        $select = $adapter->select()
            ->from($this->getTable('betanet_helpdesk/workflow_action'), ['action_id', 'value'])
            ->where('workflow_id = ?', $object->getId());


        $object->setData('actions', $adapter->fetchAll($select));
        $object->setOrigData('actions', $object->getData('actions'));

        return parent::_afterLoad($object);
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

        $table = $this->getTable('betanet_helpdesk/workflow_condition');
        $adapter->delete($table, [
            'workflow_id = ?' => $object->getId(),
        ]);
        if ($object->getData('conditions')) {
            $data = [];
            foreach ($object->getData('conditions') as $condition) {
                $data[] = [
                    'workflow_id' => $object->getId(),
                    'condition_id' => $condition['condition_id'],
                    'value' => is_array($condition['value'])
                        ? implode(',', $condition['value'])
                        : $condition['value']
                ];
            }
            $adapter->insertMultiple($table, $data);
        }

        $table = $this->getTable('betanet_helpdesk/workflow_action');
        $adapter->delete($table, [
            'workflow_id = ?' => $object->getId(),
        ]);
        if ($object->getData('actions')) {
            $data = [];
            foreach ($object->getData('actions') as $condition) {
                $data[] = [
                    'workflow_id' => $object->getId(),
                    'action_id' => $condition['action_id'],
                    'value' => is_array($condition['value'])
                        ? implode(',', $condition['value'])
                        : $condition['value']
                ];
            }
            $adapter->insertMultiple($table, $data);
        }

        return parent::_afterSave($object);
    }

    /**
     * {@inheritdoc}
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Mage_Cms_Model_Resource_Page
     */
    protected function _beforeDelete(Mage_Core_Model_Abstract $object)
    {
        $this->_getWriteAdapter()->delete($this->getTable('betanet_helpdesk/workflow_condition'), [
            'workflow_id = ?' => $object->getId(),
        ]);
        $this->_getWriteAdapter()->delete($this->getTable('betanet_helpdesk/workflow_action'), [
            'workflow_id = ?' => $object->getId(),
        ]);

        return parent::_beforeDelete($object);
    }
}
