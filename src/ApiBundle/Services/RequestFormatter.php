<?php

namespace ApiBundle\Services;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class RequestFormatter
{
    protected $credentials;
    protected $serializer;
    protected $uri;
    protected $request;
    protected $body;

    public function __construct($credentials = array())
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = new GetSetMethodNormalizer();

        $this->credentials = $credentials;
        $this->serializer = new Serializer(array($normalizers), $encoders);
    }

    public function setService($servicetype = array())
    {
        $this->uri = $servicetype['uri'];
        $this->request = $servicetype['request'];

        return $this;
    }

    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    public function getHeaders()
    {
        return array(
                "uri" => $this->uri, 
            );
    }

    public function getRequest()
    {
        array_walk_recursive($this->request, function(&$value, $key) {
            if (array_key_exists($key, $this->body) && is_null($value)) {
                    $value = $this->body[$key];
                }
            });

        $xml = $this->serializer->serialize($this->request, 'xml');
        $request = substr((string)$xml, 32, -12);

        return $request;
    }

}
