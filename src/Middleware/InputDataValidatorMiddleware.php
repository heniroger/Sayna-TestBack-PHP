<?php

namespace App\Middleware;

use App\Constant\Code;

class InputDataValidatorMiddleware implements ServerMiddlewareInterface{

    private $middlewares=[];

    public function pipe($middleware){
        if(empty($this->middlewares)){
            $this->middlewares[] = $middleware;
        }else{
            $count = count($this->middlewares);
            $previous = $this->middlewares[$count-1];
            $previous->setNext($middleware);
            $this->middlewares[] = $middleware;
        }

    }

    public function process($request, &$response=[])
    {
        if(!empty($this->middlewares)){
            $first = $this->middlewares[0];
            $response = $first($request, $response);
        }
        return $response;
    }

    public static function validateResponse($response=[]){
        $valid=false;
        if(empty($response) || $response['code'] === Code::CODE_200){
            $valid=true;
        }
        return $valid;
    }
}