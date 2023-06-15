<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Origin extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'link_fb',
        'logo',
    ];
    public function artical() {
        return $this->hasMany(Artical::class);
    }
}
