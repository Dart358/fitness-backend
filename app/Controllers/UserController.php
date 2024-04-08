<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use CodeIgniter\API\ResponseTrait;

class UserController extends BaseController
{
    use ResponseTrait;

    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    // Retrieve all users
    public function index()
    {
        $users = $this->userModel->findAll();
        return $this->respond($users);
    }

    // Retrieve a single user by ID
    public function show($id)
    {
        $user = $this->userModel->find($id);
        if ($user === null) {
            return $this->failNotFound('User not found');
        }
        return $this->respond($user);
    }

    // Create a new user
    public function create()
    {
        // Validation rules
        $rules = [
            'username' => 'required',
            'email' => 'required|valid_email',
            'password_hash' => 'required' // Ensure this matches your database schema
        ];

        // Validate request data
        if (!$this->validate($rules)) {
            // Return validation errors
            return $this->failValidationErrors($this->validator->getErrors());
        }

        // Prepare user data
        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password_hash'), PASSWORD_DEFAULT)
        ];

        // Attempt to insert user data into the database
        if (!$this->userModel->insert($data)) {
            // Insertion failed, return error response
            return $this->failServerError('Failed to create user. Please try again later.');
        }

        // Get the ID of the inserted user
        $userId = $this->userModel->getInsertID();

        // Retrieve the inserted user from the database
        $user = $this->userModel->find($userId);

        // Return the inserted user as a response
        return $this->respondCreated($user);
    }

    // Update an existing user
    public function update($id)
    {
        $user = $this->userModel->find($id);
        if ($user === null) {
            return $this->failNotFound('User not found');
        }

        $data = $this->request->getRawInput();

        $this->userModel->update($id, $data);

        // Optionally, retrieve and return the updated user
        $updatedUser = $this->userModel->find($id);
        return $this->respond($updatedUser);
    }

    // Delete a user by ID
    public function delete($id)
    {
        $user = $this->userModel->find($id);
        if ($user === null) {
            return $this->failNotFound('User not found');
        }

        $this->userModel->delete($id);
        return $this->respondDeleted(['id' => $id]);
    }
}
