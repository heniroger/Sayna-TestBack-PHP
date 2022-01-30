<?php

namespace App\Constant;

use Symfony\Component\HttpFoundation\Response;

class Code{

        public const HTTP_BAD_REQUEST = 400;
    public const HTTP_UNAUTHORIZED = 401;
    public const HTTP_PAYMENT_REQUIRED = 402;
    public const HTTP_FORBIDDEN = 403;

    const CODE_200=Response::HTTP_OK; 
    const CODE_400=Response::HTTP_BAD_REQUEST; 
    const CODE_401=Response::HTTP_UNAUTHORIZED; 
    const CODE_402=Response::HTTP_PAYMENT_REQUIRED; 
    const CODE_403=Response::HTTP_FORBIDDEN; 
    const CODE_409=Response::HTTP_CONFLICT; 
}