<?php

namespace App\Controller;

use App\Constant\Code;
use App\DataTransfert\RegisterDto;
use App\DataTransfert\ResponseDto;
use App\Factory\DataTransfertFactory;
use App\Middleware\ServerMiddlewareInterface;
use App\Validator\NonEmptyRequiredFieldValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends AbstractController{

    private $serverMiddleware;

    public function __construct(ServerMiddlewareInterface $serverMiddleware)
    {
        $this->serverMiddleware = $serverMiddleware;    
    }

    public function execute(Request $request){

        $registerDto = DataTransfertFactory::buildWithPayload($request, RegisterDto::class);
        
        $response = ResponseDto::$output;

        $this->serverMiddleware->pipe(new NonEmptyRequiredFieldValidator());
        $this->serverMiddleware->process($registerDto, $response);
        

        return new JsonResponse($response,$response['code']);
    }
}