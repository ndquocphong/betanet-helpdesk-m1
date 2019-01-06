<?php

class Betanet_Helpdesk_Adminhtml_Helpdesk_ReplyController extends Mage_Adminhtml_Controller_Action
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

        if (!isset($data['status_id']) || !isset($data['user_id']) || !isset($data['ticket_id'])) {
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

        $pic = Mage::getModel('betanet_helpdesk/pic')->load($data['user_id'], 'user_id');
        if (!$pic->getId()) {
            $result = ['message' => 'The pic with user_id' .$data['user_id']. ' does not exists'];
            return $this->getResponse()
                ->setHeader('Content-Type', 'application/json')
                ->setHttpResponseCode(404)
                ->setBody(Mage::helper('core')->jsonEncode($result));
        }
        if ($pic->getId() != $ticket->getPicId()) {
            $result = ['message' => 'You can not reply on this ticket.'];
            return $this->getResponse()
                ->setHeader('Content-Type', 'application/json')
                ->setHttpResponseCode(403)
                ->setBody(Mage::helper('core')->jsonEncode($result));
        }

        try {
            $reply = Mage::getModel('betanet_helpdesk/reply');
            $reply->setData([
                'pic_id' => $pic->getId(),
                'status_id' => $data['status_id'],
                'ticket_id' => $ticket->getId()
            ]);

            if (!empty($data['message'])) {
                $message = $data['message'];
            } else {
                if ($ticket->getStatus()->getId() === $reply->getStatus()->getId()) {
                    $message = sprintf(
                        'Changed status to %s',
                        $ticket->getStatus()->getTitle()
                    );
                } else {
                    $message = sprintf(
                        'Changed status from %s to %s',
                        $ticket->getStatus()->getTitle(),
                        $reply->getStatus()->getTitle()
                    );
                }
            }
            $reply->setMessage($message);
            $reply->save();

            Mage::getSingleton('betanet_helpdesk/event_newReplyPicEvent')
                ->setReply($reply)
                ->dispatch();

            $ticket->setStatusId($data['status_id']);
            $ticket->save();

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