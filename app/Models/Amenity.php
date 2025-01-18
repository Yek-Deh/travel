<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    //
    use HasFactory;
    public function package_amenities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PackageAmenity::class);
    }
}
