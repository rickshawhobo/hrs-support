<?php

namespace HRS\Support;

use GuzzleHttp\Client;
use HRS\Support\Exceptions\HRSRequestException;

abstract class HRSModel implements \JsonSerializable
{

    protected static $_properties = [];
    protected static $_name = 'HRSModel';
    protected $_data;

    private $_baseUrl = "http://api.healthrecoverysolutions.ftld";

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            if (in_array($key, static::$_properties)) {
                $this->_data[$key] = $value;
            }
        }
    }

    public function jsonSerialize()
    {
        return json_encode($this->_data);
    }

    public function __get($name)
    {
        if (in_array($name, static::$_properties) && isset($this->_data[$name])) {
            return $this->_data[$name];
        }
    }
    public function __set($name, $value)
    {
        if (in_array($name, static::$_properties)) {
            $this->_data[$name] = $value;
        }
    }
    public static function getName()
    {
        // could use reflection and fall back to manually set name
        return static::$_name;
    }

    public static function getProperties()
    {

        return static::$_properties;
    }

    public function request($request)
    {

        $url = $this->_baseUrl . "/" . self::getName() . "/" . $request;
        $client = new Client();
        $rawBody = $this->jsonSerialize();

        $response = $client->post($url, [], $rawBody);
        $body = $response->getBody();
        $status = $response->getStatusCode();

        if ($status >=200 && $status < 300) {
            // assumes payload is json
            return json_decode($body, true);
        } else {
            throw new HRSRequestException($body, $response->getStatusCode());
        }

    }
}