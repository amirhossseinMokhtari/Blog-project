<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    protected $table = 'scraped_news';
    protected $fillable = ['title', 'lead', 'body', 'image_url','url', 'date', 'created_at', 'updated_at'];
    use softDeletes;
    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }
}
