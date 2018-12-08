<?php

class Betanet_Helpdesk_Model_Resource_Department extends Betanet_Helpdesk_Model_Resource_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('betanet_helpdesk/department', 'department_id');
        
        $this->_manyToMany = [
            'store_id' => 'betanet_helpdesk/department_store',
            'view_role_id' => [
                'betanet_helpdesk/department_role',
                'role_id',
                ['action' => 'view']
            ],
            'edit_role_id' => [
                'betanet_helpdesk/department_role',
                'role_id',
                ['action' => 'edit']
            ],
            'assign_role_id' => [
                'betanet_helpdesk/department_role',
                'role_id',
                ['action' => 'assign']
            ]
        ];
    }
}
