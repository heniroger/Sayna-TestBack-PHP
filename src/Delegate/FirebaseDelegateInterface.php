<?php

namespace App\Delegate;


interface FirebaseDelegateInterface {

     public function getToken(string $email): string;

}