<?php namespace Tcsehv\JwtApiClient\Resources\Auth\Contracts;

/**
 * Interface AuthenticationInterface
 *
 * @package Tcsehv\JwtApiClient\Resources\Auth\Contracts
 * @author Sjors Keuninkx <s.keuninkx@theconceptstore.nl>
 * @version 1.0
 */
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