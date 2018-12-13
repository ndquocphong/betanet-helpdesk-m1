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
        ], 'is_active');

        return $result;
    }

    public function getGridUrl()
    {
        return $this->getUrl('adminhtml/permissions_user/roleGrid', array());
    }
}
