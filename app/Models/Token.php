<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Token extends Model
{
    protected $fillable = [
        'token'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
