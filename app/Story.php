<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use Filterable;

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
        'season', 'episode', 'publish_date', 'title', 'plot', 'synopsis',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'season_episode',
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

    /**
     * Get the episode number relative to current season.
     *
     * @return  integer
     */
    public function getSeasonEpisodeAttribute()
    {
        return season_episode($this->attributes['publish_date'], $this->user->anniversary_date);
    }
}
