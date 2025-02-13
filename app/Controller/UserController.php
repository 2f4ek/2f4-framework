<?php

namespace Framework2f4\Controller;

use Framework2f4\Http\Response;
use Framework2f4\Http\ServerRequest;
use Framework2f4\Repository\UserRepository;

class UserController
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function create(ServerRequest $request): Response
    {
        $data = $request->getParsedBody();
        $this->userRepository->createUser($data['username'], $data['password'], 'user');
        return new Response(201, [], 'User created');
    }

    public function read(int $id): Response
    {
        $user = $this->userRepository->findById($id);
        return new Response(200, [], json_encode($user));
    }

    public function update(ServerRequest $request, int $id): Response
    {
        if ($_SESSION['user']->getId() !== $id) {
            return new Response(403, [], 'Forbidden');
        }

        $data = $request->getParsedBody();
        $this->userRepository->updateUser($id, $data['username'], $data['password'], $data['role']);
        return new Response(200, [], 'User updated');
    }

    public function delete(int $id): Response
    {
        $this->userRepository->deleteUser($id);
        return new Response(200, [], 'User deleted');
    }
}