<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KelolaAkunController extends Controller
{
    // pake request karena diambil dari form
    public function loginproses(Request $request)
    {
        $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);
        // ambil data dari input satukan pada array
        $user = $request->only(['email', 'password']);
        //cek kecocokan email password (pw terenkripsi), lalu simpan pada class auth
        if(Auth::attempt($user)) {
            return redirect()->route('landing_page');
        } else {
            return redirect()->back()->with('failed', 'Gagal Login! silahkan coba lagi');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('logout', 'Anda Telah Logout');
    }
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request)
    {
        $user = User::where('name', 'LIKE', '%'.$request->cari . '%')->simplePaginate(5)->appends($request->all());
        return view('pages.data_akun', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('kelola.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Melakukan validasi input dari form pendaftaran akun.
        $request->validate([
            'name' => 'required|max:100',  // Nama wajib diisi dan maksimal 100 karakter
            'email' => 'required',         // Email wajib diisi
            'role' => 'required',          // Role (peran pengguna) wajib diisi 
            'password' => 'required',      
        ], [
            // Pesan error yang akan ditampilkan jika validasi gagal
            'name.required' => 'Nama Harus Diisi',
            'name.max' => 'Nama Harus Diisi Maksimal 100 Karakter!',
            'email.required' => 'Email Harus Diisi',
            'role.required' => 'Role Harus Diisi',
            'password' => bcrypt($request->password)
        ]);
        // Setelah validasi berhasil, data akan disimpan ke tabel "users"
        // User::create() akan otomatis mengambil semua data yang diinputkan dari form melalui $request->all()
        User::create($request->all());

        // Setelah data berhasil disimpan, pengguna akan diarahkan kembali ke halaman pengelolaan akun
        // dengan pesan sukses yang akan disimpan di session
        return redirect()->route('kelola_akun.kelola')->with('success', 'Berhasil Menambah Data Akun!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $user = User::find($id);
        return view('kelola.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        //
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required',
            'role' => 'required',
            'password' => 'nullable',
        ]);

        User::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $user->password ?? $request->password
        ]);

        return redirect()->route('kelola_akun.kelola')->with('success', 'Berhasil Mengubah Data Pengguna!');
    } 

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        User::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Berhasil Menghapus Data Pengguna');
    }
}
