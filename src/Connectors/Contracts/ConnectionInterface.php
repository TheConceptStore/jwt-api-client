<?php namespace Tcsehv\JwtApiClient\Connectors\Contracts;

use Tcsehv\JwtApiClient\Resources\ApiClient;
use Tcsehv\JwtApiClient\Resources\Auth\Contracts\AuthenticationInterface;

/**
 * Interface ConnectionInterface
 *
 * @package Tcsehv\JwtApiClient\Connectors\Contracts
 * @author Sjors Keuninkx <s.keuninkx@theconceptstore.nl>
 * @version 1.0
 */
interface ConnectionInterface
{

    /**
     * Register default client
     */
    public function setupClient();

    /**
     * Determine the authentication method
     *
     * @param array|null $app
     * @return null|AuthenticationInterface
     * @throws \RuntimeException
     */
    public function determineAuthentication($app = null);

}