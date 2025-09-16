@extends('layouts.app')

@section('title', 'Arsip Surat - Kelurahan Karangduren')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Arsip Surat Kelurahan Karangduren</h1>
</div>

<!-- Search Bar -->
<div class="row mb-4">
    <div class="col-md-8">
        <form method="GET" action="{{ route('arsip-surat.index') }}" class="d-flex">
            <input type="text" name="search" class="form-control me-2"
                placeholder="Cari berdasarkan judul surat..."
                value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-search"></i> Cari
            </button>
            @if(request('search'))
            <a href="{{ route('arsip-surat.index') }}" class="btn btn-secondary ms-2">
                <i class="fas fa-times"></i> Reset
            </a>
            @endif
        </form>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('arsip-surat.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Arsipkan Surat..
        </a>
    </div>
</div>

@if(request('search'))
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i>
    Menampilkan hasil pencarian untuk: "<strong>{{ request('search') }}</strong>"
    ({{ $arsipSurats->count() }} hasil ditemukan)
</div>
@endif

<!-- Tabel Arsip Surat -->
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Judul Surat</th>
                <th>Kategori</th>
                <th>Tanggal Surat</th>
                <th>Deskripsi</th>
                <th>File PDF</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($arsipSurats as $index => $surat)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $surat->judul_surat }}</strong>
                </td>
                <td>
                    <span class="badge bg-info">{{ $surat->kategoriSurat->nama_kategori }}</span>
                </td>
                <td>{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d/m/Y') }}</td>
                <td>{{ Str::limit($surat->deskripsi, 50) }}</td>
                <td>
                    <i class="fas fa-file-pdf text-danger"></i>
                    {{ basename($surat->file_pdf) }}
                </td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="{{ route('arsip-surat.show', $surat) }}"
                            class="btn btn-sm btn-info" title="Lihat Detail">
                            <i class="fas fa-eye"></i> Lihat >>
                        </a>
                        <a href="{{ route('arsip-surat.download', $surat) }}"
                            class="btn btn-sm btn-success" title="Download PDF">
                            <i class="fas fa-download"></i> Unduh
                        </a>
                        <a href="{{ route('arsip-surat.edit', $surat) }}"
                            class="btn btn-sm btn-warning" title="Edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button type="button" class="btn btn-sm btn-danger"
                            onclick="confirmDelete({{ $surat->id }}, '{{ $surat->judul_surat }}')"
                            title="Hapus">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>

                    <form id="delete-form-{{ $surat->id }}"
                        action="{{ route('arsip-surat.destroy', $surat) }}"
                        method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-4">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">
                        @if(request('search'))
                        Tidak ada surat yang ditemukan dengan kata kunci "{{ request('search') }}"
                        @else
                        Belum ada arsip surat. <a href="{{ route('arsip-surat.create') }}">Tambahkan yang pertama</a>
                        @endif
                    </p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Summary -->
@if($arsipSurats->count() > 0)
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card bg-light">
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <h4 class="text-primary">{{ $arsipSurats->count() }}</h4>
                        <p class="text-muted">Total Surat</p>
                    </div>
                    <div class="col-md-3">
                        <h4 class="text-success">{{ $arsipSurats->where('kategoriSurat.nama_kategori', 'Undangan')->count() }}</h4>
                        <p class="text-muted">Undangan</p>
                    </div>
                    <div class="col-md-3">
                        <h4 class="text-info">{{ $arsipSurats->where('kategoriSurat.nama_kategori', 'Pengumuman')->count() }}</h4>
                        <p class="text-muted">Pengumuman</p>
                    </div>
                    <div class="col-md-3">
                        <h4 class="text-warning">{{ $arsipSurats->where('kategoriSurat.nama_kategori', 'Nota Dinas')->count() }}</h4>
                        <p class="text-muted">Nota Dinas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
    function confirmDelete(id, judul) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: `Apakah Anda yakin ingin menghapus surat "${judul}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endpush