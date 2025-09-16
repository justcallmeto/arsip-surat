<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArsipSurat extends Model
{
    /** @use HasFactory<\Database\Factories\ArsipSuratFactory> */
    use HasFactory;
    protected $fillable = [
        'judul_surat', 
        'kategori_id', 
        'tanggal_surat', 
        'deskripsi', 
        'file_pdf'
    ];
    
    public function kategoriSurat()
    {
        return $this->belongsTo(KategoriSurat::class, 'kategori_id');
    }
}
