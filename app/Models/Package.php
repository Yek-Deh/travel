<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    //
    use HasFactory;

    public function destination(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Destination::class);

    }

    public function package_amenities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PackageAmenity::class);

    }

    public function package_itineraries(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PackageItinerary::class);

    }

    public function package_photos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PackagePhoto::class);

    }

    public function package_videos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PackageVideo::class);
    }

    public function package_faqs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PackageFaq::class);

    }

    public function tours(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Tour::class);

    }

    public function reviews(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Review::class);

    }
    public function wishlists(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Wishlist::class);

    }
}
