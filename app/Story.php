<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var  array
     */
    protected $fillable = [
        'season', 'episode', 'publish_date', 'title', 'plot', 'synopsis',
    ];

    /**
     * The attributes that are searchable.
     *
     * @var  array
     */
    public $searchable = [
        'title', 'plot', 'synopsis',
    ];

    /**
     * Get the user that owns the story.
     *
     * @return  \Illuminate\Database\Eloquent\Concerns\belongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
