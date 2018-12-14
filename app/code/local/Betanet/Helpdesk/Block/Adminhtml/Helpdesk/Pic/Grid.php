<?php

class Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Pic_Grid extends Mage_Adminhtml_Block_Permissions_User_Grid
{

    /**
     * {@inheritdoc}
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        /** @var Mage_Admin_Model_Resource_User_Collection $collection */
        $collection = Mage::getResourceModel('admin/user_collection');
        $this->setCollection($collection);
        $collection->getSelect()->joinLeft(
            ['pic_table' => $collection->getTable('betanet_helpdesk/pic')],
            'main_table.user_id = pic_table.user_id',
            []
        )->columns([
            'is_pic' => new Zend_Db_Expr('ISNULL(pic_table.user_id)')
        ]);
        $this->setCollection($collection);

        return Mage_Adminhtml_Block_Widget_Grid::_prepareCollection();
    }

    /**
     * {@inheritdoc}
     *
     * @return Mage_Adminhtml_Block_Permissions_User_Grid
     */
    protected function _prepareColumns()
    {
        $result = parent::_prepareColumns();
        $this->addColumnAfter('is_pic', [
            'type' => 'checkbox',
            'header' => 'PIC',
            'index' => 'is_pic',
            'field_name' => 'is_pic',
            'value' => '0',
            'filter_condition_callback' => [$this, '_filterIsPic']
        ], 'is_active');

        return $result;
    }

    /**
     * Filter is_pic callback
     *
     * @param $collection
     * @param $column
     */
    protected function _filterIsPic($collection, $column)
    {
        $value = $column->getFilter()->getValue();

        if ($value === '1') {
            $this->getCollection()->getSelect()->where('pic_table.user_id IS NOT NULL');
        } else if ($value === '0') {
            $this->getCollection()->getSelect()->where('pic_table.user_id IS NULL');
        }

    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('adminhtml/helpdesk_pic/grid', array());
    }

    /**
     * {@inheritdoc}
     *
     * @param $row
     * @return bool|string
     */
    public function getRowUrl($row)
    {
        return false;
    }
}
