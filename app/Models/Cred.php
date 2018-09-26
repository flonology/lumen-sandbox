<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Cred extends Model
{
    protected $fillable = [
        'cred_item'
    ];

    protected $hidden = [
    ];


    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
