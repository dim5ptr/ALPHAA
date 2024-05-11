@extends('layouts.app')

@section('title', 'Tes PKL')

@section('header')
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 100px;
        }

        h1 {
            color: #343a40;
        }

        .alert {
            background-color: #dc3545;
            color: #fff;
        }
    </style>
@endsection

@section('main')
    <div class="container text-center">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#accessDeniedModal">
            Buka Pesan
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="accessDeniedModal" tabindex="-1" aria-labelledby="accessDeniedModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accessDeniedModalLabel">Anda perlu persetujuan admin untuk mengakses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Silakan hubungi admin untuk informasi lebih lanjut.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Kembali ke Halaman Utama</a>
                </div>
            </div>
        </div>
    </div>
@endsection
