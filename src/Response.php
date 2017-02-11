<?php namespace CompassHB\Ccb;

use SimpleXMLElement;

class Response
{

    protected $response;
    protected $responseXML;
    protected $responseArray;
    protected $responseObject;

    public function __construct($response)
    {
        $this->response = $response;
        if (!empty($response) && is_string($response)) {
            try {
                    $xml = new SimpleXMLElement($this->response);
                    $this->responseXML = $xml;
                    $this->responseArray = json_decode(json_encode($xml), 1);
                    // $this->responseArray = $this->xml2array($xml);
                    // $this->responseObject = $this->xml2obj($xml);
                    $this->responseError = '';
                if (isset($this->responseArray["response"])) {
                    if (isset($this->responseArray["response"]["error"])) {
                        if (count($this->responseArray["response"]["error"])) {
                            $this->setResponseError($this->responseArray["response"]["error"]);
                        }
                    }
                } elseif (isset($this->responseArray["error"])) {
                    if (count($this->responseArray["error"])) {
                        $this->setResponseError($this->responseArray["error"]);
                    }
                }
            } catch (Exception $e) {
                $this->responseError = $e;
                return null;
            }
        }
    }

    public function response()
    {
        return $this->response;
    }

    public function responseXML()
    {
        return $this->responseXML;
    }

    public function responseArray()
    {
        return $this->response;
    }

    public function responseObject()
    {
        return $this->response;
    }

    protected function xml2obj($xml, $force = false)
    {
        $obj = new \StdClass();

        $obj->name = $xml->getName();

        $text = trim((string)$xml);
        $attributes = array();
        $children = array();

        foreach ($xml->attributes() as $k => $v) {
            $attributes[$k]  = (string)$v;
        }

        foreach ($xml->children() as $k => $v) {
            $children[] = $this->xml2obj($v, $force);
        }


        if ($force or $text !== '') {
            $obj->text = $text;
        }

        if ($force or count($attributes) > 0) {
            $obj->attributes = $attributes;
        }

        if ($force or count($children) > 0) {
            $obj->children = $children;
        }


        return $obj;
    }

    protected function xml2array($xml, $force = false)
    {
        $obj = array();


        $text = trim((string)$xml);
        $attributes = array();
        $children = array();

        foreach ($xml->attributes() as $k => $v) {
            $attributes[$k]  = (string)$v;
        }

        foreach ($xml->children() as $k => $v) {
            if (array_key_exists($v->getName(), $obj)) {
                $obj[] = $obj[$v->getName()];
                unset($obj[$v->getName()]);
                $obj[] = $this->xml2array($v, $force);
            } else {
                $obj[$v->getName()] = $this->xml2array($v, $force);
            }
        }


        if ($force or $text !== '') {
            $obj["text"] = $text;
        }

        if ($force or count($attributes) > 0) {
            $obj["attributes"] = $attributes;
        }

        // if($force or count($children) == 0)
        //   $obj["name"] = $xml->getName();


        return $obj;
    }



  // public function __toString(){
  //   if(!empty($this->responseError)){
  //     return $this->responseError;
  //   }
  //   else{
  //     return $this->responseXML;
  //   }
  // }
  //
}
