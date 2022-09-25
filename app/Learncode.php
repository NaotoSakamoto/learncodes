<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Learncode extends Model
{
    protected $fillable = ['title', 'language', 'content', 'radioGrp01'];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
