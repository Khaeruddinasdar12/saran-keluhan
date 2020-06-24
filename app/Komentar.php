<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    public function bidang()
    {
        return $this->belongsTo('App\Bidang');
    }
}
