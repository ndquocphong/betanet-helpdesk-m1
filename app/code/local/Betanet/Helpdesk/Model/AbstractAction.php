<?php

abstract class Betanet_Helpdesk_Model_AbstractAction extends Varien_Object implements Betanet_Helpdesk_Model_ActionInterface
{
    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        if (!$this->hasData('id')) {
            $id = implode("_", array_map(function ($v) {return lcfirst($v);}, explode('_', get_class($this))));
            $id = str_replace('_model_', '/', $id);
            $this->setData('id', $id);
        }

        return $this->getData('id');
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getInputValueHtml()
    {
        return '<input type="text" style="width: 100%" class="input-text wide" name="[value]" />';
    }
}
