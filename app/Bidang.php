<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    public function komentar()
    {
        return $this->hasMany('App\Komentar');
    }
}
