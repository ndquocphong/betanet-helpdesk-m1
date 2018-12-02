<?php

class Betanet_HelpDesk_Block_Adminhtml_Status_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->setId('betanetHelpDeskStatusGrid');
        $this->setDefaultSort('status_id');
        $this->setDefaultDir('DESC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('betanet_helpdesk/status')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('status_id', [
            'header' => strtoupper(Mage::helper('betanet_helpdesk')->__('Id')),
            'align' => 'left',
            'index' => 'status_id'
        ]);

        $this->addColumn('title', [
            'header' => Mage::helper('betanet_helpdesk')->__('Title'),
            'align' => 'left',
            'index' => 'title'
        ]);

        return parent::_prepareColumns();
    }
}
