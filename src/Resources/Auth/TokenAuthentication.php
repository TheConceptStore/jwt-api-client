<?php namespace Tcsehv\JwtApiClient\Resources\Auth;

use Tcsehv\JwtApiClient\Resources\Auth\Contracts\AuthenticationInterface;

class TokenAuthentication implements AuthenticationInterface
{
    /**
     * @var string
     */
    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Check if the current token isn't expired yet
     *
     * @return bool
     */
    public function isTokenValid()
    {
        return !empty($this->token) ? true : false;
    }

    /**
     * Retrieve token based on the provided credentials
     *
     * @param string $key
     * @return array
     */
    public function getGuzzleOptions($key = null)
    {
        if(empty($this->options)) {
            $this->options['token'] = 'Bearer ' . $this->token;
            $this->options['exceptions'] = false;
        }

        if(array_key_exists($key, $this->options)) {
            return $this->options[$key];
        }
        return null;
    }
}