<?php 

namespace App\Factory;

use Symfony\Component\HttpFoundation\Request;

class DataTransfertFactory {


    public static function buildWithPayload(Request $request, $className=""){
        $data = json_decode($request->getContent(),true);
        $dto = new $className();
        
        foreach($data as $key => $value){
            $dto->{$key} = $value;
        }

        return $dto;
    }
}