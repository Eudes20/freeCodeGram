<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = [];

    public function profileImage()
    {
        $checkImagePath = ($this->image) ? $this->image : 'profile/no_profile_1.jpg';

        return '/storage/'.$checkImagePath;
    }
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function followers()
    {
        return $this->belongsToMany('App\User');
    }
}
