<?php


namespace App\Service\External;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Response;


class CurlService
{
    /**
     * @var null
     */
    protected $baseUrl = null;

    protected $timeout = '60';

    protected $client;

    private $url = '';

    private $method = '';

    private $query = '';

    private $payload = [];

    private $headers = [];

    /**
     * CurlService constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->getBaseUrl(),
            'timeout' => $this->getTimeout()
        ]);
    }

    /**
     * @param $url
     * @param null $query
     * @param array $payload
     * @param array $headers
     * @return object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function post($url, $query = null, $payload = [], array $headers = [])
    {
        $this->url = $url;
        $this->method = 'POST';
        $this->query = $query;
        $this->payload = $payload;
        $this->headers = $headers;

        return $this->request();
    }

    /**
     * @param $url
     * @param null $query
     * @param array $payload
     * @param array $headers
     * @return object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function get($url, $query = null, $payload = [], array $headers = [])
    {
        $this->url = $url;

        $this->method = 'GET';
        $this->query = $query;
        $this->payload = $payload;
        $this->headers = $headers;

        return $this->request();
    }

    /**
     * @param $url
     * @param null $query
     * @param array $payload
     * @param array $headers
     * @return object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function delete($url, $query = null, array $payload = [], array $headers = [])
    {
        $this->url = $url;
        $this->method = 'DELETE';
        $this->query = $query;
        $this->payload = $payload;
        $this->headers = $headers;

        return $this->request();
    }

    /**
     * @param $url
     * @param null $query
     * @param array $payload
     * @param array $headers
     * @return object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function put($url, $query = null, array $payload = [], array $headers = [])
    {
        $this->url = $url;
        $this->method = 'PUT';
        $this->query = $query;
        $this->payload = $payload;
        $this->headers = $headers;

        return $this->request();
    }

    /**
     * @return object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function request()
    {
        try {

            $response = $this->client->request(
                $this->method,
                $this->url,
                [
                    'json' => $this->payload,
                    'query' => $this->query,
                    'headers' => $this->headers
                ]
            );

            return $this->successResponse($response);

        } catch (ClientException $e) {

            return $this->failedResponse($e->hasResponse(), $e);

        } catch (ServerException $e) {

            return $this->failedResponse($e->hasResponse(), $e);

        } catch (RequestException $e) {

            return $this->failedResponse($e->hasResponse(), $e);

        }
    }

    protected function failedResponse($hasResponse, $e)
    {
        if ($hasResponse) {

            $response = new CurlServiceResponse($e->getResponse());

            $response->setMessage("Something went wrong, please try again.");

            return $response->response();
        }

        return $this->requestTimeout();
    }

    protected function successResponse(Response $response)
    {
        $response = new CurlServiceResponse($response);

        $response->setMessage("Request Successful..");

        return $response->response();
    }


    private function requestTimeout()
    {
        $response = new CurlServiceResponse();

        $response->setMessage("Request Timeout..")->setStatus(504);

        return $response->response();
    }

    /**
     * @return null
     * @throws \Exception
     */
    private function getBaseUrl() {

        if ($this->baseUrl == null) {
            throw new \Exception('Please provide valid base uri');
        }

        return $this->baseUrl;
    }

    /**
     * @return int
     */
    private function getTimeout() {

        return $this->timeout;
    }

    /**
     * @param null $baseUrl
     * @return \Rush\Helper\CurlService
     */
    protected function setBaseUrl($baseUrl): CurlService
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    /**
     * @param string $timeout
     * @return $this;
     */
    protected function setTimeout(string $timeout): CurlService
    {
        $this->timeout = $timeout;

        return $this;
    }
}
