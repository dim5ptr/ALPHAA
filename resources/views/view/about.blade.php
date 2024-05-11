@extends('layouts.app')

@section('title', 'About Us')

@section('header')
    <!-- Styles or scripts specific to the header can be added here -->
@endsection
@section('main')
    @include('layouts.navigation')
    <section class="pt-2 container pb-5">
        <div class="card text-center border-2" style="background-color: #007bff;">
            <div class="card-body">
                <h2 class="card-title" style="color: #FFFFFF;">About Us</h2>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <h1 class="text-center mb-4">Sarastya Technology Integrata (STI)</h1>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-6">
                <img src="{{ asset('img/gambar1.jpg') }}" class="img-fluid" alt="Sarastya Technology" style="width: 100%; height: auto;">
            </div>
            <div class="col-md-6">
                <p>Didirikan berdasarkan impian dan harapan para pendiri untuk membantu pertumbuhan perusahaan dimana setiap dapat saling berkolaborasi dan terhubung melalui teknologi. Kami meyakini dengan yang dapat mengintegrasikan dan dapat membantu mewujudkan pertumbuhan perusahaan secara berkelanjutan (suistainability).</p>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-6">
                <h3>Visi</h3>
                <p>Menjadi yang terbaik di Indonesia sebagai penyedia yang dapat mengintegrasikan seluruh fungsi bisnis dan tata kelola perusahaan dengan pertumbuhan yang berkelanjutan (sustainability).</p>
            </div>
            <div class="col-md-6">
                <h3>Misi</h3>
                <ol>
                    <li>Menyediakan produk terbaik kepada pelaku bisnis yang mengintegrasikan dan sesuai standar Internasional.</li>
                    <li>Mengembangkan smart-technology yang mengedepankan kebutuhan dan kemudahan para pengguna dan stakeholders.</li>
                    <li>Menyediakan layanan edukasi dan implementasi produk secara sistematis dan terstruktur kepada para pelanggan.</li>
                    <li>Membentuk wadah yang inspiratif dan saling mendukung kepada individu, akademis, praktisi teknologi maupun pebisnis untuk mewujudkan teknologi yang mendukung pertumbuhan manusia.</li>
                </ol>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <h1 class="text-center mb-4">Prakerin Sarastya Technology Integrata</h1>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <h3 class="text-center mb-4">STI Overview</h3>
                <embed src="{{ asset('pdf/STI.Overview .pdf') }}" type="application/pdf" width="100%" height="600px">
            </div>
        </div>
    </section>
@endsection


@section('footer')
    <div class=" p-1" style="background-color: #00008B;">
        <div class="card text-center" style="background: #00008B">
            <div class="card-header" style="background: #00008B">
            </div>
            <div class="card-body">
                <h5 class="card-title text-light">Web Pendaftaran PKL</h5>
                <p class="card-text text-light">Your Place for PKL Registration</p>
                <a href="tes_pkl" class="btn btn-primary">Start Registration</a>
            </div>
            <div class="card-footer text-light" style="background: #00008B">
                Copyright &copy; Web Pendaftaran PKL 2024
            </div>
        </div>
    </div>
@endsection
