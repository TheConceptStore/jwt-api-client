<?php namespace Tcsehv\JwtApiClient\Connectors;

use Illuminate\Support\ServiceProvider;
use Tcsehv\JwtApiClient\Connectors\Contracts\ConnectionInterface;
use Tcsehv\JwtApiClient\LogClient;
use Tcsehv\JwtApiClient\Resources\ApiClient;
use Tcsehv\JwtApiClient\Resources\Auth\BasicAuthentication;
use Tcsehv\JwtApiClient\Resources\Auth\Contracts\AuthenticationInterface;
use Tcsehv\JwtApiClient\Resources\Auth\TokenAuthentication;

/**
 * Class LaravelConnector
 *
 * @package Tcsehv\JwtApiClient\Connectors
 */
class LaravelConnector extends ServiceProvider implements ConnectionInterface
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('theconceptstore/jwt-api-client', 'jwt-api-client', __DIR__ . '/../');

        $configPath = __DIR__ . '/../config/jwt-api-client.php';
        $this->publishes([$configPath => config_path('jwt-api-client.php')], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/../config/jwt-api-client.php';
        $this->mergeConfigFrom($configPath, 'jwt-api-client');

        $this->setupClient();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    /**
     * Register default client
     */
    public function setupClient()
    {
        $this->app['apiClient'] = $this->app->share(function ($app) {
            $config = $app['config']->get('jwt-api-client::config.configuration');

            // Instantiate client
            $auth = $this->determineAuthentication($app);
            $client = new ApiClient($config['url'], $config['name'], $config['version'], $auth);

            // Apply authentication and set config
            $client->setConfig($app['config']->get('jwt-api-client::config'));

            return $client;
        });
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
        /** @var AuthenticationInterface $authentication */
        $authentication = null;

        $config = $app['config']->get('jwt-api-client::authentication');
        $configType = $config['default'];

        if (!empty($configType) && !empty($config['types'][$configType])) {
            $credentials = $config['types'][$configType];

            // Get correct authentication type
            switch ($configType) {
                case 'basic':
                    $authentication = new BasicAuthentication($credentials['username'], $credentials['password']);
                    break;
                case 'token':
                    $authentication = new TokenAuthentication($credentials['key']);
                    break;
            }
        } else {
            throw new \RuntimeException('Invalid authentication type. Please choose one of the following: ' . implode(', ', array_keys($config['types'])));
        }
        return $authentication;
    }
}
