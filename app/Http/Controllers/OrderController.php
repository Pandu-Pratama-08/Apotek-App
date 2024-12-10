<?php

namespace App\Http\Controllers;

use App\Exports\OrderExport;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Medicine;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as Facadepdf;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('user')
            ->when(request('date'), function ($query) {
                $query->whereDate('created_at', request('date'));
            })
            ->simplePaginate(5);

        if (request()->has('date')) {
            $orders->appends(['date' => request('date')]);
        }

        return view('order.kasir.kasir', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $medicines = Medicine::all();
        return view('order.kasir.create', compact('medicines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name_customer" => 'required',
            "medicines" => 'required',
        ]);

        // mencari jumlah item yang sama pada array, strukturnya :
        // [ "item" => "jumlah" ]
        $arrayValues = array_count_values($request->medicines);

        // menyiapkan array kosong untuk menampung format array baru
        $arrayNewMedicines = [];

        // looping hasil penghitungan item distinct (duplikat)
        // key akan berupa value dr input medicines (id), item array berupa jumlah penghitungan item duplikat
        foreach ($arrayValues as $id => $value) {
            // mencari data obat berdasarkan id (obat yg dipilih)
            $medicine = Medicine::where('id', $id)->first();

            // ambil bagian column price dr hasil pencarian lalu kalikan dengan jumlah item duplikat sehingga akan menghasilkan total harga dr pembelian obat tersebut
            $totalprice = $medicine['price'] * $value;
            // pengecekan stok obat
            if ($medicine['stock'] < $value) {
                $valueFormBefore = [
                    'name_customer' => $request->name_customer,
                    'medicines' => $request->medicines
                ];
                $msg = 'Stok obat ' . $medicine['name'] . ' Tidak Cukup. Tersisa ' . $medicine['stock'];
                return redirect()->back()->with([
                    'failed' => $msg,
                    'valueFormBefore' => $valueFormBefore,
                ]);
            }


            // struktur value column medicines menjadi multidimensi dengan dimensi kedua berbentuk array assoc dengan key "id", "name_medicine", "qty", "price"
            $arrayItem = [
                "id" => $id,
                "name_medicine" => $medicine['name'],
                "qty" => $value,
                "price" => $medicine['price'],
                "total_prince" => $totalprice
            ];

            // masukkan struktur array tersebut ke array kosong yg disediakan sebelumnya
            array_push($arrayNewMedicines, $arrayItem);
        }

        // total harga pembelian dari obat-obat yg dipilih
        $total_prince = 0;
        // looping format array medicines baru
        foreach ($arrayNewMedicines as $item) {
            // total harga pembelian ditambahkan dr keseluruhan sub_price data medicines
            $total_prince += (int)$item['total_prince'];
        }

        // harga beli ditambah 10% ppn
        $ppn = $total_prince + ($total_prince * 0.1);

        // tambahkan result kedalam database order
        $newOrder = Order::create([
            // data user_id diambil dari id akun kasir yg sedang login
            'user_id' => Auth::user()->id,
            'medicines' => $arrayNewMedicines,
            'name_customer' => $request->name_customer,
            'total_prince' => $ppn
        ]);

        foreach ($arrayNewMedicines as $key => $value) {
            $stockBefore = Medicine::where('id', $value['id'])->value('stock');
            Medicine::where('id', $value['id'])->update([
                'stock' => $stockBefore - $value['qty']
            ]);
        }

        if ($newOrder) {
            // jika newOrder tambah data berhasil, ambil data order yg dibuat oleh kasir yg sedang login (where), dengan tanggal paling terbaru
            return redirect()->route('kasir.print', $newOrder['id'])->with('success', 'Berhasil Order');
        } else {
            // jika newOrder gagal, maka diarahkan kembali ke halaman form dengan pesan pemberitahuan
            return redirect()->back()->with('failed', 'Gagal Order');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $order = Order::find($id);
        return view('order.kasir.print', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function downloadPDF($id)
    {
        // Get the required data and ensure it's in array format
        $order = Order::find($id)->toArray();

        // Send initial variables from the data that will be used in the PDF layout
        view()->share('order', $order);

        // Call the blade that will be downloaded
        $pdf = FacadePdf::loadView('order.kasir.download', $order);

        // Return or generate the PDF in a specific file name
        return $pdf->download('struk-pembelian.pdf');
    }

    public function createExcel()
    {
        $exportExcel = 'exportExcel' . '.xlsx';
        return  Excel::download(new OrderExport, $exportExcel);
    }

    public function indexAdmin(Request $request)
    {
        //
        $orders = Order::with('user')
            ->when(request('date'), function ($query) {
                $query->whereDate('created_at', request('date'));
            })
            ->simplePaginate(5);
        return view('order.admin.data_pembelian', compact('orders'));
    }
}
