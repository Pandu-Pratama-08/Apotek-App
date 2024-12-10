@extends('templates.app')


@section('content-dinamis')
{{-- <div class="container">
    <h1>Create</h1>
</div> --}}

<form action="{{ route('data_obat.tambah.proses')}}" class="card p-5" method="POST">
    @csrf
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (Session::get('success'))
        <div class="alert alert-success">
        {{ Session::get('success') }}
        </div>
    @endif
    <div class="mb-3 row">
        <label for="name" class="col-sm-2 col-form-label">Nama Obat: </label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name')}}">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="type" class="col-sm-2 col-form-label">Jenis Obat: </label>
        <div class="col-sm-10">
            <select class="form-select" name="type" id="type">
                <option selected disabled hidden>Pilih</option>
                <option value="tablet" {{ old('type') == "tablet" ? 'selected' : ''}}>Tablet</option>
                <option value="kapsul" {{ old('type') == "kapsul" ? 'selected' : ''}}>Kapsul</option>
                <option value="sirup" {{ old('type') == "sirup" ? 'selected' : ''}}>Sirup</option>
            </select>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="price" class="col-sm-2 col-form-label">Harga: </label>
        <div class="col-sm-10">
            <input type="number" class="form-control" id="price" name="price" value="{{ old('price')}}">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="stock" class="col-sm-2 col-form-label">Stock: </label>
        <div class="col-sm-10">
            <input type="number" class="form-control" id="stock" name="stock"  value="{{ old('stock')}}">
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Kirim</button>
</form>
@endsection
