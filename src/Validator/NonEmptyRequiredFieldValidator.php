<?php

namespace App\Validator;

use App\Constant\Code;
use App\Middleware\InputDataValidatorMiddleware;
use App\Middleware\MiddlewareInterface;

class NonEmptyRequiredFieldValidator implements MiddlewareInterface{

    private $next=null;

    public function __invoke($request , &$response){

        foreach($request as $key => $value){
            if(empty($value)){
                $response['code'] = Code::CODE_400;
                $response['error'] = true;
                $response['message'] = 'Une ou plusieurs objects obligatoires sont manquantes';
                break;
            }
        }

        if(!InputDataValidatorMiddleware::validateResponse($response) ){
            return $response;
        }
        if($this->next){
            return ($this->next)($request, $response);
        }

        return $response;
    }

    public function setNext($next=null){
        $this->next = $next;
    }
    
}