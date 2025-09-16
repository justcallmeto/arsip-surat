@extends('layouts.app')

@section('title', 'Edit Kategori Surat - Kelurahan Karangduren')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-edit text-warning"></i>
        Edit Kategori Surat
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
            <div class="card-header bg-warning text-dark">
                <h5 class="card-title mb-0">
                    <i class="fas fa-folder-open"></i>
                    Form Edit Kategori Surat: <strong>{{ $kategoriSurat->nama_kategori }}</strong>
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('kategori-surat.update', $kategoriSurat) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Nama Kategori -->
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">
                            <i class="fas fa-tag"></i> Nama Kategori <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('nama_kategori') is-invalid @enderror" 
                               id="nama_kategori" 
                               name="nama_kategori" 
                               value="{{ old('nama_kategori', $kategoriSurat->nama_kategori) }}"
                               placeholder="Contoh: Undangan, Pengumuman, Nota Dinas, dll"
                               required>
                        @error('nama_kategori')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle"></i>
                            Nama kategori harus unik dan tidak boleh sama dengan kategori lain yang sudah ada.
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
                                  placeholder="Masukkan deskripsi singkat tentang kategori surat ini (opsional)">{{ old('deskripsi', $kategoriSurat->deskripsi) }}</textarea>
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
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Update Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Penggunaan -->
        <div class="card mt-4 border-warning">
            <div class="card-header bg-warning text-dark">
                <h6 class="card-title mb-0">
                    <i class="fas fa-exclamation-triangle"></i> Informasi Penting
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-info-circle text-info"></i> Status Kategori</h6>
                        <ul class="list-unstyled">
                            <li><strong>Kategori:</strong> {{ $kategoriSurat->nama_kategori }}</li>
                            <li><strong>Jumlah Surat:</strong> 
                                <span class="badge bg-primary">{{ $kategoriSurat->arsipSurats->count() }} surat</span>
                            </li>
                            <li><strong>Dibuat:</strong> {{ $kategoriSurat->created_at->format('d/m/Y H:i') }}</li>
                            <li><strong>Terakhir Update:</strong> {{ $kategoriSurat->updated_at->format('d/m/Y H:i') }}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-lightbulb text-warning"></i> Tips Edit</h6>
                        <ul class="mb-0">
                            <li class="mb-1">Pastikan nama kategori tetap jelas dan mudah dipahami</li>
                            <li class="mb-1">Perubahan akan mempengaruhi semua surat dalam kategori ini</li>
                            @if($kategoriSurat->arsipSurats->count() > 0)
                            <li class="mb-0 text-warning">
                                <i class="fas fa-exclamation-circle"></i>
                                Kategori ini sedang digunakan oleh {{ $kategoriSurat->arsipSurats->count() }} surat
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        @if($kategoriSurat->arsipSurats->count() > 0)
        <!-- Daftar Surat yang Menggunakan Kategori -->
        <div class="card mt-4 border-info">
            <div class="card-header bg-info text-white">
                <h6 class="card-title mb-0">
                    <i class="fas fa-list"></i> 
                    Surat yang Menggunakan Kategori Ini ({{ $kategoriSurat->arsipSurats->count() }})
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Surat</th>
                                <th>Tanggal Surat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kategoriSurat->arsipSurats->take(5) as $index => $surat)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ Str::limit($surat->judul_surat, 40) }}</td>
                                <td>{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('arsip-surat.show', $surat) }}" 
                                       class="btn btn-xs btn-outline-primary">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @if($kategoriSurat->arsipSurats->count() > 5)
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    <i class="fas fa-ellipsis-h"></i>
                                    Dan {{ $kategoriSurat->arsipSurats->count() - 5 }} surat lainnya...
                                    <a href="{{ route('arsip-surat.index', ['kategori' => $kategoriSurat->id]) }}" 
                                       class="btn btn-sm btn-outline-info ms-2">
                                        Lihat Semua
                                    </a>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto focus pada input pertama
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('nama_kategori').focus();
        
        // Select text untuk mempermudah edit
        document.getElementById('nama_kategori').select();
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

        // Konfirmasi jika kategori sedang digunakan
        @if($kategoriSurat->arsipSurats->count() > 0)
        e.preventDefault();
        Swal.fire({
            title: 'Konfirmasi Update',
            text: 'Kategori ini sedang digunakan oleh {{ $kategoriSurat->arsipSurats->count() }} surat. Apakah Anda yakin ingin mengupdate?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Update!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                e.target.submit();
            }
        });
        @endif
    });
</script>
@endpush