<?php

namespace App\Controller;

use App\Constant\Code;
use App\DataTransfert\RegisterDto;
use App\DataTransfert\ResponseDto;
use App\Delegate\FirebaseDelegateInterface;
use App\Factory\DataTransfertFactory;
use App\Middleware\ServerMiddlewareInterface;
use App\Validator\CheckUserAlreadyExistValidator;
use App\Validator\EmailValidator;
use App\Validator\NonEmptyRequiredFieldValidator;
use App\Validator\PasswordValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends AbstractController{

    private $serverMiddleware;
    private $firebaseDelegate;

    public function __construct(
        ServerMiddlewareInterface $serverMiddleware,
        FirebaseDelegateInterface $firebaseDelegate
    )
    {
        $this->serverMiddleware = $serverMiddleware;
        $this->firebaseDelegate = $firebaseDelegate;    
    }

    public function execute(Request $request){

        $registerDto = DataTransfertFactory::buildWithPayload($request, RegisterDto::class);
        
        $response = ResponseDto::$output;

        $this->serverMiddleware->pipe(new NonEmptyRequiredFieldValidator());
        $this->serverMiddleware->pipe(new EmailValidator());
        $this->serverMiddleware->pipe(new PasswordValidator());
        $this->serverMiddleware->pipe(new CheckUserAlreadyExistValidator($this->firebaseDelegate));
        $this->serverMiddleware->process($registerDto, $response);
        
        if($response['code'] === Code::CODE_200){
            $this->firebaseDelegate->save('users', get_object_vars($registerDto));
        }

        return new JsonResponse($response,$response['code']);
    }
}