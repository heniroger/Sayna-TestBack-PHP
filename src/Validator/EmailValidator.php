<?php

namespace App\Validator;

use App\Constant\Code;
use App\Middleware\InputDataValidatorMiddleware;
use App\Middleware\MiddlewareInterface;

class EmailValidator implements MiddlewareInterface{

    private $next=null;

    public function __invoke($request , &$response){

        $email = $request->email;

        if(filter_var($email,FILTER_VALIDATE_EMAIL) === false){
            $response['code'] = Code::CODE_400;
            $response['error'] = true;
            $response['message'] = 'Email incorrecte';
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