<?php

namespace App\Http\Controllers;

use App\Singletons\Logger;


class SingletonLoggerController extends Controller
{
    protected $client;

    public function __construct()
    {
    }

    public function logTest()
    {
        $log = Logger::getInstance();
        $log->log('Singleton is called logger method 1');
        return "ok";
    }


}
