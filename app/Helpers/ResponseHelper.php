<?php

function success($message,$data){
    return response()->json([
        "status"=>"success",
        "message"=>$message,
        "data"=>$data
    ]);
}