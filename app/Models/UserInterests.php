<?php

namespace App\Models;

use CodeIgniter\Model;

class UserInterests extends BaseModel
{
    protected $table = 'userinterests';
    protected $primaryKey = 'userid';
    protected $allowedFields = ['userid', 'interests','lookingfor'];


    public static $LookingForOptions= ['Women', 'Men','All'];



    public function __construct()
    {
        parent::__construct();
       
    }
    public function getAllUserData($userId)
    {
        // Step 1: Validate the user ID
        if (!$userId) {
            // Handle invalid user ID, for example:
            return null; // or throw an InvalidArgumentException
        }
    
        // Step 2: Execute the query
        try {
            $userData = $this->where('userid', $userId)->first();
            
            // Step 3: Check if the query executed successfully
            if (!$userData) {
                // Handle case when user data is not found
                return null; // or throw an Exception
            }
    
            // Return the retrieved user data
            return $userData;
        } catch (\Exception $e) {
            // Step 4: Handle any potential errors
            // Log the error or return an appropriate error message
            // For example:
            return null; // or throw a custom exception
        }
    }
    public function updateUserField1($userId, $field, $value)
    {
    log_message('debug', "Updating user field: userId = $userId, field = $field, value = $value");

	$data = [
		'userID'  => $userId,
		$field => $value
		
	];
    $result = $this->save($data);
    log_message('debug', "Update result: " . var_export($result, true));
    return $result;
    }



    public function updateUserField($userId, $field, $value)
{
    log_message('debug', "Updating user field: userId = $userId, field = $field, value = $value");

    $data = [
        'userID' => $userId, // Primary key must be included
        $field   => $value  // Field to update
    ];

    try {
        $result = $this->update($userId, $data); // Explicitly call update()
        log_message('debug', "Update result: " . var_export($result, true));
        return $result;
    } catch (\Exception $e) {
        log_message('error', 'Failed to update user field: ' . $e->getMessage());
        return false;
    }
}


}


