<?php namespace Tcsehv\JwtApiClient\Resources\Auth;

use Tcsehv\JwtApiClient\Resources\Auth\Contracts\AuthenticationInterface;

/**
 * Class TokenAuthentication
 *
 * @package Tcsehv\JwtApiClient\Resources\Auth
 * @author Sjors Keuninkx <s.keuninkx@theconceptstore.nl>
 * @version 1.0
 */
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