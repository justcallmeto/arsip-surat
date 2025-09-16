@extends('layouts.app')

@section('title', 'Edit Arsip Surat')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-edit text-warning"></i>
        Edit Arsip Surat
    </h1>
    <a href="{{ route('arsip-surat.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0">
                    <i class="fas fa-file-edit"></i>
                    Form Edit Arsip Surat
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('arsip-surat.update', $arsipSurat) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="judul_surat" class="form-label">
                            Judul Surat <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('judul_surat') is-invalid @enderror" 
                               id="judul_surat" 
                               name="judul_surat" 
                               value="{{ old('judul_surat', $arsipSurat->judul_surat) }}"
                               placeholder="Masukkan judul surat..."
                               required>
                        @error('judul_surat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">
                            Kategori Surat <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('kategori_id') is-invalid @enderror" 
                                id="kategori_id" 
                                name="kategori_id" 
                                required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" 
                                        {{ old('kategori_id', $arsipSurat->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_surat" class="form-label">
                            Tanggal Surat <span class="text-danger">*</span>
                        </label>
                        <input type="date" 
                               class="form-control @error('tanggal_surat') is-invalid @enderror" 
                               id="tanggal_surat" 
                               name="tanggal_surat" 
                               value="{{ old('tanggal_surat', $arsipSurat->tanggal_surat) }}"
                               required>
                        @error('tanggal_surat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" 
                                  name="deskripsi" 
                                  rows="3" 
                                  placeholder="Deskripsi singkat tentang surat...">{{ old('deskripsi', $arsipSurat->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="file_pdf" class="form-label">File PDF</label>
                        <input type="file" 
                               class="form-control @error('file_pdf') is-invalid @enderror" 
                               id="file_pdf" 
                               name="file_pdf" 
                               accept=".pdf">
                        <div class="form-text">
                            <i class="fas fa-info-circle"></i>
                            Kosongkan jika tidak ingin mengubah file. File saat ini: 
                            <strong>{{ basename($arsipSurat->file_pdf) }}</strong>
                        </div>
                        @error('file_pdf')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('arsip-surat.index') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-times"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0">
                    <i class="fas fa-file-pdf"></i>
                    File Saat Ini
                </h6>
            </div>
            <div class="card-body">
                <p><strong>Nama File:</strong><br>{{ basename($arsipSurat->file_pdf) }}</p>
                <p><strong>Tanggal Upload:</strong><br>{{ $arsipSurat->created_at->format('d/m/Y H:i') }}</p>
                <a href="{{ route('arsip-surat.download', $arsipSurat) }}" 
                   class="btn btn-success btn-sm">
                    <i class="fas fa-download"></i> Download File
                </a>
            </div>
        </div>
    </div>
</div>
@endsection