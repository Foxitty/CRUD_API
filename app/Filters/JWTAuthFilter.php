<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');
        if (!$authHeader) {
            return $this->failUnauthorized('Token não fornecido');
        }

        $token = explode(' ', $authHeader)[1];

        try {
            $decoded = JWT::decode($token, new Key(getenv('JWT_SECRET'), 'HS256'));
            if ($decoded->exp < time()) {
                return $this->failUnauthorized('Token expirado');
            }
        } catch (\Exception $e) {
            return $this->failUnauthorized('Token inválido: ' . $e->getMessage());
        }

        return $request;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }

    /**
     *
     * @param string $message
     * @return ResponseInterface
     */
    protected function failUnauthorized(string $message): ResponseInterface
    {
        $response = [
            'status' => 401,
            'error' => true,
            'message' => $message,
        ];

        return service('response')->setStatusCode(401)->setJSON($response);
    }
}