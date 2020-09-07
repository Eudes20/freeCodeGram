<?php

namespace App;

use App\Mail\SignUp;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password',
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->hasOne('App\Models\Profile');
    }

    public function following()
    {
        return $this->belongsToMany('App\Models\Profile');
    }

    public function posts()
    {
        return $this->hasMany('App\Models\Post')->orderBy('created_at', 'DESC');
    }
    
    //Perform any actions required after the model boots
    protected static function booted()
    {

        //Register a created model event with the dispatcher(repartiteur).
        static::created(function ($user) {
            $user->profile()->create([
                'title' => $user->username,
            ]);

            Mail::to($user->email)->send(new SignUp());
        });
    }
}
