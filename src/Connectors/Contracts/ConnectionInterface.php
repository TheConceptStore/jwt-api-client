<?php namespace Tcsehv\JwtApiClient\Connectors\Contracts;

use Tcsehv\JwtApiClient\Resources\ApiClient;
use Tcsehv\JwtApiClient\Resources\Auth\Contracts\AuthenticationInterface;

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