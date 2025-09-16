<?php

namespace App\Singletons;

use Illuminate\Support\Facades\Log;

class Logger
{
    private static $instance = null;

    private function __construct()
    {
    }

    private function __clone(){
        throw new \Exception('Cloning is not allowed.');
    }
    private function __wakeup(){
        throw new \Exception('Cloning is not allowed.');
    }
    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new logger();
        }
        return self::$instance;
    }

    public function log($message){
        $objId=spl_object_id($this);
        Log::info("$message object_id : ".$objId);
    }

}
