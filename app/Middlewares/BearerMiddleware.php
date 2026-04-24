<?php
namespace Middlewares;

use Src\Request;
use Model\User;

class BearerMiddleware
{
    public function handle(Request $request): Request
    {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? $request->headers['Authorization'] ?? '';

        if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $this->abort(401, 'Unauthorized');
        }

        $tokenStr = $matches[1];
        $user = User::where('api_token', $tokenStr)->first();

        if (!$user || !$user->isValidApiToken($tokenStr)) {
            $this->abort(401, 'Invalid or expired token');
        }

        $request->user = $user;
        return $request;
    }

    protected function abort(int $code, string $message): void
    {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode(['error' => $message], JSON_UNESCAPED_UNICODE);
        exit;
    }
}