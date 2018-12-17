<?php

class Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Ticket_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getTabLabel()
    {
        return $this->__('General Information');
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('General Information');
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $model = Mage::registry('betanet_helpdesk/ticket');

        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('ticket');

        $fieldset = $form->addFieldset('general_fieldset', [
            'legend' => $this->__('General Information'),
            'class' => 'fieldset-wide'
        ]);

        if ($model->getId()) {
            $fieldset->addField('ticket_id', 'hidden', [
                'name' => 'ticket_id'
            ]);
        }

        $fieldset->addField('title', 'text', [
            'name' => 'title',
            'label' => $this->__('Title'),
            'title' => $this->__('Title'),
            'required' => true
        ]);

        $fieldset->addField('body', 'textarea', [
            'name' => 'body',
            'label' => $this->__('Body'),
            'title' => $this->__('Body'),
            'required' => true
        ]);

        $fieldset->addField('customer_name', 'text', [
            'name' => 'customer_name',
            'label' => $this->__('Customer Name'),
            'title' => $this->__('Customer Name'),
            'required' => true,
        ]);

        $fieldset->addField('customer_email', 'text', [
            'name' => 'customer_email',
            'label' => $this->__('Customer Email'),
            'title' => $this->__('Customer Email'),
            'required' => true,
            'class' => 'validate-email'
        ]);

        $fieldset->addField('status_id', 'select', [
            'name' => 'status_id',
            'label' => $this->__('Status'),
            'title' => $this->__('Status'),
            'required' => true,
            'options' => Mage::getModel('betanet_helpdesk/config_source_status')->toArray()
        ]);

        $fieldset->addField('priority_id', 'select', [
            'name' => 'priority_id',
            'label' => $this->__('Priority'),
            'title' => $this->__('Priority'),
            'required' => true,
            'options' => Mage::getModel('betanet_helpdesk/config_source_priority')->toArray()
        ]);

        $fieldset->addField('department_id', 'select', [
            'name' => 'department_id',
            'label' => $this->__('Department'),
            'title' => $this->__('Department'),
            'required' => true,
            'options' => Mage::getModel('betanet_helpdesk/config_source_department')->toArray()
        ]);

        $fieldset->addField('pic_id', 'select', [
            'name' => 'pic_id',
            'label' => $this->__('PIC'),
            'title' => $this->__('PIC'),
            'required' => true,
            'options' => Mage::getModel('betanet_helpdesk/config_source_pic')->toArray()
        ]);

        $form->setValues($model->getData());
        $this->setForm($form);


        return parent::_prepareForm();
    }
}
