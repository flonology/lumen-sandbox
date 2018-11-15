<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class User extends Model
{
    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        'password',
    ];

    public function creds()
    {
        return $this->hasMany('App\Models\Cred');
    }

    public function tokens()
    {
        return $this->hasMany('App\Models\Token');
    }
}
