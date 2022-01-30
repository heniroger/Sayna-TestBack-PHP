<?php

namespace App\Delegate;


interface FirebaseDelegateInterface {

     public function getToken(string $email): string;

     public function save($path, $data=[]);
     
     public function findBy($path, $data);
}