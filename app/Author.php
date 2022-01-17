<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Author extends Authenticatable
{
    //

    use HasRoles;

    protected $hidden = ['status','password','remember_token','created_at','updated_at'];

    public function categories()
    {
        return $this->belongsToMany(Category::class,AuthorCategory::class,'author_id','category_id');
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'author_id', 'id');
    }
}
