<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that are searchable.
     *
     * @var  array
     */
    public $searchable = [
        'name', 'email',
    ];

    /**
     * Get the partner of the user.
     *
     * @return  \Illuminate\Database\Eloquent\Concerns\belongsTo
     */
    public function partner()
    {
        return $this->belongsTo($this, 'partner_id');
    }

    /**
     * Get the stories owned by the user.
     *
     * @return  \Illuminate\Database\Eloquent\Concerns\hasMany
     */
    public function stories()
    {
        return $this->hasMany('App\Story');
    }
}
