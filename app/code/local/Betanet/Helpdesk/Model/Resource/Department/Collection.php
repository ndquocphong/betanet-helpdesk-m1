<?php

class Betanet_Helpdesk_Model_Resource_Department_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('betanet_helpdesk/department');
        $this->_map['fields']['store'] = 'store_table.store_id';
    }


    /**
     * Filter by store view
     *
     * @param $store
     * @param bool $withAdmin
     * @return $this
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        if ($store instanceof Mage_Core_Model_Store) {
            $store = [$store->getId()];
        }

        if (!is_array($store)) {
            $store = (array)$store;
        }

        if ($withAdmin) {
            $store[] = Mage_Core_Model_App::ADMIN_STORE_ID;
        }

        $this->addFilter('store', ['in' => $store], 'public');

        return $this;
    }

    protected function _renderFiltersBefore()
    {
        if ($this->getFilter('store')) {
            $this->getSelect()
                ->join(
                    ['store_table' => $this->getTable('betanet_helpdesk/department_store')],
                    'store_table.department_id = main_table.department_id',
                    []
                )
                ->group('main_table.department_id');
            $this->_useAnalyticFunction = true;
        }

        parent::_renderFiltersBefore();
    }
}
