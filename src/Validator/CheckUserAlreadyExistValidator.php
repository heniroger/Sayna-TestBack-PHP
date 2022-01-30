<?php

namespace App\Validator;

use App\Constant\Code;
use App\Delegate\FirebaseDelegateInterface;
use App\Middleware\InputDataValidatorMiddleware;
use App\Middleware\MiddlewareInterface;

class CheckUserAlreadyExistValidator implements MiddlewareInterface{

    private $next=null;

    private $firebaseDelegate;

    public function __construct(FirebaseDelegateInterface $firebaseDelegate)
    {
        $this->firebaseDelegate = $firebaseDelegate;
    }

    public function __invoke($request , &$response){

           $email = $request->email;
        
           $result = $this->firebaseDelegate->findBy('users',['email' => ["=", $email ]]);

            if(count($result) > 0){
                $response['code'] = Code::CODE_409;
                $response['error'] = true;
                $response['message'] = 'Un compte utilisant cette addresse email est déjà enregisté';
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