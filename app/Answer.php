<?php

namespace App;

use App\Model;

class Answer extends Model
{
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
