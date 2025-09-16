@extends('layouts.app')

@section('title', 'Tambah Arsip Surat')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-plus-circle text-success"></i>
        Tambah Arsip Surat Baru
    </h1>
    <a href="{{ route('arsip-surat.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-file-upload"></i>
                    Form Arsip Surat
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('arsip-surat.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="judul_surat" class="form-label">
                            Judul Surat <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                            class="form-control @error('judul_surat') is-invalid @enderror"
                            id="judul_surat"
                            name="judul_surat"
                            value="{{ old('judul_surat') }}"
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
                                {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
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
                            value="{{ old('tanggal_surat') }}"
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
                            placeholder="Deskripsi singkat tentang surat...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="file_pdf" class="form-label">
                            File PDF <span class="text-danger">*</span>
                        </label>
                        <input type="file"
                            class="form-control @error('file_pdf') is-invalid @enderror"
                            id="file_pdf"
                            name="file_pdf"
                            accept=".pdf"
                            required>
                        <div class="form-text">
                            <i class="fas fa-info-circle"></i>
                            Upload file PDF maksimal 10MB
                        </div>
                        @error('file_pdf')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('arsip-surat.index') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-times"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan
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
                    <i class="fas fa-lightbulb"></i>
                    Petunjuk
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success"></i> Pastikan judul surat jelas dan deskriptif</li>
                    <li><i class="fas fa-check text-success"></i> Pilih kategori yang sesuai</li>
                    <li><i class="fas fa-check text-success"></i> File harus dalam format PDF</li>
                    <li><i class="fas fa-check text-success"></i> Ukuran file maksimal 10MB</li>
                    <li><i class="fas fa-check text-success"></i> Tanggal sesuai dengan tanggal pembuatan surat</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('file_pdf').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.type !== 'application/pdf') {
                Swal.fire({
                    icon: 'error',
                    title: 'Format File Salah',
                    text: 'Hanya file PDF yang diperbolehkan!'
                });
                this.value = '';
                return;
            }

            if (file.size > 10 * 1024 * 1024) { // 10MB
                Swal.fire({
                    icon: 'error',
                    title: 'Ukuran File Terlalu Besar',
                    text: 'Ukuran file maksimal 10MB!'
                });
                this.value = '';
                return;
            }
        }
    });
</script>
@endpush