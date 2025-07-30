<?php

namespace App\Http\Resources;

use App\Enums\HttpStatusCodes;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Response;

class PostResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "Response" => ['message' => HttpStatusCodes::OK->message(), 'value' => HttpStatusCodes::OK->value],

            "data" => [
                'id' => $this->id,
                'title' => $this->title,
                'content' => json_decode($this->content, true),
                'study_time_in_min' => $this->study_time_in_min]
        ];
//
    }

//    public static function createResponse($newPost)
//    {
//        if ($newPost) {
//            return Response::json(HttpStatusCodes::OK->message(), HttpStatusCodes::OK->value);
//        } else {
//            return Response::json(HttpStatusCodes::NON_AUTHORITATIVE->message(), HttpStatusCodes::NON_AUTHORITATIVE->value);
//        }
//    }
}
