<?php

class HttpClient
{
    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    public function get($url)
    {
        return $this->request("GET", $url);
    }

    public function put($url, $data = [])
    {
        return $this->request("PUT", $url, $data);
    }

    public function patch($url, $data = [])
    {
        return $this->request("PATCH", $url, $data);
    }

    public function delete($url, $data = [])
    {
        return $this->request("DELETE", $url, $data);
    }

    public function post($url, $data = [])
    {
        return $this->request("POST", $url, $data);
    }

    private function request($method, $url, $data = [])
    {
        $uri = $_ENV["URL_API"] . "/api" . $url;

        $data = (is_object($data) || is_array($data)) ? json_encode($data) : $data;

        $headers = array(
            'Authorization: Bearer ' . $this->session->token,
            'Content-Type: application/json; charset=UTF-8',
            'Content-Length: ' . strlen($data)
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response_api = json_decode(curl_exec($ch));

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $response[] = [
            "status" => $status,
            "method" => $method,
            "response" => $response_api,
        ];

        curl_close($ch);

        return $response[0];
    }
}
