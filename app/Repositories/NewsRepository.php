<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class NewsRepository
{
    protected $newsModel;
    protected $categoryModel;

    public function __construct(News $newsModel,Category $categoryModel)
    {
        $this->newsModel = $newsModel;
        $this->categoryModel = $categoryModel;
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
            'published_at' => $request['published_at'],
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

    public function isCategoryUnique($name)
    {
        $tag = $this->categoryModel->where('name', $name)->get();
        if(count($tag)===0){
            return false;
        }else{
            $lastPost=$tag[0]->news->max('published_at');
            return $lastPost;
        }
    }

}
