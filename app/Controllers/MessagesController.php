<?php

namespace App\Controllers;

use App\Models\Messages;
use App\Models\User;
use App\Models\Timestamp;

use CodeIgniter\API\ResponseTrait;

class MessagesController extends BaseController
{
	use ResponseTrait;

	protected $messageModel;
	protected $userModel;

	

	public function __construct()
	{
			$this->messageModel = new Messages();
			$this->userModel = new User();

			
	}




//Show the view of the conversation
	public function conversation($otherUserId)
	{
			$currentUserId = $this->getCurrentUserId();
			$otherUser = $this->userModel->find($otherUserId);
			$data['loggedIn'] = $this->session->get('loggedIn');
				$data['seo_title' ]='Messages';
						$data['currentUserId'] =$currentUserId;
						$data['otherUserId'] = $otherUserId;
						$data['otherUsername'] = $otherUser['username'];
			if (!$otherUser) {
					return $this->failNotFound('User not found');
			}

			return view('users/messages/conversation',$data);
	}



/* 
	public function singleConversation($otherUserId,$page)
	{
			$currentUserId = $this->getCurrentUserId();
			$otherUser = $this->userModel->find($otherUserId);
			$data['loggedIn'] = $this->session->get('loggedIn');
				$data['seo_title' ]='Messages';
						$data['currentUserId'] =$currentUserId;
						$data['otherUserId'] = $otherUserId;
						$data['otherUsername'] = $otherUser['username'];
			if (!$otherUser) {
					return $this->failNotFound('User not found');
			}

			return view('users/messages/conversation',$data);
	} */

/* 	public function AsingleConversation($otherUserId,$page)
	{
			$currentUserId = $this->getCurrentUserId();
			
			// Get unique conversation partners
			$conversationPartners = $this->messageModel
					->select('DISTINCT(CASE 
							WHEN sender_id = ' . $currentUserId . ' THEN receiver_id 
							ELSE sender_id 
					END) as partner_id')
					->groupStart()
							->where('sender_id', $currentUserId)
							->orWhere('receiver_id', $currentUserId)
					->groupEnd()
					->get()
					->getResultArray();
	
			$partners = [];
			foreach ($conversationPartners as $partner) {
					$userDetails = $this->userModel->find($partner['partner_id']);
					$userDetails['profile_picture'] = $this->getProfilePicture($partner['partner_id']);
					$partners[] = $userDetails;
			}
	
			$data = [
					'conversations' => $partners,
					'currentUserId' => $currentUserId
				
			];
			$data['seo_title' ]='Conversations';
			$data['loggedIn'] = $this->session->get('loggedIn');
			return view('users/messages/conversations', $data);
	} */
 
	public function singleConversation($otherUserId, $page)
	{
			$currentUserId = $this->getCurrentUserId();
	
			// Get messages for the conversation
			$messages = $this->messageModel
					->where('(sender_id = ' . $currentUserId . ' AND receiver_id = ' . $otherUserId . ')')
					->orWhere('(sender_id = ' . $otherUserId . ' AND receiver_id = ' . $currentUserId . ')')
					->orderBy('timestamp', 'DESC') // Order messages by timestamp
					->paginate(20, '', $page); // Paginate results (20 messages per page)
	
			foreach ($messages as &$message) {
					// Add additional user details like profile pictures, etc.
					$message['sender_profile_picture'] = $this->getProfilePicture($message['sender_id']);
					$message['receiver_profile_picture'] = $this->getProfilePicture($message['receiver_id']);
			}
	
			// Return JSON response
			return $this->response->setJSON([
					'currentUserId' => $currentUserId,
					'messages' => $messages,
					'page' => $page
			]);
	}
	

	public function conversationsData()
{
    $currentUserId = $this->getCurrentUserId();
    
    // Get unique conversation partners
    $conversationPartners = $this->messageModel
        ->select('DISTINCT(CASE 
            WHEN sender_id = ' . $currentUserId . ' THEN receiver_id 
            ELSE sender_id 
        END) as partner_id')
        ->groupStart()
            ->where('sender_id', $currentUserId)
            ->orWhere('receiver_id', $currentUserId)
        ->groupEnd()
        ->get()
        ->getResultArray();

    $partners = [];
    foreach ($conversationPartners as $partner) {
        $userDetails = $this->userModel->find($partner['partner_id']);
        $userDetails['profile_picture'] = $this->getProfilePicture($partner['partner_id']);
        $partners[] = $userDetails;
    }

    return $this->response->setJSON($partners);
}

public function conversations()
{
	$data['seo_title' ]='Conversations';
	$data['loggedIn'] = $this->session->get('loggedIn');
	return view('users/messages/conversations', $data);
}


	public function sendMessage()
	{
			$rules = [
					'receiver_id' => 'required|numeric',
					'message' => 'required|string|max_length[1000]',
			];

			$timeStamp=new Timestamp();
			$serverTimestamp = $timeStamp->getServerTimestamp();
			if (!$this->validate($rules)) {
					return $this->failValidationErrors($this->validator->getErrors());
			}
	
			$json = $this->request->getJSON();
			$data = [
					'sender_id' => $this->getCurrentUserId(),
					'receiver_id' => $json->receiver_id,
					'message' => htmlspecialchars($json->message, ENT_QUOTES, 'UTF-8') // Sanitize message to prevent XSS
			
				
				];

		    // Generate messageid
				$messageid = $data['sender_id'] . '.' . $data['receiver_id'] . '.' . $serverTimestamp;
				// Ensure messageid fits within the column size
				if (strlen($messageid) > 100) {
						return $this->failServerError('Message ID exceeds maximum length');
				}
		
				$data['messageid'] = $messageid;	


				// Use the query builder with RETURNING clause
				$query = "INSERT INTO userchatmessages (sender_id, receiver_id, message, messageid) 
						VALUES (:sender_id:, :receiver_id:, :message:, :messageid:) 
						RETURNING messageid";

				// Execute the query using CodeIgniter's query method
				$result = $this->messageModel->db->query($query, $data);

				if ($result !== false) {
					// Retrieve the inserted message ID
					$insertedId = $result->getRow()->messageid;
					return $this->respondCreated(['id' => $insertedId]);
				}

				// If insertion failed, return server error
				return $this->failServerError('Failed to send message');
			
	}
	
	public function getProfilePicture($id)

	{
		
		$profPictureURL= PROFILE_PICS_UPLOADS_DIR.$this->userModel->getAllUserProfilePicture($id);
		$profPictureURL=base_url($profPictureURL);
		return $profPictureURL;

	}

	
	public function getConversation($otherUserId, $page = 1)
	{	
			$currentUserId = $this->getCurrentUserId();
			$limit = 20;
			$offset = ($page - 1) * $limit;
	
			$messages = $this->messageModel->getConversation($currentUserId, $otherUserId, $limit, $offset);
	
			// Fetch user details
			$currentUser = $this->userModel->find($currentUserId);
			$otherUser = $this->userModel->find($otherUserId);
	
			$formattedMessages = array_map(function($message) use ($currentUser, $otherUser) {
					$sender = ($message['sender_id'] == $currentUser['userid']) ? $currentUser : $otherUser;
					$message['sender_name'] = $sender['username'];
					$message['sender_gender'] = $sender['sex'];
					$message['sender_profile_picture'] = $this->getProfilePicture($sender['userid']);
					return $message;
			}, $messages);
	
			return $this->response->setJSON($formattedMessages);
	}
			
	
	

	private function getCurrentUserId()
	{
	
		$userLogged = $this->session->get('loggedIn');
		if ($userLogged === null) {
				throw new \CodeIgniter\Exceptions\PageNotFoundException('User not logged in');
		}
		return $userLogged = $this->session->get('userid');
 
	}
}