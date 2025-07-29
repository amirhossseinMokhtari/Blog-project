<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    protected $guarded=[];
    use HasFactory;
    use SoftDeletes;

/**
    * Get the user that owns the Post
    *
    *  \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function user() 
   {
       return $this->belongsTo(User::class);
   } 
// 'foreign_key', 'other_key'
}