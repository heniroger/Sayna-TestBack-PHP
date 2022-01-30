<?php 

namespace App\Delegate;

use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Contract\Database;

class FirebaseDelegate implements FirebaseDelegateInterface{

    private $auth;
    private $database;

    public function __construct(Auth $auth, Database $database)
    {
        $this->auth = $auth;
        $this->database = $database;
    }

    public function getToken(string $email): string {
        return $this->auth->createCustomToken($email,[],7200)->toString();
    }

    public function save($path, $data=[]){
        $this->database->getReference($path)
                                ->set($data)
        ;
    }
}