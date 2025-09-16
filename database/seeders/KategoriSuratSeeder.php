<?php

namespace Database\Seeders;

use App\Models\KategoriSurat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            ['nama_kategori' => 'Undangan', 'deskripsi' => 'Surat undangan resmi'],
            ['nama_kategori' => 'Pengumuman', 'deskripsi' => 'Surat pengumuman'],
            ['nama_kategori' => 'Nota Dinas', 'deskripsi' => 'Nota dinas internal'],
            ['nama_kategori' => 'Pemberitahuan', 'deskripsi' => 'Surat pemberitahuan']
        ];
        
        foreach ($kategoris as $kategori) {
            KategoriSurat::create($kategori);
        }
    }
}
