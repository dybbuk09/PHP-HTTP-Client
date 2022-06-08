<?php

namespace Curl;

use Curl\CurlResponse;
use Exception;

class HttpClient
{
    /**
     * Holds the instance of the class
     */
    private static $instance = null;

    /**
     * Holds the request url
     */
    private static $url;

    /**
     * Holds the request method
     */
    private static $method = 'GET';

    /**
     * Holds the payload of the request
     */
    private static $payload;

    /**
     * Holds the request timeout value
     */
    private $timeout = 30;

    /**
     * Holds the request headers
     */
    private $headers = [];

    /**
     * Return the instance of the class using singleton pattern
     * @return object
     */
    public static function instance()
    {
        if(is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Set the request url
     * @param string $url
     * @return object
     */
    public static function get($url)
    {
        self::$url = $url;
        return self::instance();
    }

    /**
     * Set the request url, payload and method
     * @param string $url
     * @param $payload
     * @return object
     */
    public static function post($url, $payload)
    {
        self::$url = $url;
        self::$payload = $payload;
        self::$method = 'POST';
        return self::instance();
    }

    /**
     * Set the request url, payload and method
     * @param string $url
     * @param $payload
     * @return object
     */
    public static function put($url, $payload)
    {
        self::$url = $url;
        self::$payload = $payload;
        self::$method = 'PUT';
        return self::instance();
    }

    /**
     * Set the request url, payload and method
     * @param string $url
     * @param $payload
     * @return object
     */
    public static function patch($url, $payload)
    {
        self::$url = $url;
        self::$payload = $payload;
        self::$method = 'PATCH';
        return self::instance();
    }

    /**
     * Set the request url and method
     * @param string $url
     * @return object
     */
    public function delete($url)
    {
        self::$url = $url;
        self::$method = 'DELETE';
        return self::instance();
    }

    /**
     * Set request timeout value
     * @param int $timeout
     * @return object
     */
    public function timeout($timeout)
    {
        $this->timeout = $timeout;
        return self::instance();
    }

    /**
     * Set request headers
     * @param array $headers
     * @return object
     */
    public function headers($headers)
    {
        $this->headers = $headers;
        return self::instance();
    }

    /**
     * Send the cURL request
     * @return \Curl\CurlResponse
     * @throws Exception
     */
    public function send()
    {
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, self::$url );
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, self::$method );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $this->timeout );
        curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
        if(!in_array(self::$method, ['GET', 'DELETE'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, self::$payload );
        }
        if(!empty($this->headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers );
        }

        $content = curl_exec( $ch );
        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch));
        }
        $response = curl_getinfo( $ch );
        curl_close ( $ch );

        return new CurlResponse($content, $response);
    }
}