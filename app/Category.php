<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    //protected $table = "categories_table";

    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id', 'id');
    }

//    public function authors()
//    {
//        return $this->belongsToMany(Author::class, AuthorCategory::class, 'category_id', 'author_id');
//    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, AuthorCategory::class, 'category_id', 'author_id');
    }
}
