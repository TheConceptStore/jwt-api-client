<?php namespace Tcsehv\JwtApiClient\Connectors;

use Tcsehv\JwtApiClient\Connectors\Contracts\ConnectionInterface;
use Tcsehv\JwtApiClient\LogClient;
use Tcsehv\JwtApiClient\Resources\ApiClient;
use Tcsehv\JwtApiClient\Resources\Auth\BasicAuthentication;
use Tcsehv\JwtApiClient\Resources\Auth\Contracts\AuthenticationInterface;
use Tcsehv\JwtApiClient\Resources\Auth\TokenAuthentication;
use Tcsehv\JwtApiClient\Resources\Helper;

class ApiConnector implements ConnectionInterface
{

    /**
     * @var array
     */
    protected $config;

    /**
     * If config is left blank, the default config from the package will be used
     *
     * @param array|string|null $config
     * @throws \RuntimeException
     */
    public function __construct($config)
    {
        if (is_array($config)) {
            $this->config = $config;
        } else if (is_string($config)) {
            if (file_exists($config)) {
                $this->config = require_once $config;
            } else {
                throw new \RuntimeException('File not found in path: ' . $config);
            }
        }
    }

    /**
     * Register default client
     *
     * @return ApiClient
     */
    public function setupClient()
    {
        // Provide list of required fields
        $clientConfig = $this->config['configuration'];

        // Validate fields or throw an exception
        Helper::validateFields($clientConfig, ['url', 'name', 'version'], 'configuration');

        // If array with invalid fields is empty, proceed login
        if (empty($invalidFields)) {
            $auth = $this->determineAuthentication();

            // Setup client connection for generation token
            $client = new ApiClient($clientConfig['url'], $clientConfig['name'], $clientConfig['version'], $auth);
            $client->setConfig($this->config);

            return $client;
        }
    }

    /**
     * Determine the authentication method
     *
     * @param array|null $app
     * @return null|AuthenticationInterface
     * @throws \RuntimeException
     */
    public function determineAuthentication($app = null)
    {
        // Get authentication configuration and validate fields
        $authConfig = $this->config['authentication'];
        Helper::validateFields($authConfig, ['default'], 'authentication');

        // Get default configuration
        $configType = $authConfig['default'];

        // Validate type and check if configuration data is available
        if (!empty($configType) && !empty($authConfig['types'][$configType])) {
            $credentials = $authConfig['types'][$configType];

            // Get correct authentication type
            switch ($configType) {
                case 'basic':
                    $authentication = $this->createBasicAuthentication($credentials);
                    break;
                case 'token':
                    $authentication = $this->createTokenAuthentication($credentials);
                    break;
                default:
                    throw new \RuntimeException('Invalid authentication type given. Allowed types: ' . implode(', ', array_keys($authConfig['types'])));
            }
        } else {
            throw new \RuntimeException('Unknown settings for type \'' . $configType . '\'');
        }
        return $authentication;
    }

    /**
     * Validate credentials for basic authentication
     *
     * @param array $credentials
     * @return BasicAuthentication
     * @throws \RuntimeException
     */
    protected function createBasicAuthentication(array $credentials)
    {
        Helper::validateFields($credentials, ['username', 'password'], 'authentication.types.basic');

        return new BasicAuthentication($credentials['username'], $credentials['password']);
    }

    /**
     * Validate credentials for token authentication
     *
     * @param array $credentials
     * @return TokenAuthentication
     * @throws \RuntimeException
     */
    protected function createTokenAuthentication(array $credentials)
    {
        Helper::validateFields($credentials, ['token'], 'authentication.types.token');

        return new TokenAuthentication($credentials['token']);
    }
}