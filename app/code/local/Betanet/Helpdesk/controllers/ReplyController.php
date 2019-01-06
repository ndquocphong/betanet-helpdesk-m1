<?php

class Betanet_Helpdesk_ReplyController extends Mage_Core_Controller_Front_Action
{
    public function submitAction()
    {
        $data = $this->getRequest()->getPost();
        if (empty($data)) {
            $result = ['message' => 'Method not allowed'];
            return $this->getResponse()
                ->setHeader('Content-Type', 'application/json')
                ->setHttpResponseCode(405)
                ->setBody(Mage::helper('core')->jsonEncode($result));
        }

        if (!isset($data['customer_id']) || !isset($data['ticket_id']) || empty($data['message'])) {
            $result = ['message' => 'Parameter invalid'];
            return $this->getResponse()
                ->setHeader('Content-Type', 'application/json')
                ->setBody(Mage::helper('core')->jsonEncode($result));
        }

        $ticket = Mage::getModel('betanet_helpdesk/ticket')->load($data['ticket_id']);
        if (!$ticket->getId()) {
            $result = ['message' => 'The ticket ' .$data['ticket_id']. 'does not exists'];
            return $this->getResponse()
                ->setHeader('Content-Type', 'application/json')
                ->setHttpResponseCode(404)
                ->setBody(Mage::helper('core')->jsonEncode($result));
        }

        if ($data['customer_id'] != $ticket->getCustomerId()) {
            $result = ['message' => 'You can not reply on this ticket.'];
            return $this->getResponse()
                ->setHeader('Content-Type', 'application/json')
                ->setHttpResponseCode(403)
                ->setBody(Mage::helper('core')->jsonEncode($result));
        }

        try {
            $reply = Mage::getModel('betanet_helpdesk/reply');
            $reply->setData([
                'customer_id' => $data['customer_id'],
                'ticket_id' => $ticket->getId(),
                'message' => $data['message'],
                'status_id' => $ticket->getStatus()->getId()
            ]);
            $reply->save();

            Mage::getSingleton('betanet_helpdesk/event_newReplyCustomerEvent')
                ->setReply($reply)
                ->dispatch();

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


        $result = [
            'message' => 'Submitted',
            'payload' => [
                'message' => $reply->getMessage(),
                'status' => [
                    'id' => $reply->getStatus()->getId(),
                    'title' => $reply->getStatus()->getTitle()
                ],
                'author' => [
                    'fullname' => $reply->getAuthorFullName()
                ],
                'date' => Mage::helper('core')->formatDate($reply->getCreatedAt(), Mage_Core_Model_Locale::FORMAT_TYPE_SHORT, true)
            ]
        ];
        return $this->getResponse()
            ->setHeader('Content-Type', 'application/json')
            ->setHttpResponseCode(200)
            ->setBody(Mage::helper('core')->jsonEncode($result));
    }
}