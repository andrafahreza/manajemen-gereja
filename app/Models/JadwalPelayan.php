<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPelayan extends Model
{
    use HasFactory;

    protected $table = "jadwal_pelayan";
    protected $fillable = [
        'fakultas_id',
        'nama_jadwal',
        'jadwal',
        'status',
    ];

    public function fakultas(){
        return $this->belongsTo(Fakultas::class, "fakultas_id");
    }

}
