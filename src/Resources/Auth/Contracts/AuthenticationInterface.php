<?php namespace Tcsehv\JwtApiClient\Resources\Auth\Contracts;

interface AuthenticationInterface
{

    /**
     * Retrieve token based on the provided credentials
     *
     * @param string $key
     * @return array
     */
    public function getGuzzleOptions($key = null);

    /**
     * Check if the current token isn't expired yet
     *
     * @return bool
     */
    public function isTokenValid();
}