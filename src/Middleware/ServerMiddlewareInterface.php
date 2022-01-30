<?php

namespace App\Middleware;


interface ServerMiddlewareInterface{

    public function pipe(MiddlewareInterface $middleware);
    public function process($request ,  &$response);
}