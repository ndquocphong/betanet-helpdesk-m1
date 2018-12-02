<?php

class Betanet_HelpDesk_Block_Adminhtml_Helpdesk_Priority_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'priority_id';
        $this->_controller = 'helpdesk_priority';
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
        $model = Mage::registry('betanet_helpdesk/priority');
        return $model->getId()
            ? $this->__('Edit [%s] Priority', $model->getTitle())
            : $this->__('Create new Priority');
    }
}
