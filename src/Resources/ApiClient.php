<?php namespace Tcsehv\JwtApiClient\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Message\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Tcsehv\JwtApiClient\Resources\Auth\Contracts\AuthenticationInterface;

class ApiClient
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var AuthenticationInterface
     */
    protected $auth;
    
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var string
     */
    protected $version;

    /**
     * Initialize class
     *
     * @param string $url
     * @param string $name
     * @param string $version
     * @param AuthenticationInterface $auth
     */
    public function __construct($url, $name, $version, AuthenticationInterface $auth)
    {
        $this->url = $url;
        $this->auth = $auth;
        $this->name = $name;
        $this->version = $version;
    }

    /**
     * Setup Guzzle client
     *
     * @return Client
     */
    public function getGuzzleClient()
    {
        $client = new Client(['base_url' => $this->url]);
        
        $client->setDefaultOption('headers', ['Accept' => 'application/vnd.' . $this->name . '.' . $this->version . '+json', 'Authorization' => $this->auth->getGuzzleOptions('token')]);
        $client->setDefaultOption('auth', $this->auth->getGuzzleOptions('auth'));
        $client->setDefaultOption('exceptions', $this->auth->getGuzzleOptions('exceptions'));

        return $client;
    }

    /**
     * @param string $endpoint
     * @return $this
     */
    public function endpoint($endpoint)
    {
        $this->endpoint = $endpoint;
        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function option($key, $value)
    {
        $this->options[$key] = $value;
        return $this;
    }

    /**
     * Fire GET command to the API
     *
     * @return string
     */
    public function get()
    {
        $this->prepareOptionsForRequest();
        return $this->send('get');
    }

    /**
     * Fire POST command to API
     *
     * @return string
     */
    public function post()
    {
        $this->prepareOptionsForRequest();
        return $this->send('post');
    }

    /**
     * Fire OPTIONS command to API
     *
     * @return string
     */
    public function options()
    {
        $this->prepareOptionsForRequest();
        return $this->send('options');
    }

    /**
     * Fire PATCH command to API
     *
     * @return string
     */
    public function patch()
    {
        $this->prepareOptionsForRequest();
        return $this->send('patch');
    }

    /**
     * Fire PUT command to API
     *
     * @return string
     */
    public function put()
    {
        $this->prepareOptionsForRequest();
        return $this->send('put');
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * Fire call to API and return data
     *
     * @param string $method
     * @return string|null
     */
    private function send($method)
    {
        $client = $this->getGuzzleClient();

        if (method_exists($client, $method) && !empty($this->endpoint)) {
            /** @var Response $response */
            $response = $client->$method($this->endpoint, $this->options);
            $contents = $response->getBody()->getContents();

            // Cleanup options, 'cause we don't need them again after the call was made
            $this->options = [];

            return $contents;
        } else {
            Helper::validateFields($this->config, ['mailFrom', 'mailTo', 'configuration'], 'email');

                // Send an error email
            $mailer = new Mailer($this->config['mailFrom'], $this->config['mailTo'], $this->config['configuration']['url']);
            $mailer->sendErrorMail($method, $this->endpoint, 'Chosen method doesn\'t exist in Guzzle', '', $this->options);
        }
        return null;
    }

    /**
     * Prepare options array for request
     */
    private function prepareOptionsForRequest()
    {
        if (!empty($this->options)) {
            $this->options = ['query' => $this->options];
        } else {
            $this->options = [];
        }
    }
}