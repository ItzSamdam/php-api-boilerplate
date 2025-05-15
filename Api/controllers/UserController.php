/**
* controllers/UserController.php - User controller
*/
<?php

namespace Api\Controllers;

use Api\Utils\Request;
use Api\Utils\Response;
use Api\Utils\Validator;
use Api\Services\UserService;

class UserController
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function index(Request $request)
    {
        $users = $this->userService->getAllUsers();
        return Response::success($users);
    }

    public function show(Request $request, $params)
    {
        $user = $this->userService->getUserById($params['id']);

        if (!$user) {
            return Response::notFound('User not found');
        }

        return Response::success($user);
    }

    public function store(Request $request)
    {
        $body = $request->getBody();

        $validator = new Validator($body);
        $validator->required('name')
            ->required('email')
            ->email('email')
            ->required('password')
            ->min('password', 6);

        if (!$validator->isValid()) {
            return Response::validationError($validator->getErrors());
        }

        $user = $this->userService->createUser($body);
        return Response::success($user, 'User created successfully', 201);
    }

    public function update(Request $request, $params)
    {
        $body = $request->getBody();

        $validator = new Validator($body);

        if (isset($body['email'])) {
            $validator->email('email');
        }

        if (isset($body['password'])) {
            $validator->min('password', 6);
        }

        if (!$validator->isValid()) {
            return Response::validationError($validator->getErrors());
        }

        $user = $this->userService->updateUser($params['id'], $body);

        if (!$user) {
            return Response::notFound('User not found');
        }

        return Response::success($user, 'User updated successfully');
    }

    public function destroy(Request $request, $params)
    {
        $result = $this->userService->deleteUser($params['id']);

        if (!$result) {
            return Response::notFound('User not found');
        }

        return Response::success(null, 'User deleted successfully');
    }

    public function login(Request $request)
    {
        $body = $request->getBody();

        $validator = new Validator($body);
        $validator->required('email')
            ->email('email')
            ->required('password');

        if (!$validator->isValid()) {
            return Response::validationError($validator->getErrors());
        }

        $result = $this->userService->login($body['email'], $body['password']);

        if (!$result) {
            return Response::unauthorized('Invalid credentials');
        }

        return Response::success($result, 'Login successful');
    }

    public function register(Request $request)
    {
        return $this->store($request);
    }
}
