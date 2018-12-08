<?php

class Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Ticket_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Ticket_Edit constructor.
     */
    public function __construct()
    {
        $this->_objectId = 'ticket_id';
        $this->_controller = 'helpdesk_ticket';
        $this->_blockGroup = 'betanet_helpdesk_adminhtml';

        parent::__construct();

        $this->addButton('saveandcontinue', [
            'label' => $this->__('Save and Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
        ], -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getHeaderText()
    {
        $model = Mage::registry('betanet_helpdesk/ticket');
        return $model->getId()
            ? $this->__('Edit [%s] Ticket', $model->getTitle())
            : $this->__('Create new Ticket');
    }
}
