<?php

namespace App\Exports;

use Maatwebsite\Excel\Excel;
use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Order::orderBy('name_customer', 'ASC')->with('user')->get();
    }

    public function headings(): array
    {
        return [
            'ID Pembelian',
            'Nama Kasir',
            'Daftar Obat',
            'Total Harga',
            'Nama Pembeli',
            'Tanggal Pembelian',
        ];
    }

    public function map($order): array
    {
        $dataObat = '';
        foreach ($order->medicines as $key => $value) {
            $format = $key + 1 . "." . $value['name_medicine'] . " (" . $value['qty'] . "pcs) - Rp. " . number_format($value['price'], 0, ',', '.') . ",";
            $dataObat .= $format;
        }

        return [
            $order->id,
            $order->user->name,
            $dataObat,
            "Rp. " . number_format($order->total_prince, 0, ',', '.'),
            $order->name_customer,
            \Carbon\Carbon::create($order->created_at)->locale('id')->translatedFormat('d F, Y H:i:s'),
        ];
    }
}
