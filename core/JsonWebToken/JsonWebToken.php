<?php
namespace App\Core\JsonWebToken;
use Firebase\JWT\JWT;
use stdClass;

class JsonWebToken
{
    /**
     * @var string Firebase Secret Key
     */
    private string $secretKey;

    /**
     * Token Expires Time
     */
    private const EXPIRES_TIME = 3600;

    public function __construct(string $secretKey="thisispassword")
    {
        $this->secretKey = $secretKey;
    }

    /**
     * Generate JWT Token
     *
     * @param array $data
     * @return string Token
     */
    public function generateToken(array $data): string
    {
        $now = time();
        $payload = [
            'iat' => $now,
            'iss' => 'https://game-zone.lndo.site/',
            'nbf' => $now,
            'exp' => $now + self::EXPIRES_TIME,
            'data' => $data,
        ];

        return \Firebase\JWT\JWT::encode($payload, $this->secretKey, 'HS256');
    }

    /**
     * Validate JWT Token
     * @param string $token
     * @return stdClass|false Token Data
     */
    public function validateToken(string $token): stdClass|false
    {
        try {
            return \Firebase\JWT\JWT::decode($token, new \Firebase\JWT\Key($this->secretKey, 'HS256'))?->data;
        } catch (\Exception $ex) {
            return false;
        }
    }
}