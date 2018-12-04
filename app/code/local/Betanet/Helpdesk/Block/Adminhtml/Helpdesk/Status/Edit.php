<?php

class Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Status_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'status_id';
        $this->_controller = 'helpdesk_status';
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
        $model = Mage::registry('betanet_helpdesk/status');
        return $model->getId()
            ? $this->__('Edit [%s] Status', $model->getTitle())
            : $this->__('Create new Status');
    }
}
