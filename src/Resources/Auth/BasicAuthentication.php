<?php namespace Tcsehv\JwtApiClient\Resources\Auth;

use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;
use Tcsehv\JwtApiClient\Resources\Auth\Contracts\AuthenticationInterface;

/**
 * Class BasicAuthentication
 *
 * @package Tcsehv\JwtApiClient\Resources\Auth
 * @author Sjors Keuninkx <s.keuninkx@theconceptstore.nl>
 * @version 1.0
 */
class BasicAuthentication implements AuthenticationInterface
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $token;

    /**
     * @var array
     */
    private $options;

    /**
     * Initialize class
     *
     * @param string $username
     * @param string $password
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Check if the current token isn't expired yet
     *
     * @return bool
     */
    public function isTokenValid()
    {
        return true;
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
            $this->options['token'] = 'Basic ' . base64_encode($this->username . ':' . $this->password);
            $this->options['auth'] = [$this->username, $this->password];
            $this->options['exceptions'] = false;
        }

        if(array_key_exists($key, $this->options)) {
            return $this->options[$key];
        }
        return null;
    }
}