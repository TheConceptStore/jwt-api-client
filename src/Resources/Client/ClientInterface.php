<?php namespace Tcsehv\JwtApiClient\Resources\Client;

use Tcsehv\JwtApiClient\Resources\ApiClient;

/**
 * Interface ClientInterface
 *
 * @package Tcsehv\JwtApiClient\Resources\Client
 * @author Sjors Keuninkx <s.keuninkx@theconceptstore.nl>
 * @version 1.0
 */
interface ClientInterface
{

    /**
     * Every client needs an instance of the API client. This class is responsible for creating the connection to the API
     *
     * @param ApiClient $apiClient
     * @param bool $debug
     */
    public function __construct(ApiClient $apiClient, $debug = false);

}