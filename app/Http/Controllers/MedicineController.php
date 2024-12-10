<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Request $request -> mengambil data dari form nya (di php sebelumnya : $_POST/$_GET)
    public function index(Request $request)
    {
        //menampilkan data dari model yg menyimpan data obat
        // all() -> mengambil semua data dari table medicines model Medicine
        // orderBy('nama_kolom', 'asc/desc') -> mengurutkan data berdasarkan kolom tertentu
        // asc (ascending) -> urutkan data dari kecil ke besar (a-z/0-9)
        // desc (descending) ->  urutkan data dari besar ke kecil (z-a/9-0)
        // all() -> tanpa proses filter apapun
        // filter -> mengambil get()/paginate()/simpalePaginate()
        // simplePaginate(angka) -> mengambil data dengan pagination per halamannya jumlah data disimpan di kurung (5)
        // where('nama_kolom', 'operator', 'nilai') -> mencari data berdasarkan kolom tertentu dan isi tertentu (isinya yg dr input)
        // operator where : =, <, >, <=, >=, <>, LIKE
        // mengambil isi input : $request->name_input

        $orderBy = $request->sort_stock ? 'stock' : 'name';
        // appends : menambahkan/membawa request pagination (data-data pagination tidak berubah meskipun ada request)
        $medicines = Medicine::where('name', 'LIKE', '%'.$request->cari.'%')->orderBy($orderBy, 'ASC')->simplePaginate(5)->appends($request->all());
        // compact() -> mengirimkan data ($) agar data $nya bisa dipake di blade
        return view('pages.data_obat', compact('medicines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('medicine.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|max:100',
            'type' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric'
        ], [
            'name.required' => 'Nama Obat Wajib Diisi',
            'name.max' => 'Nama Obat Harus Di isi Maksimal 100 Karakter!',
            'type.required' => 'Tipe Obat Harus Diisi',
            'price.required' => 'Harga Obat Harus Diisi',
            'price.numeric' => 'Harga Obat Harus Diisi Dengan Angka!',
            'stock.required' => 'Stok Obat Harus Diisi',
            'stock.numeric' => 'Stok Obat Harus Diisi  Dengan Angka!'
           ]);

        Medicine::create($request->all());


        return redirect()->back()->with('success', 'Berhasil Menambah Data Obat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Medicine $medicine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $medicine = Medicine::find($id);
        return view('medicine.edit', compact('medicine'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100',
            'type' => 'required',
            'price' => 'required|numeric'
        ]);

        Medicine::where('id', $id)->update([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price
        ]);

        return redirect()->route('data_obat.data')->with('success', 'Berhasil Menambah Data Obat!');
    }

    public function updateStock(Request $request, $id)
    {
        // karna nanti submit form stock tidak menggunakan ajax, jadi untuk mendeteksi old
        // (riwayat isi) ketika input dikosongkan, pengecekan required menggunakan isset
        if (isset($request->stock) == FALSE) {
            $medicineBefore = Medicine::find($id);
            return redirect()->back()->with([
                'failed' => 'Stok tidak boleh kosong!',
                'id' => $id,
                'stock' => $medicineBefore['stock']
            ]);
        }
        // jika tidak kosong, proses update
        Medicine::where('id', $id)->update(['stock' => $request->stock]);
        return redirect()->back()->with('success', 'Berhasil Mengubah data obat!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //cari (where), lalu hapus (delete)
        Medicine::where('id',$id)->delete();

        return redirect()->back()->with('success', 'Berhasil Menghapus Data Obat');
    }
}
