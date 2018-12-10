<?php

class Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Priority_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Priority_Grid constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->setId('betanet_helpdesk_priority_grid');
        $this->setDefaultSort('priority_id');
        $this->setDefaultDir('DESC');
    }

    /**
     * {@inheritdoc}
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('betanet_helpdesk/priority')->getCollection();
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
        $this->addColumn('priority_id', [
            'header' => strtoupper($this->__('Id')),
            'align' => 'left',
            'index' => 'priority_id',
            'width' => '20px'
        ]);

        $this->addColumn('title', [
            'header' => $this->__('Title'),
            'align' => 'left',
            'index' => 'title',
            'frame_callback' => [$this, 'rendererColorCssClass'],
        ]);

        $massActions = [];
        if (Mage::getSingleton('admin/session')->isAllowed('betanet_helpdesk/priority/save')) {
            $massActions[] = [
                'caption' => $this->__('Edit'),
                'url' => [
                    'base' => '*/*/edit'
                ],
                'field' => 'priority_id'
            ];
        }
        if (Mage::getSingleton('admin/session')->isAllowed('betanet_helpdesk/priority/delete')) {
            $massActions[] = [
                'caption' => $this->__('Delete'),
                'url' => [
                    'base' => '*/*/delete',
                ],
                'confirm' => $this->__('Are you sure you want to do this?'),
                'field' => 'priority_id'
            ];
        }
        $this->addColumn('actions', [
            'header' => $this->__('Actions'),
            'width' => '100px',
            'sortable' => false,
            'filter' => false,
            'type' => 'action',
            'getter' => 'getId',
            'actions' => $massActions,
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
        $this->setMassactionIdField('priority_id');
        $this->getMassactionBlock()->setFormFieldName('priority_ids');

        if (Mage::getSingleton('admin/session')->isAllowed('betanet_helpdesk/priority/delete')) {
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
        return '<div class="priority_id-'.$row->getData('priority_id').'">' . $renderedValue . '</div>';
    }
}
