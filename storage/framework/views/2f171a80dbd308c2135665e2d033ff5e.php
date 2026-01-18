<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - Cafe Ealnya</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <style>
        :root {
            --accent-pink: #ff6fb1;
            --deep-pink: #b4006a;
            --soft-pink: #ffd6e8;
            --text-main: #2d3436;
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
            max-width: 420px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            padding: 35px;
            box-shadow: 0 30px 60px rgba(180, 0, 106, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.5);
            animation: entrance 0.4s var(--cb-bounce) forwards;
        }

        .brand-section {
            text-align: center;
            margin-bottom: 25px;
        }

        .brand-name {
            font-size: 32px;
            font-weight: 900;
            background: linear-gradient(to right, var(--deep-pink), var(--accent-pink));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 0;
        }

        .subtitle {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }

        .input-grid {
            display: grid;
            gap: 15px;
        }

        .input-group {
            position: relative;
        }

        label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 700;
            color: var(--deep-pink);
            margin-bottom: 6px;
            margin-left: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input {
            width: 100%;
            padding: 12px 16px;
            border-radius: 12px;
            border: 2px solid transparent;
            background: #fdf2f7;
            font-size: 14px;
            transition: all 0.3s var(--cb-standard);
        }

        input:focus {
            outline: none;
            background: #fff;
            border-color: var(--accent-pink);
            box-shadow: 0 8px 15px rgba(255, 111, 177, 0.15);
            transform: translateY(-2px);
        }

        .btn-regis {
            width: 100%;
            background: linear-gradient(135deg, var(--accent-pink), var(--deep-pink));
            color: white;
            border: none;
            padding: 15px;
            border-radius: 15px;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.4s var(--cb-bounce);
            box-shadow: 0 10px 25px rgba(180, 0, 106, 0.2);
            margin-top: 10px;
        }

        .btn-regis:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(180, 0, 106, 0.3);
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
    </style>
</head>
<body>

<div class="overlay">
    <form class="card" method="POST" action="<?php echo e(route('register.post')); ?>">
        <?php echo csrf_field(); ?>

        <div class="brand-section">
            <h1 class="brand-name">Join Ealnya</h1>
            <p class="subtitle">Buat akun untuk mulai memesan</p>
        </div>

        <div class="input-grid">
            <div class="input-group">
                <label>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    Nama Lengkap
                </label>
                <input type="text" name="name" placeholder="Nama Anda" required>
            </div>

            <div class="input-group">
                <label>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    Email
                </label>
                <input type="email" name="email" placeholder="email@contoh.com" required>
            </div>

            <div class="input-group">
                <label>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    Password
                </label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <div class="input-group">
                <label>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    Konfirmasi Password
                </label>
                <input type="password" name="password_confirmation" placeholder="••••••••" required>
            </div>
        </div>

        <button class="btn-regis" type="submit">
            Buat Akun Baru
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </button>

        <div class="link">
            Sudah punya akun?
            <a href="<?php echo e(route('login')); ?>">Login di sini</a>
        </div>
    </form>
</div>

</body>
</html><?php /**PATH /home/egdrga/Documents/laravel/ealnya/ealnya/resources/views/auth/register.blade.php ENDPATH**/ ?>