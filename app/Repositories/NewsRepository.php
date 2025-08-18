<?php

namespace App\Repositories;

use App\Models\News;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NewsRepository
{
    protected $newsModel;

    public function __construct(News $newsModel)
    {
        $this->newsModel = $newsModel;
    }

    public function all()
    {
        return $this->newsModel->all();
    }

    public function findByUrl($url)
    {
        return $this->newsModel->where('url', $url)->first();
    }



    public function create(array $request)
    {
        Log::info('news', $request);
        $postData = [
            'title' => $request['title'],
            'lead' => $request['lead'],
            'body' => $request['body'],
            'image_url' => $request['image_url'],
            'url' => $request['news_url'],
            'date' => $request['date'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $news = $this->newsModel->create($postData);
        return $news;
    }

    public function isUrlUnique($url)
    {
        return $this->newsModel->where('url', $url)->doesntExist();
    }

}
