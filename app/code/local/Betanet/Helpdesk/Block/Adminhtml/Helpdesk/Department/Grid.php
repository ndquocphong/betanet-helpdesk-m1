<?php

class Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Department_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Department_Grid constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->setIdFieldName('betanet_helpdesk_department_grid');
        $this->setDefaultSort('department_id');
        $this->setDefaultDir('DESC');
    }

    /**
     * {@inheritdoc}
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('betanet_helpdesk/department')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * {@inheritdoc}
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');

        return parent::_afterLoadCollection();
    }

    /**
     * {@inheritdoc}
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     * @throws Exception
     */
    protected function _prepareColumns()
    {
        $this->addColumn('department_id', [
            'header' => strtoupper($this->__('Id')),
            'align' => 'left',
            'width' => '20px',
            'index' => 'department_id'
        ]);

        $this->addColumn('title', [
            'header' => $this->__('Title'),
            'align' => 'left',
            'index' => 'title'
        ]);


        $this->addColumn('enabled', [
            'header' => $this->__('Enabled'),
            'align' => 'text',
            'width' => '50px',
            'index' => 'enabled',
            'type' => 'options',
            'options' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray()
        ]);

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', [
                'header' => $this->__('Store View'),
                'index' => 'store_id',
                'type' => 'store',
                'store_all' => true,
                'store_view' => true,
                'sortable' => false,
                'filter_condition_callback' => [$this, '_filterStoreCondition']
            ]);
        }

        $this->addColumn('view_role_id', [
            'header' => $this->__('View Role'),
            'index' => 'view_role_id',
            'type' => 'options',
            'options' => Mage::getModel('betanet_helpdesk/system_config_source_role')->toArray(),
            'sortable' => false,
            'filter_condition_callback' => [$this, '_filterRoleCondition']
        ]);

        $this->addColumn('edit_role_id', [
            'header' => $this->__('Edit Role'),
            'index' => 'edit_role_id',
            'type' => 'options',
            'options' => Mage::getModel('betanet_helpdesk/system_config_source_role')->toArray(),
            'sortable' => false,
            'filter_condition_callback' => [$this, '_filterRoleCondition']
        ]);

        $this->addColumn('assign_role_id', [
            'header' => $this->__('Assign Role'),
            'index' => 'assign_role_id',
            'type' => 'options',
            'options' => Mage::getModel('betanet_helpdesk/system_config_source_role')->toArray(),
            'sortable' => false,
            'filter_condition_callback' => [$this, '_filterRoleCondition']
        ]);

        $this->addColumn('created_at', [
            'header' => strtoupper($this->__('Created At')),
            'index' => 'created_at',
            'type' => 'datetime'
        ]);
        $this->addColumn('updated_at', [
            'header' => strtoupper($this->__('Updated At')),
            'index' => 'updated_at',
            'type' => 'datetime'
        ]);

        $actions = [];
        if (Mage::getSingleton('admin/session')->isAllowed('betanet_helpdesk/department/save')) {
            $actions[] = [
                'caption' => $this->__('Edit'),
                'url' => [
                    'base' => '*/*/edit'
                ],
                'field' => 'department_id'
            ];
        }
        if (Mage::getSingleton('admin/session')->isAllowed('betanet_helpdesk/department/delete')) {
            $actions[] = [
                'caption' => $this->__('Delete'),
                'url' => [
                    'base' => '*/*/delete',
                ],
                'confirm' => $this->__('Are you sure you want to do this?'),
                'field' => 'department_id'
            ];
        }
        $this->addColumn('actions', [
            'header' => $this->__('Actions'),
            'width' => '100px',
            'sortable' => false,
            'filter' => false,
            'type' => 'action',
            'getter' => 'getId',
            'actions' => $actions,
        ]);

        return parent::_prepareColumns();
    }

    /**
     * {@inheritdoc}
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('department_id');
        $this->getMassactionBlock()->setFormFieldName('department_ids');

        if (Mage::getSingleton('admin/session')->isAllowed('betanet_helpdesk/department/save')) {
            $this->getMassactionBlock()->addItem('enable', [
                'label' => $this->__('Enable'),
                'url' => $this->getUrl('*/*/massEnable'),
                'confirm' => $this->__('Are you sure you want to do this?')
            ]);
        }

        if (Mage::getSingleton('admin/session')->isAllowed('betanet_helpdesk/department/save')) {
            $this->getMassactionBlock()->addItem('disable', [
                'label' => $this->__('Disable'),
                'url' => $this->getUrl('*/*/massDisable'),
                'confirm' => $this->__('Are you sure you want to do this?')
            ]);
        }

        if (Mage::getSingleton('admin/session')->isAllowed('betanet_helpdesk/department/delete')) {
            $this->getMassactionBlock()->addItem('delete', [
                'label' => $this->__('Delete'),
                'url' => $this->getUrl('*/*/massDelete'),
                'confirm' => $this->__('Are you sure you want to do this?')
            ]);
        }

        return parent::_prepareMassaction();
    }

    /**
     * Callback which allow filter by store
     *
     * @param $collection
     * @param $column
     */
    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }

        $this->getCollection()->addStoreFilter($value);
    }

    /**
     * Callback which allow filter by role
     *
     * @param $collection
     * @param $column
     */
    protected function _filterRoleCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }

        $action = str_replace('_role_id', '', $column->getIndex());
        $this->getCollection()->addRoleFilter($value, $action);
    }
}
