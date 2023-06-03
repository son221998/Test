<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appversion extends Model
{
    use HasFactory;
    protected $table = 'appversions';
    protected $fillable = [
        'version',
        'platform',
        'description',
        'status'
    ];
}
