<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetugasIbadah extends Model
{
    use HasFactory;

    protected $table = "petugas_ibadah";
    protected $fillable = [
        'fakultas_id',
        'nama',
        'npm',
        'kontak',
    ];

    public function fakultas(){
        return $this->belongsTo(Fakultas::class, "fakultas_id");
    }

    public function anggota(){
        return $this->hasMany(Anggota::class, "petugas_id", "id");
    }
}
