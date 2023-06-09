<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;
    protected $table = 'artists';
    protected $fillable = [
        'first_name',
        'last_name',
        'also_know_as',
        'place_of_birth',
        'category_artist_id',
        'gender',
        'dob',
        'dod',
        'profile',
        'bio',
        'country_code',
        'history',
        'cover',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'website',
    ];
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }
    
}
