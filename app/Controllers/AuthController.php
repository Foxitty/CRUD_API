<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;

class AuthController extends ResourceController
{
    public function login()
    {
        $input = $this->request->getJSON(true);

        $email = $input['email'] ?? '';
        $password = $input['password'] ?? '';

        if ($email === 'teste_auth@gmail.com' && $password === '12345') {
            $key = getenv('JWT_SECRET');
            $payload = [
                'iat' => time(),
                'exp' => time() + (86400 * 1), // 1 dia de validade (86400 segundos = 1 dia)
                'data' => [
                    'email' => $email,
                ]
            ];

            $token = JWT::encode($payload, $key, 'HS256');

            return $this->respond(['token' => $token]);
        }

        return $this->failUnauthorized('Credenciais inválidas');
    }
}