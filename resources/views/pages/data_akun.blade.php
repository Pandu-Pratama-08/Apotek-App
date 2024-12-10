@extends('templates.app')

@section('content-dinamis')
    <div class="container mt-5">
        <div class="d-flex justify-content-end">
            <form class="d-flex me-3" action="{{ route('kelola_akun.kelola') }}" method="GET">
                <input type="text" name="cari" placeholder="Cari Nama Pengguna..." class="form-control me-2">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
            <a href="{{ route('kelola_akun.tambah') }}" class="btn btn-success">+ Tambah Pengguna</a>
        </div>
        @if (Session::get('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif


        <table class="table table-stripped table-bordered mt-3 text-center">
            <thead>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </thead>
            <tbody>

                <tr>
                    @php $no =1 @endphp
                    @if (count($user) < 0)
                <tr>
                    <td colspan="6">Data Pengguna Kosong</td>
                </tr>
            @else
                @foreach ($user as $index => $bagian)
                    <td>{{ ($user->currentPage() - 1) * $user->perpage() + ($index + 1) }}</td>
                    <td>{{ $bagian['name'] }}</td>
                    <td>{{ $bagian['email'] }}</td>
                    <td>{{ $bagian['role'] }}</td>
                    <td class="d-flex justify-content-center">
                        <a href="{{ route('kelola_akun.ubah', $bagian['id']) }}" class="btn btn-primary me-2">Edit</a>
                        <button class="btn btn-danger"
                            onclick="showModalDelete('{{ $bagian->id }}', '{{ $bagian->name }}')">Hapus</button>
                    </td>
                    </tr>
                @endforeach
                @endif
            </tbody>
        </table>
        <div class="d-flex justify-content-end my-3">
            {{ $user->links() }}
        </div>

    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="">
                {{-- action kosong, di isi melalui js karna id dikirim ke jsnya --}}
                @csrf
                {{-- menimpa method="POST" jadi delete sesuai web.php http method --}}
                @method('DELETE')
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">HAPUS DATA PENGGUNA</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- konten dinamis pada teks ini bagian nama obat, sehingga nama obatnya disediakan tempat penyimpanan (tag b) --}}
                    Apakah Anda Yakin Ingin Menghapus Data Pengguna <b id="nama_pengguna"></b>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>

    @push('script')
        {{-- cdn boo --}}
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script>
            function showModalDelete(id, name) {
                // memasukkan teks dari parameter ke html bagian id="nama_pengguna"
                $("#nama_pengguna").text(name);
                // memanggil route hapus
                let url = "{{ route('kelola_akun.hapus', ':id') }}";
                // isi path dinamis :id dari data parameter id
                url = url.replace(':id', id);
                // action="" di form di isi dengan url di atas
                $("form").attr("action", url);
                // memunculkan modal dengan id="exampleModal"
                $("#exampleModal").modal('show');
            }
        </script>
    @endpush

@endsection
