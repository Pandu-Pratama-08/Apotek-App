@extends('templates.app')

@section('content-dinamis')
    @if (Session::get('failed'))
        <div class="alert alert-danger">{{ Session::get('failed') }}</div>
    @endif

    <div class="welcome-box">
        <h1 class="mt-5">Selamat Datang, {{ Auth::user()->name }}</h1>
        <p class="description">Apotek kami menyediakan berbagai macam obat dan layanan kesehatan untuk memenuhi kebutuhan Anda. Kami berkomitmen untuk memberikan pelayanan terbaik dengan produk berkualitas tinggi.</p>
        <p class="description">Jangan ragu untuk berkonsultasi dengan apoteker kami untuk mendapatkan informasi lebih lanjut tentang obat dan kesehatan Anda.</p>
    </div>

    <div class="kotak-container">
        <div class="kotak">
            <h3>Pendapat Adit</h3>
            <p>Pelayanan Yang Ramah.</p>
        </div>
        <div class="kotak">
            <h3>Pendapat Bayu</h3>
            <p>Harga Murah Dan Terjangkau.</p>
        </div>
        <div class="kotak">
            <h3>Pendapat Rizqi</h3>
            <p>Tersedia Macam-Macam Obat.</p>
        </div>
    </div>
@endsection

<style>
    .welcome-box {
        border: 2px solid #566779; /* Warna border */
        border-radius: 10px; /* Sudut melengkung */
        padding: 20px; /* Jarak dalam kotak */
        text-align: center; /* Rata tengah */
        background-color: #38c6e6; /* Warna latar belakang */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Bayangan */
        animation: fadeIn 1s ease-in-out; /* Animasi */
    }

    .kotak-container {
        display: flex; /* Menggunakan flexbox untuk tata letak */
        justify-content: space-around; /* Rata tengah horizontal */
        margin-top: 20px; /* Jarak atas dari welcome box */
    }

    .kotak {
        border: 1px solid #007bff; /* Warna border kotak */
        border-radius: 10px; /* Sudut melengkung */
        padding: 15px; /* Jarak dalam kotak */
        width: 30%; /* Lebar kotak */
        background-color: #f8f9fa; /* Warna latar belakang */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Bayangan */
        text-align: center; /* Rata tengah teks */
    }

    .description {
        margin-top: 15px; /* Jarak atas untuk deskripsi */
        font-size: 1.2em; /* Ukuran font */
        color: #333; /* Warna teks */
        opacity: 0; /* Transparansi awal */
        animation: slideIn 1s forwards; /* Animasi */
    }

    @keyframes fadeIn {
        from {
            opacity: 0; /* Transparansi awal */
            transform: translateY(-20px); /* Posisi awal */
        }
        to {
            opacity: 1; /* Transparansi akhir */
            transform: translateY(0); /* Posisi akhir */
        }
    }

    @keyframes slideIn {
        from {
            opacity: 0; /* Transparansi awal */
            transform: translateY(20px); /* Posisi awal */
        }
        to {
            opacity: 1; /* Transparansi akhir */
            transform: translateY(0); /* Posisi akhir */
        }
    }
</style>