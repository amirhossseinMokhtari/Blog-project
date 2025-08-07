<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'body' => $this->body ?? null,
            'study_time_in_min' => $this->study_time_in_min,
            'created_at'=>$this-> created_at
        ];
    }
}
