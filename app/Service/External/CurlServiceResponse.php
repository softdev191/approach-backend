<?php


namespace App\Service\External;


use GuzzleHttp\Psr7\Response;

class CurlServiceResponse
{
    protected $message;

    protected $status;

    protected $response;

    protected $result;

    public function __construct(Response $response = null)
    {
        $this->response = $response;

        if ($response != null) {
            $this->setStatus($response->getStatusCode());
            $this->setMessage($response->getReasonPhrase());
            $this->setResult($response->getBody());
        }
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     * @return \Rush\Helper\CurlServiceResponse
     */
    public function setMessage($message): CurlServiceResponse
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return $this
     */
    public function setStatus($status): CurlServiceResponse
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     * @return $this
     */
    public function setResult($result): CurlServiceResponse
    {
        $this->result = $result;

        return $this;
    }

    public function response()
    {
        return (object)[
            'status' => $this->getStatus(),
            'message' => $this->getMessage(),
            'result' => json_decode($this->getResult())
        ];
    }
}
