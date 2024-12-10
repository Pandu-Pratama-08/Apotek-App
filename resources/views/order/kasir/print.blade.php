<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bukti Pembelian</title>
    <style>
        #back-wrap {
            margin: 30px auto 0 auto;
            width: 500px;
            display: flex;
            justify-content: flex-end;
        }

        .btn-back {
            width: fit-content;
            padding: 8px 15px;
            color: #fff;
            background: #666;
            border-radius: 5px;
            text-decoration: none;
        }

        #receipt {
            box-shadow: 5px 10px 15px   rgba(4, 18, 213, 0.5);
            padding: 20px;
            margin: 30px auto 0 auto;
            width: 500px;
            background: #FFF;
        }

        h2 {
            font-size: .9rem;

        }

        p {
        font-size: .8rem;
        color: #666;
        line-height: 1.2rem;
        }

        #top {
        margin-top: 25px;
        }

        #top.info {
        text-align: left;
        margin: 20px 0;
        }

        table {
        width: 100%;
        border-collapse: collapse;
        }

        td {
        padding: 5px 0 5px 15px;
        border: 1px solid #EEE;
        }

        .tabletitle {
        font-size: .5rem;
        background: #e58004;
        }

        .service {
        border-bottom: 1px solid #EEE;
        }

        .itemtext {
        font-size: .7rem;
        }

        #legalCopy {
        margin-top: 15px;
        }

        .btn-print {
        float: right;
        color: #333;
        }
    </style>
</head>

<body>
    <div id="back-wrap">
        <a href="{{ route('kasir.order') }}" class="btn-back">Kembali</a>
    </div>
    <div id="receipt">
        <a href="{{ route('kasir.download', $order->id) }}" class="btn-print">Cetak (.pdf)</a>
        <center id="top">
            <div class="info">
                <h2>Apotek Pandu Nih</h2>
            </div>
        </center>
        <div id="mid">
            <div class="info">
                <p>
                    Alamat: sepanjang jalan kenangan<br>
                    Email: apotekpandunih@gmail.com<br>
                    Phone: 000-111-2222<br>
                </p>
            </div>
        </div>
        <div id="bot">
            <div id="table">
                <table>
                    <tr class="tabletitle">
                        <td>Obat</td>
                        <td>Total</td>
                        <td>Harga</td>
                    </tr>
                    @foreach ($order['medicines'] as $medicine)
                        <tr class="service">
                            <td class="tableitem">
                                <p class="itemtext">{{ $medicine['name_medicine'] }}</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext">{{ $medicine['qty'] }}</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext">Rp. {{ number_format($medicine['price'], 0, ',', '.') }}</p>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="tabletitle">
                        <td></td>
                        <td>PPN (10%)</td>
                        @php
                            $ppn = $order['total_prince'] * 0.1;
                        @endphp
                        <td>Rp. {{ number_format($ppn, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="tabletitle">
                        <td></td>
                        <td>Total Harga</td>
                        <td>Rp. {{ number_format($order['total_prince'], 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
            <div id="legalcopy">
                <p class="legal"><strong>Terima kasih atas pembelian Anda!</strong> Kami menghargai kepercayaan Anda kepada kami.</p>
            </div>
        </div>
    </div>
</body>

</html>
