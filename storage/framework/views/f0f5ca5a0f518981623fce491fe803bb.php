<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Setup Berhasil</title>

    <style>
        body {
            font-family: system-ui, sans-serif;
            background: #fdf2f7;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .box {
            background: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0,0,0,.1);
            max-width: 420px;
        }
        h1 { color: #b4006a; }
        p, li {
            font-size: 14px;
            color: #444;
            line-height: 1.6;
        }
        ul {
            text-align: left;
            margin: 20px 0;
            padding-left: 18px;
        }
        .countdown {
            margin-top: 15px;
            font-size: 14px;
            color: #777;
        }
        .countdown span {
            font-weight: 800;
            color: #b4006a;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background: #ff6fb1;
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
        }
        a:hover { background: #b4006a; }
    </style>
</head>
<body>

<div class="box">
    <h1>✅ Setup Berhasil</h1>

    <p>Aplikasi sudah siap digunakan. Sistem telah:</p>
    <ul>
        <li>Mengatur ulang database</li>
        <li>Menambahkan data awal</li>
        <li>Mengaktifkan penyimpanan file</li>
    </ul>

    <div class="countdown">
        Anda akan diarahkan ke halaman menu dalam
        <span id="timer">8</span> detik...
    </div>

    <a href="<?php echo e(route('customer.pesanan.menu')); ?>">
        Masuk ke Menu Sekarang
    </a>
</div>

<script>
    let seconds = 8;
    const timerEl = document.getElementById('timer');

    const countdown = setInterval(() => {
        seconds--;
        timerEl.textContent = seconds;

        if (seconds <= 0) {
            clearInterval(countdown);
            window.location.href = "<?php echo e(route('customer.pesanan.menu')); ?>";
        }
    }, 1000);
</script>

</body>
</html>
<?php /**PATH /home/egdrga/Documents/laravel/ealnya/ealnya/resources/views/setup/success.blade.php ENDPATH**/ ?>