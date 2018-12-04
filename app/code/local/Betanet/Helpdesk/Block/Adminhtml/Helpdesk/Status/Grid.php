<?php

class Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Status_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Betanet_Helpdesk_Block_Adminhtml_Status_Grid constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->setId('betanet_helpdesk_status_grid');
        $this->setDefaultSort('status_id');
        $this->setDefaultDir('DESC');
    }

    /**
     * {@inheritdoc}
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('betanet_helpdesk/status')->getCollection();
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
        $this->addColumn('status_id', [
            'header' => strtoupper(Mage::helper('betanet_helpdesk')->__('Id')),
            'align' => 'left',
            'index' => 'status_id',
            'width' => '20px'
        ]);

        $this->addColumn('title', [
            'header' => Mage::helper('betanet_helpdesk')->__('Title'),
            'align' => 'left',
            'index' => 'title',
            'renderer' => 'betanet_helpdesk_adminhtml/helpdesk_widget_grid_column_renderer_colortext'
        ]);

        $massActions = [];
        if (Mage::getSingleton('admin/session')->isAllowed('betanet_helpdesk/status/save')) {
            $massActions[] = [
                'caption' => $this->__('Edit'),
                'url' => [
                    'base' => '*/*/edit'
                ],
                'field' => 'status_id'
            ];
        }
        if (Mage::getSingleton('admin/session')->isAllowed('betanet_helpdesk/status/delete')) {
            $massActions[] = [
                'caption' => Mage::helper('betanet_helpdesk')->__('Delete'),
                'url' => [
                    'base' => '*/*/delete',
                ],
                'confirm' => $this->__('Are you sure you want to do this?'),
                'field' => 'status_id'
            ];
        }

        $this->addColumn('actions', [
            'header' => Mage::helper('betanet_helpdesk')->__('Actions'),
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
        $this->setMassactionIdField('status_id');
        $this->getMassactionBlock()->setFormFieldName('status_ids');

        if (Mage::getSingleton('admin/session')->isAllowed('betanet_helpdesk/status/delete')) {
            $this->getMassactionBlock()->addItem('delete', [
                'label' => $this->__('Delete'),
                'url' => $this->getUrl('*/*/massDelete'),
                'confirm' => $this->__('Are you sure you want to do this?')
            ]);
        }

        return parent::_prepareMassaction();
    }
}
