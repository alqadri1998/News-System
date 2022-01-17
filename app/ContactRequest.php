<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model
{
    //
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
