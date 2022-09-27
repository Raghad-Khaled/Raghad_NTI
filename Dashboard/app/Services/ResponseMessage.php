<?php
namespace App\Services;


trait ResponseMessage
{
    public function error($message)
    {
        return response()->json(
            [
                'sucsses'=>false,
                'message'=>$message
            ]
        );
    }
    
}