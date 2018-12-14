<?php

class Betanet_Helpdesk_Adminhtml_Helpdesk_PicController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('betanet_helpdesk/pic');
        $this->_title($this->__('Help Desk'))->_title($this->__('PIC Management'));
        $this->_addBreadcrumb($this->__('PIC Management'), $this->__('PIC Management'));
        $this->renderLayout();
    }

    public function updateAction()
    {
        $data = $this->getRequest()->getPost();
        if (empty($data)) {
            $result = ['message' => 'Method not allowed'];
            return $this->getResponse()
                ->setHeader('Content-Type', 'application/json')
                ->setHttpResponseCode(405)
                ->setBody(Mage::helper('core')->jsonEncode($result));
        }

        if (!isset($data['user_id']) || !isset($data['action'])) {
            $result = ['message' => 'Parameter invalid'];
            return $this->getResponse()
                ->setHeader('Content-Type', 'application/json')
                ->setBody(Mage::helper('core')->jsonEncode($result));
        }

        try {
            $model = Mage::getModel('betanet_helpdesk/pic')->load($data['user_id'], 'user_id');
            if ($data['action'] == 'insert') {
                if (!$model->getId()) {
                    $model->setData('user_id', $data['user_id']);
                    $model->save();
                }
            } elseif ($data['action'] == 'remove') {
                if ($model->getId()) {
                    $model->delete();
                }
            }
        } catch (Mage_Core_Exception $e) {
            $result = ['message' => $e->getMessage()];
            return $this->getResponse()
                ->setHeader('Content-Type', 'application/json')
                ->setHttpResponseCode(500)
                ->setBody(Mage::helper('core')->jsonEncode($result));
        } catch (Exception $e) {
            $result = ['message' => 'An error occurred while updating.'];
            return $this->getResponse()
                ->setHeader('Content-Type', 'application/json')
                ->setHttpResponseCode(500)
                ->setBody(Mage::helper('core')->jsonEncode($result));
        }

        $result = ['message' => 'Updated'];
        return $this->getResponse()
            ->setHeader('Content-Type', 'application/json')
            ->setHttpResponseCode(200)
            ->setBody(Mage::helper('core')->jsonEncode($result));
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody($this->getLayout()->getBlock('betanet_helpdesk_pic_grid')->toHtml());
    }
}

