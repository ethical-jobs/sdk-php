<?php

namespace Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    public function family()
    {
        return $this->belongsTo(Family::class);
    }
}