<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use function Symfony\Component\Translation\t;

class TestController extends Controller
{
    protected $newsModel;
    protected $categoryModel;

    public function __construct(News $newsModel, Category $categoryModel)
    {
        $this->newsModel = $newsModel;
        $this->categoryModel = $categoryModel;
    }

    public function isCategoryUnique()
    {
        $name = 'ایران';
        $tag = $this->categoryModel->where('name', $name)->get();
        if(count($tag)===0){
            return 't';
        }else{
            $lastPost=$tag[0]->news->max('published_at');
            return $lastPost;
        }
//        $tag=$this->categoryModel->find(1);
//        $post=$this->newsModel->find(50);
//        $result=$post->categories()->save($tag);
////
//        return $result;
//        dd($tag->news);
//        $tag1 =$this->categoryModel->create(['name' => 'Laravel', 'slug' => 'laravel', 'created_at' => Carbon::now()]);
//        $tag2 =$this->categoryModel->create(['name' => 'PHP', 'slug' => 'php', 'created_at' => Carbon::now()]);
//        return [$tag1, $tag2];


//        $news=$this->newsModel->find(2);
//        $category=$news->categories;
//        return $category;

//        $tag=$this->categoryModel->find(1);
//        $news=$tag->news;
//        return ($news);


    }

}
