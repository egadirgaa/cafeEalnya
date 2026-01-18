<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Checkout</title>
    <style>
        :root{--pink-3:#ff6fb1;--pink-4:#b4006a;}
        body{
            margin:0;font-family:Arial,sans-serif;
            background:linear-gradient(rgba(255,214,232,.84), rgba(255,214,232,.84)),
                       url('/storage/menu/login.jpg');
            background-size:cover;background-position:center;background-repeat:no-repeat;
            min-height:100vh;padding:26px 16px;
        }
        .wrap{max-width:900px;margin:0 auto;}
        .card{background:rgba(255,255,255,.93);border-radius:16px;padding:16px;box-shadow:0 18px 45px rgba(0,0,0,.18);}
         h1{margin:0 0 12px;color:var(--pink-4);}
        .btn{border:none;cursor:pointer;padding:10px 14px;border-radius:12px;font-weight:900;text-decoration:none;display:inline-block;}
        .btn-primary{background:linear-gradient(135deg,var(--pink-3),var(--pink-4));color:#fff;}
        .btn-dark{background:#333;color:#fff;}
        .row{display:flex;justify-content:space-between;align-items:center;gap:10px;margin-top:14px;}
        .total{font-weight:900;color:var(--pink-4);font-size:18px;}
    </style>
</head>
<body>
<div class="wrap">
    <div class="card">
        <h1>Checkout</h1>
        <p>Total akhir: <span class="total">Rp {{ number_format($total,0,',','.') }}</span></p>

        <form method="POST" action="{{ route('customer.pesanan.prosesCheckout') }}">
            @csrf
            <button class="btn btn-primary" type="submit">Proses Checkout</button>
            <a class="btn btn-dark" href="{{ route('customer.pesanan.menu') }}">Kembali</a>
        </form>
    </div>
</div>
</body>
</html>