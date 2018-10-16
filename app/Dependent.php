<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dependent extends Model
{
    protected $fillable = [
        'name', 'email', 'telephone', 'client_id','user_id'
    ];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }
}
