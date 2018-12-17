<?php

class Betanet_Helpdesk_Model_Pic extends Mage_Core_Model_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('betanet_helpdesk/pic');
    }

    /**
     * Get user model
     *
     * @return Mage_Admin_Model_User|Mage_Core_Model_Abstract
     */
    public function getUser()
    {
        if ($this->hasData('user')) {
            return $this->getData('user');
        }

        $this->setData('user', Mage::getModel('admin/user')->load($this->getData('user_id')));

        return $this->getData('user');
    }

    /**
     * Get user full name
     *
     * @return string
     */
    public function getUserFullName()
    {
        return $this->getUser()->getFirstname() . ' ' . $this->getUser()->getLastname();
    }
}
