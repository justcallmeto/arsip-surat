@extends('layouts.app')

@section('title', 'About')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">About Developer</h1>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body text-center py-5">
                <!-- Foto Developer (Ganti dengan foto Anda) -->
                <div class="mb-4">
                    <img src="{{ asset('storage/about/christopher-daniel.jpg') }}" 
                         alt="Christopher Daniel" class="rounded-circle shadow" 
                         style="width: 150px; height: 150px; object-fit: cover;">
                </div>

                <!-- Informasi Developer -->
                <h3 class="text-primary mb-3">CHRISTOPHER DANIEL HAMONANGAN SIMARMATA</h3>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <i class="fas fa-id-card text-primary fa-2x mb-2"></i>
                                <h6 class="card-title">NIM</h6>
                                <p class="card-text fs-5"><strong>2231740031</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <i class="fas fa-calendar-alt text-success fa-2x mb-2"></i>
                                <h6 class="card-title">Tanggal Pembuatan</h6>
                                <p class="card-text fs-5"><strong>{{ date('d F Y') }}</strong></p>
                                <small class="text-muted">Aplikasi Arsip Surat</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Aplikasi -->
                <!-- <div class="row mb-4">
                    <div class="col-12">
                        <div class="card border-primary">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-info-circle"></i> Tentang Aplikasi
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="text-start">
                                    Aplikasi <strong>Arsip Surat Kelurahan Karangduren</strong> 
                                    dibuat untuk memenuhi kebutuhan digitalisasi arsip surat di 
                                    lingkungan pemerintahan desa. Aplikasi ini memungkinkan perangkat 
                                    desa untuk menyimpan, mengelola, dan mengakses dokumen surat 
                                    resmi dalam format digital.
                                </p>
                                
                                <div class="row text-start">
                                    <div class="col-md-6">
                                        <h6><i class="fas fa-tools text-warning"></i> Teknologi yang Digunakan:</h6>
                                        <ul class="list-unstyled">
                                            <li><i class="fab fa-laravel text-danger"></i> Laravel 11</li>
                                            <li><i class="fab fa-bootstrap text-primary"></i> Bootstrap 5</li>
                                            <li><i class="fas fa-database text-info"></i> MySQL Database</li>
                                            <li><i class="fab fa-js-square text-warning"></i> JavaScript & SweetAlert2</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h6><i class="fas fa-star text-success"></i> Fitur Utama:</h6>
                                        <ul class="list-unstyled">
                                            <li><i class="fas fa-upload"></i> Upload file PDF</li>
                                            <li><i class="fas fa-download"></i> Download dokumen</li>
                                            <li><i class="fas fa-search"></i> Pencarian surat</li>
                                            <li><i class="fas fa-tags"></i> Manajemen kategori</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

                <!-- Contact Information -->
                <!-- <div class="row">
                    <div class="col-12">
                        <div class="card bg-dark text-white">
                            <div class="card-body">
                                <h6><i class="fas fa-envelope"></i> Kontak Developer</h6>
                                <p class="mb-1">
                                    <i class="fab fa-github"></i> GitHub: 
                                    <a href="#" class="text-light">github.com/username</a>
                                </p>
                                <p class="mb-0">
                                    <i class="fas fa-envelope"></i> Email: 
                                    <a href="mailto:email@example.com" class="text-light">email@example.com</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>
@endsection