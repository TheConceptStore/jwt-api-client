<?php namespace Tcsehv\JwtApiClient\Resources\Client;

use Tcsehv\JwtApiClient\Resources\ApiClient;

interface ClientInterface
{

    /**
     * Every client needs an instance of the API client. This class is responsible for creating the connection to the API
     *
     * @param ApiClient $apiClient
     */
    public function __construct(ApiClient $apiClient);

}