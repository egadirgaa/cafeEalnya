<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Cafe Ealnya</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <style>
        :root {
            --accent-pink: #ff6fb1;
            --deep-pink: #b4006a;
            --soft-pink: #ffd6e8;
            --text-main: #2d3436;
            /* Cubic Bezier: Efek pegas yang playful */
            --cb-bounce: cubic-bezier(0.34, 1.56, 0.64, 1);
            --cb-standard: cubic-bezier(0.4, 0, 0.2, 1);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Outfit', 'Segoe UI', sans-serif;
            background: url('/storage/menu/login.jpg') center/cover no-repeat fixed;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .overlay {
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(255,214,232,0.8), rgba(255,111,177,0.4));
            backdrop-filter: blur(8px);
            padding: 20px;
        }

        /* Animasi masuk untuk kartu */
        @keyframes entrance {
            0% { opacity: 0; transform: scale(0.8) translateY(50px); }
            100% { opacity: 1; transform: scale(1) translateY(0); }
        }

        .card {
            width: 100%;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            padding: 40px;
            box-shadow: 0 30px 60px rgba(180, 0, 106, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.5);
            animation: entrance 0.8s var(--cb-bounce) forwards;
            position: relative;
            overflow: hidden;
        }

        /* Dekorasi Nama Cafe */
        .brand-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-name {
            font-size: 38px;
            font-weight: 900;
            background: linear-gradient(to right, var(--deep-pink), var(--accent-pink));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 0;
            letter-spacing: -1px;
        }

        .brand-tagline {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: var(--deep-pink);
            opacity: 0.7;
            margin-top: -5px;
            display: block;
            margin-top: 1rem
        }

        .input-group {
            margin-bottom: 20px;
            position: relative;
        }

        label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 8px;
            margin-left: 5px;
        }

        input {
            width: 100%;
            padding: 15px 18px;
            border-radius: 15px;
            border: 2px solid transparent;
            background: #fdf2f7;
            font-size: 15px;
            transition: all 0.3s var(--cb-standard);
        }

        input:focus {
            outline: none;
            background: #fff;
            border-color: var(--accent-pink);
            box-shadow: 0 8px 20px rgba(255, 111, 177, 0.2);
            transform: translateY(-2px);
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, var(--accent-pink), var(--deep-pink));
            color: white;
            border: none;
            padding: 16px;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.4s var(--cb-bounce);
            box-shadow: 0 10px 25px rgba(180, 0, 106, 0.3);
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(180, 0, 106, 0.4);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: #666;
        }

        .register-link a {
            color: var(--deep-pink);
            text-decoration: none;
            font-weight: 800;
            transition: 0.3s;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        /* Tombol Kembali yang lebih interaktif */
        .btn-back {
            margin-top: 30px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 28px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50px;
            text-decoration: none;
            color: var(--deep-pink);
            font-weight: 700;
            font-size: 14px;
            transition: all 0.4s var(--cb-bounce);
            animation: entrance 0.4s var(--cb-bounce) 0.2s backwards;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .btn-back:hover {
            background: white;
            transform: translateX(-10px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        /* Floating Coffee Bean Decoration (SVG) */
        .decoration {
            position: absolute;
            z-index: -1;
            opacity: 0.1;
            animation: float 2s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(20deg); }
        }
        .link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .link a {
            color: var(--deep-pink);
            text-decoration: none;
            font-weight: 800;
            position: relative;
        }

        .link a::after {
            content: '';
            position: absolute;
            width: 0; height: 2px;
            bottom: -2px; left: 0;
            background: var(--deep-pink);
            transition: width 0.3s var(--cb-standard);
        }

        .link a:hover::after { width: 100%; }
        .setup-app {
            position: fixed;
            bottom: 0;
            right: 0;
            padding: .5rem;
            background: #2d34365b;
            color: white;
            border-radius: 20px;
            opacity: 0.1;
            transition: .2s linear ease-in-out;
            text-decoration: none;
            text-transform: uppercase;
        }
        .setup-app:hover {
            opacity: 1;
        }
    </style>
</head>
<body>

<div class="overlay">
    
    <form class="card" method="POST" action="<?php echo e(route('login.post')); ?>">
        <?php echo csrf_field(); ?>

        <div class="brand-section">
            <h1 class="brand-name">Ealnya</h1>
            <span class="brand-tagline">Premium Coffee & Chill</span>
        </div>

        <?php if($errors->any()): ?>
            <div style="background: #fff0f0; border-left: 4px solid #ff4757; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; color: #ff4757;">
                <strong>Ups!</strong> <?php echo e($errors->first()); ?>

            </div>
        <?php endif; ?>

        <div class="input-group">
            <label>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                Email
            </label>
            <input type="email" name="email" placeholder="Masukkan email anda" required>
        </div>

        <div class="input-group">
            <label>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                Password
            </label>
            <input type="password" name="password" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn-login">
            Masuk ke Cafe
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </button>

        <div class="link">
            Belum punya akun? <a href="<?php echo e(route('register')); ?>">Daftar sekarang</a>
        </div>
    </form>

    <a href="<?php echo e(route('customer.pesanan.menu')); ?>" class="btn-back">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Kembali ke Menu Cafe
    </a>

</div>

<a class="setup-app" href="/setup-app"
   onclick="return confirm('Reset database dan seed ulang?')">
   Setup Aplikasi
</a>
</body>
</html><?php /**PATH /home/egdrga/Documents/laravel/ealnya/ealnya/resources/views/auth/login.blade.php ENDPATH**/ ?>