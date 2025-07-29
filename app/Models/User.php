<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class User extends Model
{
    protected $guarded=[];

    use HasFactory;
    use SoftDeletes;
    use HasApiTokens;
     public function posts() 
   {
       return $this->hasMany(Post::class);
   } 
}
