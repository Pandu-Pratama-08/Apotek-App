@extends('templates.app') 
{{-- Meng-extend layout utama yang ada di file "app.blade.php", 
    memungkinkan penggunaan bagian-bagian umum dari template tersebut (seperti header, footer, dll.) --}}

@section('content-dinamis') 
{{-- Membuka section bernama "content-dinamis", dimana konten spesifik halaman ini akan ditempatkan. --}}

<form action="{{ route('kelola_akun.tambah.proses')}}" class="card p-5" method="POST">
    {{-- Membuka form HTML dengan method POST, yang akan dikirimkan ke route bernama "kelola_akun.tambah.proses".
    Form ini dibungkus dalam sebuah elemen dengan class "card" dan diberi padding sebesar 5 untuk styling. --}}
    
    @csrf
    {{-- Menyertakan token CSRF (Cross-Site Request Forgery). Ini adalah mekanisme keamanan untuk mencegah serangan CSRF.
    Laravel mewajibkan penyertaan token CSRF di setiap form dengan method POST untuk validasi server. --}}

    @if($errors->any()) 
        {{-- Mengecek apakah ada error validasi dari server (misalnya input yang tidak valid atau data yang tidak sesuai aturan).
        Jika ada error, maka blok ini akan dijalankan dan menampilkan pesan error. --}}
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error) 
                    {{-- Melakukan looping untuk menampilkan setiap error yang ditemukan pada input. 
                    Error ditampilkan dalam bentuk list (<li>) --}}
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{-- Menutup bagian pengecekan error. Jika tidak ada error, bagian ini akan dilewati. --}}

    @if (Session::get('success'))
        {{-- Mengecek apakah ada pesan sukses yang disimpan dalam session setelah proses berhasil (misalnya setelah berhasil menambah akun).
        Jika ada, maka akan ditampilkan dalam alert success. --}}
        <div class="alert alert-success">
        {{ Session::get('success') }}
        {{-- Menampilkan pesan sukses dari session --}}
        </div>
    @endif
    {{-- Menutup bagian pengecekan session untuk pesan sukses --}}

    <div class="mb-3 row">
        <label for="name" class="col-sm-2 col-form-label">Nama :</label>
        {{-- Label untuk input nama. Diberi atribut for="name" agar label terhubung dengan input yang memiliki id="name" --}}
        <div class="col-sm-10">
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
            {{-- Input field untuk nama. Class "form-control" adalah bagian dari Bootstrap untuk styling input field.
            id dan name = "name" digunakan agar form bisa mengirim data "name". 
             Fungsi "old('name')" memastikan jika terjadi error, input yang sudah diisi sebelumnya tidak hilang. --}}
        </div>
    </div>
    {{-- Menutup div untuk input nama --}}

    <div class="mb-3 row">
        <label for="email" class="col-sm-2 col-form-label">Email :</label>
        {{-- Label untuk input email --}}
        <div class="col-sm-10">
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
            {{-- Input field untuk email. Menggunakan type="email" agar validasi email secara otomatis dilakukan oleh browser.
            Fungsi "old('email')" mengisi ulang input yang sebelumnya dimasukkan jika terjadi error. --}}
        </div>
    </div>
    {{-- Menutup div untuk input email --}}

    <div class="mb-3 row">
        <label for="type" class="col-sm-2 col-form-label">Tipe Pengguna</label>
        {{-- Label untuk input pilihan tipe pengguna --}}
        <div class="col-sm-10">
            <select class="form-select" name="role" id="role">
                {{-- Dropdown select untuk memilih role pengguna, dengan class "form-select" dari Bootstrap --}}
                <option selected disabled hidden>Pilih</option>
                {{-- Opsi pertama adalah placeholder yang tidak bisa dipilih (hidden, disabled) --}}
                <option value="admin" {{ old('role') == "admin" ? 'selected' : '' }}>Admin</option>
                {{-- Opsi "Admin". Jika "role" yang sebelumnya dipilih adalah "admin", opsi ini akan terpilih secara otomatis --}}
                <option value="kasir" {{ old('role') == "kasir" ? 'selected' : '' }}>Kasir</option>
                {{-- Opsi "Kasir". Jika "role" yang sebelumnya dipilih adalah "kasir", opsi ini akan terpilih secara otomatis --}}
            </select>
        </div>
    </div>
    {{-- Menutup div untuk select role --}}

    <div class="mb-3 row">
        <label for="password" class="col-sm-2 col-form-label">Password</label>
        {{-- Label untuk input password --}}
        <div class="col-sm-10">
            <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}">
            {{-- Input field untuk password dengan type="password" agar karakter yang dimasukkan disembunyikan.
            Fungsi "old('password')" tidak menampilkan kembali nilai karena alasan keamanan, tetapi tetap disertakan untuk konsistensi. --}}
        </div>
    </div>
    {{-- Menutup div untuk input password --}}

    <button type="submit" class="btn btn-primary mt-3">Kirim</button>
    {{-- Tombol submit untuk mengirim form. Tombol ini memiliki class "btn btn-primary" dari Bootstrap untuk memberikan styling sebagai tombol utama --}}
</form>
{{-- Menutup form --}}

@endsection
{{-- Menutup section "content-dinamis" --}}
