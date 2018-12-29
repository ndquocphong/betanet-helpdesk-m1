<?php

class Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Workflow_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Workflow_Grid constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->setIdFieldName('betanet_helpdesk_workflow_grid');
        $this->setDefaultSort('workflow_id');
        $this->setDefaultDir('DESC');
    }

    /**
     * {@inheritdoc}
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('betanet_helpdesk/workflow')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * {@inheritdoc}
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     * @throws Exception
     */
    protected function _prepareColumns()
    {
        $this->addColumn('workflow_id', [
            'header' => strtoupper($this->__('Id')),
            'align' => 'left',
            'width' => '20px',
            'index' => 'workflow_id'
        ]);

        $this->addColumn('title', [
            'header' => $this->__('Title'),
            'align' => 'left',
            'index' => 'title'
        ]);

        $this->addColumn('enabled', [
            'header' => $this->__('Enabled'),
            'index' => 'enabled',
            'type' => 'options',
            'align' => 'center',
            'options' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray()
        ]);

        $this->addColumn('event_id', [
            'header' => $this->__('Event'),
            'index' => 'event_id',
            'align' => 'center',
            'frame_callback' => [$this, 'renderEvent'],
        ]);

        $this->addColumn('priority', [
            'header' => $this->__('Priority'),
            'index' => 'priority',
            'width' => '20px',
            'align' => 'center'
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
        if (Mage::getSingleton('admin/session')->isAllowed('betanet_helpdesk/workflow/save')) {
            $actions[] = [
                'caption' => $this->__('Edit'),
                'url' => [
                    'base' => '*/*/edit'
                ],
                'field' => 'workflow_id'
            ];
        }
        if (Mage::getSingleton('admin/session')->isAllowed('betanet_helpdesk/workflow/delete')) {
            $actions[] = [
                'caption' => $this->__('Delete'),
                'url' => [
                    'base' => '*/*/delete',
                ],
                'confirm' => $this->__('Are you sure you want to do this?'),
                'field' => 'workflow_id'
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
        $this->setMassactionIdField('workflow_id');
        $this->getMassactionBlock()->setFormFieldName('workflow_ids');

        if (Mage::getSingleton('admin/session')->isAllowed('betanet_helpdesk/workflow/delete')) {
            $this->getMassactionBlock()->addItem('delete', [
                'label' => $this->__('Delete'),
                'url' => $this->getUrl('*/*/massDelete'),
                'confirm' => $this->__('Are you sure you want to do this?')
            ]);
        }

        return parent::_prepareMassaction();
    }

    /**
     * Renderer css class
     *
     * @param $renderedValue
     * @param $row
     * @param $column
     * @param $isExport
     * @return string
     */
    public function renderEvent($renderedValue, $row, $column, $isExport)
    {
        return $this->__('title_' . $renderedValue);
    }
}
