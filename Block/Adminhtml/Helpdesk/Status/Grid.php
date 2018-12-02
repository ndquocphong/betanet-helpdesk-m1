<?php

class Betanet_HelpDesk_Block_Adminhtml_Helpdesk_Status_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Betanet_HelpDesk_Block_Adminhtml_Status_Grid constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->setId('betanetHelpDeskStatusGrid');
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
            'index' => 'title'
        ]);

        $this->addColumn('actions', [
            'header' => Mage::helper('betanet_helpdesk')->__('Actions'),
            'width' => '100px',
            'sortable' => false,
            'filter' => false,
            'type' => 'action',
            'getter' => 'getId',
            'actions' => [
                [
                    'caption' => Mage::helper('betanet_helpdesk')->__('Edit'),
                    'url' => [
                        'base' => '*/*/edit'
                    ],
                    'field' => 'status_id'
                ],
                [
                    'caption' => Mage::helper('betanet_helpdesk')->__('Delete'),
                    'url' => [
                        'base' => '*/*/delete',
                    ],
                    'confirm' => $this->__('Are you sure you want to do this?'),
                    'field' => 'status_id'
                ]
            ],
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

        $this->getMassactionBlock()->addItem('delete', [
            'label' => $this->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => $this->__('Are you sure you want to do this?')
        ]);

        return parent::_prepareMassaction();
    }
}
