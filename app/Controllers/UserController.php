<?php

namespace App\Controllers;

use App\Models\User;
use Application\Routing\Request;

class UserController extends BaseController
{
    protected $request;
    protected $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function index()
    {
        return view('user.index', ['users' => $this->user->get()]);
    }

    public function create()
    {
        $user = $this->user->create([
            'name' => 'John Doe',
            'email' => 'admin@example.com',
            'password' => 'password'
        ]);
        return $user;
    }

    public function store(array $data)
    {
        // TODO: Implement store() method.
    }

    public function edit(string $id)
    {
        // TODO: Implement edit() method.
    }

    public function update(string $id, array $data)
    {
        // TODO: Implement update() method.
    }

    public function delete(string $id)
    {
        // TODO: Implement delete() method.
    }
}