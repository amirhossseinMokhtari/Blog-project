<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug','created_at','updated_at'];
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'categorizable');

    }
public function news()
{
    return $this->morphedByMany(News::class, 'categorizable');
}
}
