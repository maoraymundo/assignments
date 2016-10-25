<?php

namespace ApiBundle\Services;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

use GuzzleHttp\Message\Request;
use GuzzleHttp\Exception\ClientException;

class Sender
{
    protected $client;
    protected $header;
    protected $body;
    protected $serializer;
    protected $error_map;
    protected $user;
    protected $status_code;
    protected $error_message;
    protected $registration_key;
    protected $custom_errors;

    public function __construct($client, $error_map = array())
    {
        $this->client = $client;
        $this->error_map = $error_map;

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = new GetSetMethodNormalizer();
        $this->serializer = new Serializer(array($normalizers), $encoders);
    }

    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }

    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    public function get()
    {
        $response = $this->send('get');

        return $response;
    }

    public function post()
    {
        $response = $this->send('post');

        return $response;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getStatusCode()
    {
        return $this->status_code;
    }

    public function getErrorMessage()
    {
        return $this->error_message;
    }

    private function send($method)
    {
        $uri = $this->headers['uri'];

        $options['headers'] = $this->headers;
        
        if ($this->body) $options['body'] = $this->body;

        try {
            $response = $this->client->{$method}($uri, $options);

        } catch (ClientException $e) {
            var_dump($e->getResponse()); exit;

        } catch (\Exception $e) {
            var_dump($e->getMessage()); exit;
        }

        return $this->responseParser($response);
    }

    private function responseParser($response)
    {
        if (!is_a($response, 'GuzzleHttp\Message\Response')) {
            throw new \Exception('Whoops! Something went terribly wrong. Here have a cookie, good job!');
        }

        if ($response->getStatusCode() != '200') {
            throw new \Exception('Whoops! Service/s having tantrums. Have a break, have a KitKat.');
        }

        if ($response->getStatusCode() == '200') {

            if ($response->Status->Errno >= 0) {
                $this->user = (array)$response->User;
                $this->status_code = $response->getStatusCode();
                $valid = true;

            } else {
                $this->status_code = (string)$response->RequestStatus->ErrorCode;
                $this->error_message = $this->error_map['generic'][$this->status_code];

                if ($response->User) {
                    $this->user = (array)$response->User;
                }

                $valid = false;
            }

        }

        return $valid;
    }
}