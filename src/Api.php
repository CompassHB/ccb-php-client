<?php
namespace CompassHB\Ccb;

use GuzzleHttp\Client;
use SimpleXMLElement;

/**
 * A simple PHP client interface for the Community Church Builder HTTP API.
 *
 * See http://designccb.s3.amazonaws.com/helpdesk/files/official_docs/api.html
 * for a complete list of available services and official documentation.
 */
class Api
{
    private $church;
    private $client;

    public function __construct($church, $auth)
    {

        $client = new Client(["auth" => $auth]);

        $this->church = $church;
        $this->client = $client;
    }

    /**
     * A simple wrapper for calling any valid service.
     *
     * This function accepts strings so that it is flexible enough to handle
     * new APIs released by CCB without requiring code updates.
     *
     * @param string $httpMethod  Either "GET" or "POST"
     * @param string $serviceName
     * @param array  $args
     *
     * @return SimpleXMLElement
     */
    public function srv($httpMethod, $serviceName, array $args = [])
    {
        $url = "https://{$this->church}.ccbchurch.com/api.php";

        if (!isset($args["query"])) {
            $args["query"] = [];
        }

        $args["query"]["srv"] = $serviceName;
        $request = $this->client->request($httpMethod, $url, $args);
        $body = (string) $request->getBody();

        return new Response($body);
    }

    public function get($serviceName, array $parameters = [])
    {
        $args["query"] = $parameters;
        return $this->srv("GET", $serviceName, $args);
    }

    public function post($serviceName, array $parameters = [], array $formParams = [])
    {
        $args["query"] = $parameters;
        $args["form_params"] = $formParams;
        return $this->srv("POST", $serviceName, $args);
    }
}
