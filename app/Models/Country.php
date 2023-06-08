<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    
    protected $table = 'countries';
    protected $fillable = [
        'name',
        'code',
    ];
    public function artists()
    {
        return $this->hasMany(Artist::class, 'country_code', 'code');
    }
    

}
