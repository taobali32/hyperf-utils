<?php

namespace Jtar\Utils\Utils;

use Hyperf\Guzzle\ClientFactory;

class Http
{
    public function get($uri,$data = [],$request_type = 'json',$headers = [])
    {
        if ($request_type == 'json'){
            $data = [
                'body'    =>  json_encode($data,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE),
                'headers' => array_merge(['content-type' => 'application/json'],$headers)
            ];
        }

        $clientFactory = make(ClientFactory::class);
        $response = $clientFactory->create([])->get($uri,$data)->getBody();
        return json_decode($response, true);
    }

    public function post($uri,$data = [],$request_type = 'json',$headers = [])
    {
        /**
         *         $data = [
                        'form_params' => ($data),
                            'headers' => [
                                'content-type' => 'application/x-www-form-urlencoded',
                                'Authorization'         =>  'xx'
                            ]
                    ];
         */

        /**
         *  $data = [
                'body'  =>  json_encode($param,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE),
                'headers' => array_merge(['content-type' => 'application/json'],$headers)
            ];
         */

        if ($request_type == 'json'){
            $data = [
                'body'  =>  json_encode($data,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE),
                'headers' => array_merge(['content-type' => 'application/json'],$headers)
            ];
        }

        if ($request_type == 'form_params'){
            $data = [
                'form_params' => ($data),
                'headers' => array_merge(['content-type' => 'application/x-www-form-urlencoded'],$headers)
            ];
        }

        $clientFactory = make(ClientFactory::class);
        $response = $clientFactory->create()->post($uri,$data)->getBody();

        return json_decode($response, true);
    }
}