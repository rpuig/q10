<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ChatController extends BaseController
{
    public function index()
    {

        $data=$this->data;
		$data['seo_title'] = 'Chat';
        // Load the chat view
        return view('users/messages/chat/index',$data);
    }

    public function getMessages($user_id, $recipient_id)
    {
        // Fetch messages between the two users from the database
        $messages = $this->chatModel->getMessagesBetweenUsers($user_id, $recipient_id);
        return $this->response->setJSON($messages);
    }

    public function saveMessage()
    {
        $sender_id = $this->request->getPost('sender_id');
        $recipient_id = $this->request->getPost('recipient_id');
        $message = $this->request->getPost('message');

        // Save the message to the database
        $this->chatModel->saveMessage($sender_id, $recipient_id, $message);

        return $this->response->setJSON(['status' => 'success']);
    }
}