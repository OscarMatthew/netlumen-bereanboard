<?php

namespace App;

use App\Model;

class Question extends Model
{
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    public function slug()
    {
        return str_replace([' ', ':'], '-', preg_replace('/[^a-z0-9\s:]/', '', strtolower($this->title)));
    }
}
