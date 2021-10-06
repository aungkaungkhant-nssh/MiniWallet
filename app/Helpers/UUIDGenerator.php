<?php

namespace App\Helpers;

use App\Models\Transcation;
use App\Models\Wallet;

class UUIDGenerator{
    public static function accountNumber(){
        $number=mt_rand(1000000000000000,9999999999999999);
        $wallet=Wallet::where("account_number",$number)->exists();
        if($wallet){
            return self::accountNumber();
        }
        return $number;
    }
    public static function refNumber(){
        $number=mt_rand(1000000000000000,9999999999999999);
        if(Transcation::where("ref_id",$number)->exists()){
            return self::refNumber();
        }
        return $number;
    }
    public static function trxNumber(){
        $number=mt_rand(1000000000000000,9999999999999999);
        if(Transcation::where("trx_id",$number)->exists()){
            return self::refNumber();
        }
        return $number;
    }
}