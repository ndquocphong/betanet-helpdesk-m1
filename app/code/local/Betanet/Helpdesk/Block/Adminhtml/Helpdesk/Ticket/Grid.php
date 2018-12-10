<?php

class Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Ticket_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Department_Grid constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->setIdFieldName('betanet_helpdesk_ticket_grid');
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
        $collection = Mage::getModel('betanet_helpdesk/ticket')->getCollection();
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
        $this->addColumn('ticket_id', [
            'header' => strtoupper($this->__('Id')),
            'align' => 'left',
            'width' => '20px',
            'index' => 'ticket_id'
        ]);

        $this->addColumn('title', [
            'header' => $this->__('Title'),
            'align' => 'left',
            'index' => 'title'
        ]);

        $this->addColumn('status_id', [
            'header' => $this->__('Status'),
            'index' => 'status_id',
            'type' => 'options',
            'align' => 'center',
            'frame_callback' => [$this, 'rendererColorCssClass'],
            'options' => Mage::getSingleton('betanet_helpdesk/config_source_status')->toArray()
        ]);

        $this->addColumn('priority_id', [
            'header' => $this->__('Priority'),
            'index' => 'priority_id',
            'type' => 'options',
            'align' => 'center',
            'frame_callback' => [$this, 'rendererColorCssClass'],
            'options' => Mage::getSingleton('betanet_helpdesk/config_source_priority')->toArray()
        ]);

        $this->addColumn('department_id', [
            'header' => $this->__('Department'),
            'index' => 'department_id',
            'type' => 'options',
            'options' => Mage::getSingleton('betanet_helpdesk/config_source_department')->toArray()
        ]);

        $this->addColumn('customer_email', [
            'header' => $this->__('Customer Email'),
            'index' => 'customer_email',
            'type' => 'text',
        ]);

        $this->addColumn('customer_name', [
            'header' => $this->__('Customer Name'),
            'index' => 'customer_name',
            'type' => 'text',
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
        if (Mage::getSingleton('admin/session')->isAllowed('betanet_helpdesk/ticket/save')) {
            $actions[] = [
                'caption' => $this->__('Edit'),
                'url' => [
                    'base' => '*/*/edit'
                ],
                'field' => 'ticket_id'
            ];
        }
        if (Mage::getSingleton('admin/session')->isAllowed('betanet_helpdesk/ticket/delete')) {
            $actions[] = [
                'caption' => $this->__('Delete'),
                'url' => [
                    'base' => '*/*/delete',
                ],
                'confirm' => $this->__('Are you sure you want to do this?'),
                'field' => 'ticket_id'
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
        $this->setMassactionIdField('ticket_id');
        $this->getMassactionBlock()->setFormFieldName('ticket_ids');

        if (Mage::getSingleton('admin/session')->isAllowed('betanet_helpdesk/ticket/save')) {
            $this->getMassactionBlock()->addItem('enable', [
                'label' => $this->__('Enable'),
                'url' => $this->getUrl('*/*/massEnable'),
                'confirm' => $this->__('Are you sure you want to do this?')
            ]);
        }

        if (Mage::getSingleton('admin/session')->isAllowed('betanet_helpdesk/ticket/save')) {
            $this->getMassactionBlock()->addItem('disable', [
                'label' => $this->__('Disable'),
                'url' => $this->getUrl('*/*/massDisable'),
                'confirm' => $this->__('Are you sure you want to do this?')
            ]);
        }

        if (Mage::getSingleton('admin/session')->isAllowed('betanet_helpdesk/ticket/delete')) {
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
    public function rendererColorCssClass($renderedValue, $row, $column, $isExport)
    {
        return '<div class="' . $column->getId() . '-'.$row->getData($column->getIndex()).'">' . $renderedValue . '</div>';
    }
}
