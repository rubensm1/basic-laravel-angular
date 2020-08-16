<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';
    
    protected $fillable = [
        'user_id',
        'tipo_acao',
        'classe',
        'acao'
    ];

    protected $appends = array('user');
    public function getUserAttribute($value) {
        return User::find($this->user_id);
    }
    public function setUserAttribute($value) {
        $this->user_id = $value->id;
    }

    /*
    * Muitos para um
    */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}