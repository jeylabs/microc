<?php


namespace Jeylabs\Vendee\Contracts;


interface ClientServiceInterface
{
    /**
     * @param $method
     * @param $uri
     * @param null $query
     * @return mixed
     */
    public function request($method, $uri, $query = null);

    /**
     * @param $uri
     * @param null $query
     * @return mixed
     */
    public function get($uri, $query = null);

    /**
     * @param $uri
     * @param null $body
     * @return mixed
     */
    public function post($uri, $body = null);
}