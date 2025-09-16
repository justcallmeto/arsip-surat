@extends('layouts.app')

@section('title', 'Tambah Kategori Surat - Kelurahan Karangduren')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-plus-circle text-success"></i>
        Tambah Kategori Surat
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('kategori-surat.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-folder-plus"></i>
                    Form Tambah Kategori Surat
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('kategori-surat.store') }}" method="POST">
                    @csrf
                    
                    <!-- Nama Kategori -->
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">
                            <i class="fas fa-tag"></i> Nama Kategori <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('nama_kategori') is-invalid @enderror" 
                               id="nama_kategori" 
                               name="nama_kategori" 
                               value="{{ old('nama_kategori') }}"
                               placeholder="Contoh: Undangan, Pengumuman, Nota Dinas, dll"
                               required>
                        @error('nama_kategori')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle"></i>
                            Nama kategori harus unik dan tidak boleh sama dengan kategori yang sudah ada.
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-4">
                        <label for="deskripsi" class="form-label">
                            <i class="fas fa-align-left"></i> Deskripsi
                        </label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" 
                                  name="deskripsi" 
                                  rows="4"
                                  placeholder="Masukkan deskripsi singkat tentang kategori surat ini (opsional)">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle"></i>
                            Deskripsi ini akan membantu pengguna memahami jenis surat yang masuk dalam kategori ini.
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('kategori-surat.index') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Card -->
        <div class="card mt-4 border-info">
            <div class="card-header bg-info text-white">
                <h6 class="card-title mb-0">
                    <i class="fas fa-lightbulb"></i> Tips Penggunaan
                </h6>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <li class="mb-2">
                        <strong>Nama Kategori:</strong> Gunakan nama yang singkat dan jelas seperti "Undangan", "Pengumuman", "Nota Dinas", dll.
                    </li>
                    <li class="mb-2">
                        <strong>Deskripsi:</strong> Berikan penjelasan singkat tentang jenis surat yang akan dikelompokkan dalam kategori ini.
                    </li>
                    <li class="mb-0">
                        <strong>Konsistensi:</strong> Pastikan kategori yang dibuat konsisten dengan sistem pengarsipan yang sudah ada.
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto focus pada input pertama
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('nama_kategori').focus();
    });

    // Validasi client-side
    document.querySelector('form').addEventListener('submit', function(e) {
        const namaKategori = document.getElementById('nama_kategori').value.trim();
        
        if (namaKategori.length === 0) {
            e.preventDefault();
            Swal.fire({
                title: 'Peringatan',
                text: 'Nama kategori harus diisi!',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return false;
        }

        if (namaKategori.length < 3) {
            e.preventDefault();
            Swal.fire({
                title: 'Peringatan', 
                text: 'Nama kategori minimal 3 karakter!',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return false;
        }
    });
</script>
@endpush