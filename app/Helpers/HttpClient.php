<?php


namespace App\Helpers;


class HttpClient
{
    private $curl;

    /**
     * HttpClient constructor.
     * @param $url
     */
    private function __construct($url)
    {
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_URL, $url);
    }

    public static function post($url)
    {
        $httpClient =  new HttpClient($url);
        $headers = array('Content-Type: application/json');
        curl_setopt($httpClient->curl, CURLOPT_POST, true);
        curl_setopt($httpClient->curl, CURLOPT_HTTPHEADER, $headers);
        return $httpClient;
    }

    public static function get($url)
    {
        $httpClient =  new HttpClient($url);
        $headers = array('Content-Type: application/json');
        curl_setopt($httpClient->curl, CURLOPT_HTTPHEADER, $headers);
        return $httpClient;
    }

    public function userAgent()
    {
        curl_setopt($this->curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        return $this;
    }

    public function jsonBody($body)
    {
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($body));
        return $this;
    }

    public function bearerToken($token)
    {
        $headers = array('Authorization: Bearer ' . $token);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
        return $this;
    }

    public function authorizationKey($key)
    {
        $headers = array('Authorization: key=' . $key, 'Content-Type: application/json');
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
        return $this;
    }

    public function call()
    {
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($this->curl);
        curl_close($this->curl);
        return json_decode($result, true);
    }
}
