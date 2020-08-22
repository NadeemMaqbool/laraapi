<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelLike\Traits\Likeable;

class Post extends Model
{
    use Likeable;
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
