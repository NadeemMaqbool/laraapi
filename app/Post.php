<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'content', 'image','is_modified'
    ];

    public function user()
    {
        return $this->belongsTo('App\Post', 'user_id', 'id');
    }
}
