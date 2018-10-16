<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name', 'email', 'telephone', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('app\User');
    }

    public function dependants()
    {
        return $this->hasMany('App\Dependent');
    }
}
