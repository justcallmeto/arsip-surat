@extends('layouts.app')

@section('title', 'Kategori Surat')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kategori Surat</h1>
</div>

<div class="row mb-4">
    <div class="col-12 text-end">
        <a href="{{ route('kategori-surat.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Tambah Kategori
        </a>
    </div>
</div>

@if($kategoris->count() > 0)
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Jumlah Surat</th>
                <th>Dibuat</th>
                <th width="150px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategoris as $index => $kategori)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <span class="badge bg-info fs-6">{{ $kategori->nama_kategori }}</span>
                </td>
                <td>{{ $kategori->deskripsi ?: '-' }}</td>
                <td>
                    <span class="badge bg-secondary">{{ $kategori->arsipSurats->count() }}</span>
                </td>
                <td>{{ $kategori->created_at->format('d/m/Y') }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="{{ route('kategori-surat.edit', $kategori) }}" 
                           class="btn btn-sm btn-warning" title="Edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button class="btn btn-sm btn-danger" 
                                onclick="confirmDelete({{ $kategori->id }}, '{{ $kategori->nama_kategori }}', {{ $kategori->arsipSurats->count() }})" 
                                title="Hapus">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="alert alert-info text-center">
    <i class="fas fa-info-circle fa-2x mb-2"></i>
    <h5>Tidak ada kategori surat</h5>
    <p class="mb-3">Belum ada kategori yang ditambahkan</p>
    <a href="{{ route('kategori-surat.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Tambah Kategori Pertama
    </a>
</div>
@endif

<!-- Form Hidden untuk Delete -->
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
function confirmDelete(id, nama, jumlahSurat) {
    if (jumlahSurat > 0) {
        Swal.fire({
            title: 'Tidak Dapat Menghapus',
            text: `Kategori "${nama}" masih digunakan oleh ${jumlahSurat} surat. Hapus semua surat dengan kategori ini terlebih dahulu.`,
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }

    Swal.fire({
        title: 'Hapus Kategori',
        text: `Apakah Anda yakin ingin menghapus kategori "${nama}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('delete-form');
            form.action = `/kategori-surat/${id}`;
            form.submit();
        }
    });
}
</script>
@endpush