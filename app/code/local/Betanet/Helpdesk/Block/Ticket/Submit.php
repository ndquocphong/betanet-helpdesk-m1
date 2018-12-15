<?php

class Betanet_Helpdesk_Block_Ticket_Submit extends Mage_Core_Block_Template
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->setData('form_action', $this->getUrl('helpdesk/ticket/submit'));
        $this->setTemplate('betanet_helpdesk/form/ticket/submit.phtml');

        $model = Mage::getModel('betanet_helpdesk/ticket');
        $customer = Mage::getSingleton('customer/session')->getCustomer();
        if ($customer instanceof Mage_Customer_Model_Customer) {
            $model->setData('customer_name', $customer->getData('firstname') . ' ' . $customer->getData('lastname'));
            $model->setData('customer_email', $customer->getData('email'));
        }
        if (Mage::getSingleton('core/session')->getFormData()) {
            $model->setData(Mage::getSingleton('core/session')->getFormData());
        }
        $this->assign('ticket', $model);

        parent::_construct();
    }

    /**
     * Get department options
     *
     * @return array
     */
    public function getDepartmentOptions()
    {
        return Mage::getSingleton('betanet_helpdesk/config_source_department')->toArray();
    }

    /**
     * Get form data from session
     *
     * @return array|null
     */
    public function getFormData()
    {
        return Mage::getSingleton('core/session')->getFormData();
    }
}
