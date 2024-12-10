@extends('templates.app')

@section('content-dinamis')
    <div class="container mt-4">
        @if (Auth::user()->role == 'kasir')
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('kasir.create') }}" class="btn btn-primary">+ Tambah Order</a>
            </div>
        @else 
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('pembelian.export.excel') }}" class="btn btn-dark">Export Excel</a>
            </div>
        @endif
        
        <h1>DATA PEMBELIAN : {{ Auth::user()->name }}</h1>
        
        <div class="mt-4">
            <form action="{{ route('kasir.order') }}" method="GET" class="d-flex justify-content-end align-items-center gap-2 mb-3 search-form">
                <input type="date" name="date" class="form-control date-input" placeholder="Cari berdasarkan tanggal">
                <button type="submit" class="w-25 btn btn-primary">Cari Data Obat</button>
                <a href="?" class="btn btn-warning">Clear</a>
            </form>
        </div>
        
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Obat</th>
                    <th>Pembeli</th>
                    <th>Kasir</th>
                    <th>Total Harga</th>
                    <th>Tanggal Pembelian</th>
                    @if (Auth::user()->role == 'kasir')
                        <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $index => $order)
                    <tr>
                        <td>{{ ($orders->currentPage() - 1) * $orders->perPage() + ($index + 1) }}</td>
                        <td>
                            <ol>
                                @foreach ($order['medicines'] as $medicine) 
                                    <li>{{ $medicine['name_medicine'] }} ({{ $medicine['qty']}}): Rp. {{ number_format($medicine['price'], 0, ',', '.') }}</li>
                                @endforeach
                            </ol>
                        </td>
                        <td>{{ $order->name_customer }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>Rp. {{ number_format($order->total_prince, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::create($order->created_at)->locale('id')->translatedFormat('d F Y H:i:s') }}</td>
                        @if (Auth::user()->role == 'kasir')
                            <td>
                                <a href="{{ route('kasir.download', $order->id) }}" class="btn btn-danger">Cetak Struk</a>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="d-flex justify-content-end">
            {{ $orders->links() }}
        </div>
    </div>
@endsection