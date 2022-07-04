<?php

namespace Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    public function vehicles()
    {
        return $this->hasOne(Vehicle::class);
    }

    public function people()
    {
        return $this->hasMany(Person::class);
    }
}