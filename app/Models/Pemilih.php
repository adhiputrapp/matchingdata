<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemilih extends Model
{
    use HasFactory;
    protected $table = 'berita';

    protected $fillable = [
        'korkab',
        'no_hp_korkab',
        'kecamatan',
        'korcam',
        'no_hp_korcam',
        'pendamping',
        'no_hp_pendamping',
        'desa',
        'kpm',
        'no_hp_kpm',
        'rt',
        'rw',
        'tps',
    ];
}