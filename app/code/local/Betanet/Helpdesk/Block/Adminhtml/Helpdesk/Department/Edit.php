<?php

class Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Department_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Department_Edit constructor.
     */
    public function __construct()
    {
        $this->_objectId = 'department_id';
        $this->_controller = 'helpdesk_department';
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
        $model = Mage::registry('betanet_helpdesk/department');
        return $model->getId()
            ? $this->__('Edit [%s] Department', $model->getTitle())
            : $this->__('Create new Department');
    }
}
