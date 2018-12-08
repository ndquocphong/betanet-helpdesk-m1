<?php

class Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Department_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Department_Edit_Form constructor.
     * @param array $args
     */
    public function __construct(array $args = array())
    {
        parent::__construct($args);
        $this->setId('betanet_helpdesk_department_form');
        $this->setTitle('Department Information');
    }

    /**
     * {@inheritdoc}
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $model = Mage::registry('betanet_helpdesk/department');

        $form = new Varien_Data_Form([
            'id' => 'edit_form',
            'method' => 'post',
            'action' => $this->getData('action')
        ]);
        $form->setHtmlIdField('department');

        $fieldset = $form->addFieldset('base_fieldset', [
            'legend' => $this->__('General Information'),
            'class' => 'fieldset-wide'
        ]);

        if ($model->getId()) {
            $fieldset->addField('department_id', 'hidden', [
                'name' => 'department_id'
            ]);
        }

        $fieldset->addField('title', 'text', [
            'name' => 'title',
            'label' => $this->__('Title'),
            'title' => $this->__('Title'),
            'required' => true
        ]);

        $fieldset->addField('enabled', 'select', [
            'name' => 'enabled',
            'label' => $this->__('Enabled'),
            'title' => $this->__('Enabled'),
            'required' => true,
            'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
        ]);
        if (!$model->getId()) {
            $model->setData('enabled', '1');
        }

        if (!Mage::app()->isSingleStoreMode()) {
            $field = $fieldset->addField('store_id', 'multiselect', [
                'name'      => 'store_id[]',
                'label'     => $this->__('Store View'),
                'title'     => $this->__('Store View'),
                'required'  => true,
                'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
            ]);
            $renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
            $field->setRenderer($renderer);
        }
        else {
            $fieldset->addField('store_id', 'hidden', array(
                'name'      => 'store_id[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            $model->setStoreId(Mage::app()->getStore(true)->getId());
        }

        $fieldset->addField('view_role_id', 'multiselect', [
            'name' => 'view_role_id[]',
            'label' => $this->__('Who can view tickets in that department'),
            'title' => $this->__('Who can view tickets in that department'),
            'required' => true,
            'values' => Mage::getModel('betanet_helpdesk/system_config_source_role')->toOptionArray()
        ]);

        $fieldset->addField('edit_role_id', 'multiselect', [
            'name' => 'edit_role_id[]',
            'label' => $this->__('Who can edit tickets in that department'),
            'title' => $this->__('Who can edit tickets in that department'),
            'required' => true,
            'values' => Mage::getModel('betanet_helpdesk/system_config_source_role')->toOptionArray()
        ]);

        $fieldset->addField('assign_role_id', 'multiselect', [
            'name' => 'assign_role_id[]',
            'label' => $this->__('Who can assign tickets in that department'),
            'title' => $this->__('Who can assign tickets in that department'),
            'required' => true,
            'values' => Mage::getModel('betanet_helpdesk/system_config_source_role')->toOptionArray()
        ]);

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);


        return parent::_prepareForm();
    }
}
