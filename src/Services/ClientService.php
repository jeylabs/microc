<?php


namespace Jeylabs\Vendee\Services;


use Illuminate\Support\Arr;
use Jeylabs\Vendee\Contracts\ClientServiceInterface;

class ClientService implements ClientServiceInterface
{
    protected $baseUrl;

    /**
     * ClientService constructor.
     * @param $baseUrl
     */
    public function __construct($baseUrl)
    {
        $urlComponents = parse_url($baseUrl);
        $this->baseUrl = Arr::get($urlComponents, 'scheme', 'http') . '://' . Arr::get($urlComponents, 'host');
    }

    /**
     * @param $method
     * @param $uri
     * @param null $query
     * @return mixed
     */
    public function request($method, $uri, $query = null)
    {
        $url = $this->baseUrl . '/' . $uri;
        $opts = [
            'http' => [
                'method' => $method,
                'header' => 'Content-type: application/json',
            ]
        ];
        if ($method == 'POST' && $query) {
            $opts['http']['content'] = json_encode($query);
        } elseif ($method == 'GET' && $query) {
            $url = trim($url, '? /') . '?' . http_build_query($query);
        }
        $context = stream_context_create($opts);
        return json_decode(file_get_contents($url, false, $context), true);
    }

    /**
     * @param $uri
     * @param null $query
     * @return mixed
     */
    public function get($uri, $query = null)
    {
        return $this->request('GET', $uri, $query);
    }

    /**
     * @param $uri
     * @param null $body
     * @return mixed
     */
    public function post($uri, $body = null)
    {
        return $this->request('POST', $uri, $body);
    }
}