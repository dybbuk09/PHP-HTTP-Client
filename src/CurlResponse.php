<?php

namespace Curl;

class CurlResponse
{
    /**
     * Holds api response content
     */
    private $content;

    /**
     * Hold properties return by api
     */
    private $response;

    public function __construct(string $content, array $response)
    {
        $this->content = $content;
        $this->response = $response;
    }

    /**
     * @return bool
     */
    public function success()
    {
        if(in_array($this->response['http_code'], range(200, 206))) {
            return true;
        }
        return false;
    }

    /**
     * Return status code
     * @return int
     */
    public function statusCode()
    {
        return $this->response['http_code'];
    }

    /**
     * Return data, returned by api
     * @return mixed
     */
    public function data()
    {
        return $this->content;
    }

    /**
     * Return all properties returned by api
     * @return array
     */
    public function properties()
    {
        return $this->response;
    }
}