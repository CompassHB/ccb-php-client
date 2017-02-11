<?php
namespace CompassHB\Ccb;

use GuzzleHttp\Client;
use SimpleXMLElement;

use CompassHB\Ccb\Api;
use CompassHB\Ccb\Events;
use CompassHB\Ccb\Calendar;

/**
 * A dispatcher for the rest of the APIs
 */
class Ccb
{

    public static $api;
    public static $ccb;

    private function __construct()
    {
    }

    public static function init($church, $auth)
    {
        self::$api = new Api($church, $auth);
    }


    public static function __callStatic($name, $args)
    {
        $klass = "\\CompassHB\\Ccb\\". $name;
        return new $klass();
    }

    public static function format_date($date)
    {
        $return_date = new \DateTime($date);
        return $return_date->format("Y-m-d");
    }

    public static function lookupDetail($table, $params = array())
    {
        $detail = Ccb::$api->get($table."_detail", $params);
        return $detail->responseXML();
    }

    public static function lookupInsert($table, $params = array())
    {
        $detail = Ccb::$api->get($table."_insert", $params);
        return $detail->responseXML();
    }

    public static function lookupList($table, $params = array())
    {
        $detail = Ccb::$api->get($table."_list", $params);
        return $detail->responseXML();
    }

    public static function lookupUpdate($table, $params = array())
    {
        $detail = Ccb::$api->get($table."_update", $params);
        return $detail->responseXML();
    }

  /**
  *
  * @return array of last run time, daily limit and counter
  */
    public static function apiStatus()
    {
        $status = Ccb::$api->get("api_status");
        $response = $status->responseXML()->response;
        return array(
        "last_run_date" => (string) $response->last_run_date,
        "daily_limit" => (string) $response->daily_limit,
        "counter" => (string) $response->counter
        );
    }
}
