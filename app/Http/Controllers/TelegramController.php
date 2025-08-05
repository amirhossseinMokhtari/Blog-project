<?php

namespace App\Http\Controllers;

use App\Enums\HttpStatusCodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;


class TelegramController extends Controller
{
    public function index(Request $request)
    {
        // Your logic here
    }
    public function getTelegramBot(): \Illuminate\Http\JsonResponse
    {
        Log::info('torokhoda');
        return response::json(['status' => ['message' => HttpStatusCodes::OK->message(),
        'code' => HttpStatusCodes::OK->value]]);
    }
}
