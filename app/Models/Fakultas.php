<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    use HasFactory;

    protected $table = "fakultas";
    protected $fillable = [
        'prodi_id',
        'nama_fakultas',
    ];

    public function petugas(){
        return $this->hasMany(PetugasIbadah::class, "fakultas_id", "id");
    }

    public function prodi(){
        return $this->belongsTo(Prodi::class, "prodi_id");
    }
}
