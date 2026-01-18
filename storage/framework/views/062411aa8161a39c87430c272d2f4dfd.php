<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Cafe Ealnya'); ?></title>
    
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <style>
        :root {
            --pink-1: #ffd6e8;
            --pink-2: #ffb1d8;
            --pink-3: #ff6fb1;
            --pink-4: #b4006a;
            --white: #ffffff;
            --text: #2b2b2b;
            --cb-bounce: cubic-bezier(0.34, 1.56, 0.64, 1);
            --cubic-bezier: cubic-bezier(0.22, 1, 0.36, 1);
        }

        * { 
            box-sizing: border-box; 
            -webkit-tap-highlight-color: transparent;
        }

        body {
            margin: 0;
            font-family: 'Quicksand', sans-serif;
            background-color: #fdf2f8;
            color: var(--text);
            padding: 80px 0 100px 0; 
            background-image: radial-gradient(var(--pink-1) 0.5px, transparent 0.5px);
            background-size: 20px 20px;
        }

        .top-bar {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 70px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(15px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 20px;
            z-index: 1000;
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
        }

        .top-bar .logo {
            font-size: 20px;
            font-weight: 900;
            color: var(--pink-4);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .bottom-nav {
            position: fixed;
            bottom: 25px;
            left: 50%;
            transform: translateX(-50%);
            width: 95%;
            max-width: 500px;
            height: 70px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(60px, 1fr));
            align-items: center;
            box-shadow: 0 15px 35px rgba(180, 0, 106, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.6);
            z-index: 1000;
        }

        .nav-item {
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #888;
            gap: 4px;
            transition: all 0.4s var(--cb-bounce);
            position: relative;
        }

        .nav-item span.material-symbols-rounded {
            font-size: 26px;
            transition: 0.4s var(--cb-bounce);
            font-variation-settings: 'FILL' 0, 'wght' 400;
        }

        .nav-item p {
            margin: 0;
            font-size: 10px;
            font-weight: 700;
        }

        .nav-item.active {
            color: var(--pink-4);
        }

        .nav-item.active span.material-symbols-rounded {
            transform: translateY(-5px);
            font-variation-settings: 'FILL' 1, 'wght' 400;
        }

        .nav-item:active {
            transform: scale(0.9);
        }

        .nav-item.active::after {
            content: '';
            position: absolute;
            bottom: -8px;
            width: 5px;
            height: 5px;
            background: var(--pink-4);
            border-radius: 50%;
        }

        .container {
            max-width: 100vw;
            min-height: 80vh ;
            margin: 0 auto;
            padding: 0 20px;
        }

        .fade-in-up {
            animation: fadeInUp 0.6s var(--cb-bounce) forwards;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -10px;
            background: #ff4757;
            color: white;
            font-size: 10px;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 20px;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
            animation: popIn 0.3s var(--cb-bounce);
        }

        @keyframes popIn {
            from { transform: scale(0); }
            to { transform: scale(1); }
        }

        .profile-modal {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.4);
            backdrop-filter: blur(10px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 3000;
        }

        .profile-card {
            background: white;
            width: 90%;
            max-width: 400px;
            border-radius: 30px;
            padding: 25px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            animation: modalPop 0.4s var(--cb-bounce);
        }

        @keyframes modalPop {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .avatar-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin: 20px 0;
        }

        .avatar-option {
            width: 100%;
            aspect-ratio: 1;
            border-radius: 50%;
            cursor: pointer;
            border: 3px solid transparent;
            transition: 0.3s;
            object-fit: cover;
        }

        .avatar-option.active { border-color: var(--pink-3); transform: scale(1.1); }
        
        .btn-logout {
            width: 100%;
            padding: 12px;
            border: 2px solid #ff4757;
            background: transparent;
            color: #ff4757;
            border-radius: 15px;
            font-family: 'Quicksand';
            font-weight: 800;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 15px;
        }
    </style>
</head>
<body>

    <header class="top-bar">
        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%; max-width: 450px;">
            <div class="logo">
                <span class="material-symbols-rounded">bakery_dining</span>
                Cafe Ealnya
            </div>
            
            <div id="profile-trigger" onclick="openProfilePicker()" style="display: flex; align-items: center; gap: 10px; background: white; padding: 5px 12px; border-radius: 50px; border: 1px solid var(--pink-1); cursor: pointer;">
                <div style="text-align: right;">
                    <p style="margin: 0; font-size: 10px; color: #999; font-weight: 700;">Halo,</p>
                    <p style="margin: 0; font-size: 12px; font-weight: 800; color: var(--pink-4);"><?php echo e(Auth::user()->name ?? 'Pelanggan'); ?></p>
                </div>
                <img id="current-avatar" src="<?php echo e(asset('img_profile/avatar_1.jpeg')); ?>" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 2px solid white; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">
            </div>
        </div>
    </header>

    <main class="container fade-in-up">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <div id="profileModal" class="profile-modal" onclick="closeProfilePicker()">
        <div class="profile-card" onclick="event.stopPropagation()">
            <h3 style="margin: 0; text-align: center; color: var(--pink-4); font-weight: 800;">Ganti Foto Profil</h3>
            <div class="avatar-grid">
                <?php for($i = 1; $i <= 10; $i++): ?>
                    <img src="<?php echo e(asset('img_profile/avatar_'.$i.'.jpeg')); ?>" 
                         class="avatar-option" 
                         data-filename="avatar_<?php echo e($i); ?>.jpeg"
                         onclick="selectAvatar('avatar_<?php echo e($i); ?>.jpeg', this)">
                <?php endfor; ?>
            </div>

            <button style="width:100%; padding:12px; border:none; background:var(--pink-4); color:white; border-radius:15px; font-weight:700; cursor:pointer;" onclick="closeProfilePicker()">Simpan</button>
            
            <?php if(auth()->guard()->check()): ?>
                <form action="<?php echo e(route('logout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn-logout">
                        <span class="material-symbols-rounded">logout</span> Keluar Akun
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <nav class="bottom-nav">
        <a href="<?php echo e(route('customer.pesanan.menu')); ?>" class="nav-item <?php echo e(request()->routeIs('customer.pesanan.menu') ? 'active' : ''); ?>">
            <span class="material-symbols-rounded">restaurant_menu</span>
            <p>Menu</p>
        </a>

        <a href="<?php echo e(route('customer.pesanan.index')); ?>" class="nav-item <?php echo e(request()->routeIs('customer.pesanan.index') ? 'active' : ''); ?>" id="cart-nav-item">
            <div style="position: relative;">
                <span class="material-symbols-rounded">shopping_bag</span>
                <?php
                    $keranjang = session('keranjang', []);
                    $totalItem = array_sum(array_column($keranjang, 'qty'));
                ?>
                <span id="cart-count" class="cart-badge" style="<?php echo e($totalItem > 0 ? '' : 'display: none;'); ?>"><?php echo e($totalItem); ?></span>
            </div>
            <p>Keranjang</p>
        </a>

        <?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(route('customer.mutasi.index')); ?>" class="nav-item <?php echo e(request()->routeIs('customer.mutasi.index') ? 'active' : ''); ?>">
                <span class="material-symbols-rounded">receipt_long</span>
                <p>Mutasi</p>
            </a>
            
            <?php if(auth()->user()->role === 'admin'): ?>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                <span class="material-symbols-rounded">dashboard_customize</span>
                <p>Admin</p>
            </a>
            <?php endif; ?>
        <?php endif; ?>

        <?php if(auth()->guard()->guest()): ?>
            <a href="<?php echo e(route('login')); ?>" class="nav-item <?php echo e(request()->routeIs('login') ? 'active' : ''); ?>">
                <span class="material-symbols-rounded">login</span>
                <p>Login</p>
            </a>
        <?php endif; ?>
    </nav>

    <script>
        const avatarImg = document.getElementById('current-avatar');
        const modal = document.getElementById('profileModal');

        document.addEventListener('DOMContentLoaded', () => {
            const savedAvatar = localStorage.getItem('user_avatar');
            if (savedAvatar) {
                avatarImg.src = `<?php echo e(asset('img_profile')); ?>/${savedAvatar}`;
            }
        });

        function openProfilePicker() {
            modal.style.display = 'flex';
            const currentFile = localStorage.getItem('user_avatar') || 'avatar_1.jpeg';
            document.querySelectorAll('.avatar-option').forEach(img => {
                img.classList.toggle('active', img.dataset.filename === currentFile);
            });
        }

        function closeProfilePicker() {
            modal.style.display = 'none';
        }

        function selectAvatar(filename, element) {
            avatarImg.src = `<?php echo e(asset('img_profile')); ?>/${filename}`;
            localStorage.setItem('user_avatar', filename);
            document.querySelectorAll('.avatar-option').forEach(img => img.classList.remove('active'));
            element.classList.add('active');
        }

        const navItems = document.querySelectorAll('.nav-item');
        navItems.forEach(item => {
            item.addEventListener('click', function() {
                navItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html><?php /**PATH /home/egdrga/Documents/laravel/ealnya/ealnya/resources/views/layouts/app.blade.php ENDPATH**/ ?>