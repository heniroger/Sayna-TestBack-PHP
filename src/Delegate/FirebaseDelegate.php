<?php 

namespace App\Delegate;

use Google\Cloud\Firestore\FirestoreClient;
use Kreait\Firebase\Contract\Auth;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class FirebaseDelegate implements FirebaseDelegateInterface{

    private $auth;
    private $database;
    private $parameterBag;
    private $config=[];

    public function __construct(Auth $auth, ParameterBagInterface $parameterBag)
    {
        $this->auth = $auth;
        $this->parameterBag = $parameterBag;

        $strConfig = file_get_contents($this->parameterBag->get('firebase_app_credentials'));
        $this->config = json_decode($strConfig, true);
        
        $this->database = new FirestoreClient([
            'projectId' => $this->config['project_id']
        ]);
    }

    public function getToken(string $email): string {
        return $this->auth->createCustomToken($email,[],7200)->toString();
    }

    public function save($path, $data=[]){
        $elementsRef = $this->database->collection($path);
        $elementsRef->add($data);
    }

    public function findBy($path, $data){
        $query = null;
        $elementsRef = $this->database->collection($path);
        foreach($data as $key => $value){
            $query = $elementsRef->where($key, $value[0], $value[1]);
        }

        $data = [];
        if($query){
            $documents = $query->documents();
            foreach($documents as $document){
                $data[] = $document->data();
            }
        }
        return $data;
    }

}