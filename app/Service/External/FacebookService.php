<?php


namespace App\Service\External;


class FacebookService extends CurlService
{
    protected $api;

    protected $payload;

    protected $token;

    public function __construct()
    {
        $this->baseUrl = 'https://graph.facebook.com';
        parent::__construct();
    }

    private function header()
    {
        return [
            "Authorization" => "",
            "Content-Type" => "application/json"
        ];
    }

    public function getPayload()
    {
        return $this->payload;
    }

    public function setPayload(array $payload)
    {
        $this->payload = $payload;
        return $this;
    }

    public function setToken(string $token)
    {
        $this->token = $token;
        return $this;
    }

    public function getUserDetails()
    {
        $this->response = $this->get("{$this->baseUrl}/me/?fields=first_name,email,birthday&access_token=$this->token", null,[], []);
        return $this;
    }

    public function response()
    {
        return $this->response;
    }

}

