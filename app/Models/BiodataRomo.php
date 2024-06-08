<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiodataRomo extends Model
{
    use HasFactory;

    protected $table = "biodata_romo";
    protected $fillable = [
        'nama',
        'jabatan',
        'photo',
        'tanggal_lahir',
        'keterangan',
    ];
}
