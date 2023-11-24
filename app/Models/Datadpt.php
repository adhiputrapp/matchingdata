<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datadpt extends Model
{
    use HasFactory;

    protected $table = 'dpt';

    protected $fillable = [
        'desa',
        'kpm',
        'rt',
        'rw',
        'tps',
    ];
}
