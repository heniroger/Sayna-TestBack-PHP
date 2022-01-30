<?php

namespace App\Middleware;


interface MiddlewareInterface{

    public function setNext($next=null);
    public function __invoke($request , &$response);
}