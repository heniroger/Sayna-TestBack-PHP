<?php

namespace App\Validator;

use App\Constant\Code;
use App\Middleware\InputDataValidatorMiddleware;
use App\Middleware\MiddlewareInterface;

class PasswordValidator implements MiddlewareInterface{

    private $next=null;

    public function __invoke($request , &$response){

        $password = $request->password;
        $retypePassword = $request->retypePassword;

        if(strlen($password) < 6 || $password !== $retypePassword){
            $response['code'] = Code::CODE_400;
            $response['error'] = true;
            $response['message'] = 'Mot de passe incorrecte!';
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