<?php

class Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Workflow_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct(array $args = array())
    {
        parent::__construct($args);
        $this->setId('betanet_helpdesk_workflow_form');
        $this->setTitle($this->__('Workflow Information'));
    }

    /**
     * {@inheritdoc}
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $model = Mage::registry('betanet_helpdesk/workflow');

        $form = new Varien_Data_Form([
            'id' => 'edit_form',
            'method' => 'post',
            'action' => $this->getData('action')
        ]);
        $form->setHtmlIdPrefix('workflow');

        $fieldset = $form->addFieldset('base_fieldset', [
            'legend' => $this->__('General Information'),
            'class' => 'fieldset-wide'
        ]);

        if ($model->getId()) {
            $fieldset->addField('workflow_id', 'hidden', [
                'name' => 'workflow_id'
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
            'values' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
        ]);

        $fieldset->addField('priority', 'text', [
            'name' => 'priority',
            'label' => $this->__('Priority'),
            'title' => $this->__('Priority'),
            'required' => true,
        ]);
        if (!$model->getId()) {
            $model->setEnabled(1);
            $model->setPriority(0);
        }


        $fieldset->addField('event_id', 'select', [
            'name' => 'event_id',
            'label' => $this->__('Event'),
            'title' => $this->__('Event'),
            'values' => Mage::getSingleton('betanet_helpdesk/config_source_event')->toOptionArray()
        ]);

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
