<?php

class Betanet_Helpdesk_Block_Adminhtml_Helpdesk_Priority_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct(array $args = array())
    {
        parent::__construct($args);
        $this->setId('betanet_helpdesk_priority_form');
        $this->setTitle($this->__('Priority Information'));
    }

    /**
     * {@inheritdoc}
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $model = Mage::registry('betanet_helpdesk/priority');

        $form = new Varien_Data_Form([
            'id' => 'edit_form',
            'method' => 'post',
            'action' => $this->getData('action')
        ]);
        $form->setHtmlIdPrefix('priority');

        $fieldset = $form->addFieldset('base_fieldset', [
            'legend' => $this->__('General Information'),
            'class' => 'fieldset-wide'
        ]);

        if ($model->getId()) {
            $fieldset->addField('priority_id', 'hidden', [
                'name' => 'priority_id'
            ]);
        }

        $fieldset->addField('title', 'text', [
            'name' => 'title',
            'label' => $this->__('Title'),
            'title' => $this->__('Title'),
            'required' => true
        ]);

        $fieldset->addField('color', 'text', [
            'name' => 'color',
            'label' => $this->__('Color'),
            'title' => $this->__('Color'),
            'class' => 'jscolor'
        ]);

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
