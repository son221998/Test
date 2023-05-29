<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;
    protected $table = 'tags';
    protected $fillable = 
    [
        'title',
        'description'
    ];
    public function artical()
    {
        return $this->hasMany(Artical::class);
    }

}

