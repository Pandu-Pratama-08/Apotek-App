@extends('templates.app')
@section('content-dinamis')
    <form action="{{ route('login.proses') }}" method="POST" class="card d-flex mx-auto my-3 p-5 w-75">
      {{--  --}}
        @csrf
        @if (Session::get('failed'))
            <div class="alert alert-danger">{{ Session::get('failed') }}</div>
        @endif
        @if (Session::get('logout'))
            <div class="alert alert-primary">{{ Session::get('logout') }}</div>
        @endif
        <h1 class="text-center">Login</h1>
        <div class="form-group">
            <label for="email" class="form-label">Email :</label>
            <input type="email" name="email" id="email" class="form-control">
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="password" class="form-label">Password :</label>
            <input type="password" name="password" id="password" class="form-control">
            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <br>
        <button type="submit" class="btn btn-primary"> LOGIN </button>
    </form>
@endsection