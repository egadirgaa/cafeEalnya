<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Cafe Ealnya</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #ffab91;
            --secondary: #d81b60;
            --bg-body: #fff9f0;
            --text-main: #5d4037;
            --cb-bounce: cubic-bezier(0.34, 1.56, 0.64, 1);
            --sidebar-width: 260px;
        }

        html { scroll-behavior: smooth; }
        
        ::selection { background: var(--primary); color: white; }

        body {
            font-family: 'Quicksand', sans-serif;
            background: var(--bg-body);
            color: var(--text-main);
            margin: 0;
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
            transition: all 0.4s var(--cb-bounce);
        }

        #loader {
            position: fixed;
            inset: 0;
            background: var(--bg-body);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease;
        }
        .coffee-cup { font-size: 3rem; animation: drink 1.5s infinite; }
        @keyframes drink {
            0%, 100% { transform: rotate(0); }
            50% { transform: rotate(15deg) scale(1.1); }
        }

        .sidebar {
            width: var(--sidebar-width);
            background: white;
            height: 100vh;
            position: fixed;
            box-shadow: 10px 0 40px rgba(141, 110, 99, 0.08);
            padding: 30px 20px;
            box-sizing: border-box;
            z-index: 100;
            border-right: 2px dashed #fce4ec;
            transition: transform 0.4s var(--cb-bounce);
            left: 0;
            display: flex;
            flex-direction: column;
        }

        body.sidebar-collapsed .sidebar {
            transform: translateX(-100%);
        }

        .sidebar h1 {
            font-size: 1.6rem;
            text-align: center;
            color: var(--secondary);
            margin-bottom: 50px;
            letter-spacing: -1px;
        }
        .nav-menu {
            flex-grow: 1;
        }
        .nav-link {
            text-decoration: none;
            color: var(--text-main);
            display: flex;
            align-items: center;
            padding: 14px 18px;
            border-radius: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            transition: all 0.4s var(--cb-bounce);
            cursor: pointer;
        }
        .nav-link:hover, .nav-link.active {
            background: var(--primary);
            color: white;
            transform: translateX(10px) scale(1.02);
            box-shadow: 0 10px 20px rgba(255, 171, 145, 0.3);
        }
        .nav-link svg {
            width: 20px; height: 20px; margin-right: 12px;
            fill: none; stroke: var(--text-main); 
            stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
            transition: all 0.4s var(--cb-bounce);
        }
        .nav-link:hover svg, .nav-link.active svg {
            stroke: white; transform: rotate(-10deg);
        }

        .hamburger-btn {
            position: fixed;
            top: 25px;
            right: 20px;
            z-index: 1001;
            background: white;
            border: 2px solid var(--primary);
            color: var(--secondary);
            width: 45px;
            height: 45px;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(141, 110, 99, 0.1);
            transition: all 0.3s var(--cb-bounce);
        }
        .hamburger-btn:hover { transform: scale(1.1); background: var(--bg-body); }
        
        body.sidebar-collapsed .hamburger-btn {
            right: 20px;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 40px;
            padding-top: 80px; 
            width: calc(100% - var(--sidebar-width));
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.4s var(--cb-bounce);
            box-sizing: border-box;
        }
        .main-content.loaded { opacity: 1; transform: translateY(0); }

        body.sidebar-collapsed .main-content {
            margin-left: 0;
            width: 100%;
        }

        /* --- SUBMENU --- */
        .submenu {
            max-height: 0; overflow: hidden;
            transition: all 0.5s var(--cb-bounce);
            padding-left: 30px; display: flex; flex-direction: column; gap: 5px;
        }
        .nav-item-dropdown.active .submenu { max-height: 200px; margin-bottom: 10px; }
        .nav-item-dropdown .chevron { transition: transform 0.4s var(--cb-bounce); }
        .nav-item-dropdown.active .chevron { transform: rotate(180deg); }

        .sub-link {
            text-decoration: none; color: var(--text-main); font-size: 0.85rem;
            padding: 10px 15px; border-radius: 12px; transition: all 0.3s; opacity: 0.7;
        }
        .sub-link:hover, .sub-link.current {
            background: #fff3f0; color: var(--secondary); opacity: 1; transform: translateX(5px);
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; width: 100%; }
            body.sidebar-open .sidebar { transform: translateX(0); }
        }
        .nav-link.logout-trigger:hover {
            background: #e2586d;
            color: #fff;
            box-shadow: 0 10px 20px rgba(229, 57, 53, 0.15);
        }

        .nav-link.logout-trigger:hover svg {
            stroke: #fff;
            transform: translateX(5px);
        }
    </style>
</head>
<body>

    <button class="hamburger-btn" id="sidebarToggle" title="Toggle Sidebar">
        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <line x1="3" y1="12" x2="21" y2="12"></line>
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
    </button>

    <div id="loader">
        <div class="coffee-cup">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><defs><mask id="SVGbM9xrexz">
                <path fill="#fff" d="M5 6c0 -2 2 0 6.5 0c4.5 0 7.5 -2 7.5 0l0 1c0 1.5 -2 2 -6.5 2c-4.5 0 -7.5 0 -7.5 -2l0 -1Z"/><path d="M4 4h16v5h-16Z"><animate fill="freeze" attributeName="d" begin="0.14s" dur="0.14s" to="M4 4h0v5h0Z"/></path></mask><mask id="SVG7b0ZLcJT"><path fill="#fff" fill-opacity="0.3" d="M10.13 18.15c-0.09 -0.86 -0.72 -6.17 -0.72 -6.17c0 0 1.94 0.33 3.1 -0.25c1.16 -0.57 2.48 -0.73 2.48 -0.73c0 0 -0.58 6.96 -0.63 7.46c-0.05 0.5 -0.9 0.84 -1.4 0.84l-1.72 0c-0.5 0 -1.02 -0.3 -1.11 -1.15Z"/><path d="M8 10h8v10h-8Z"><animate fill="freeze" attributeName="d" begin="0.35s" dur="0.14s" to="M8 10h8v0h-8Z"/></path></mask></defs><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path stroke-dasharray="32" d="M7.5 10.5c0 0 0.83 6.93 1 8.5c0.17 1.57 1.5 2 2.5 2l2 0c1.5 0 2.88 -1.14 3 -2c0.13 -0.86 1 -12 1 -12"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.14s" values="32;0"/></path><path stroke-dasharray="14" stroke-dashoffset="14" d="M8 4c1.1 -0.57 2 -1 4 -1c2 0 4.5 0.5 4.5 3"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.28s" dur="0.07s" to="0"/></path></g><g fill="currentColor"><path d="M0 0h24v24H0z" mask="url(#SVGbM9xrexz)"/><path d="M0 0h24v24H0z" mask="url(#SVG7b0ZLcJT)"/></g>
            </svg>
        </div>
    </div>

    <aside class="sidebar">
        <h1>Ealnya Admin 
            <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><defs><mask id="SVG5AkzhcyZ"><path fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 -8c0 2 -2 2 -2 4s2 2 2 4s-2 2 -2 4s2 2 2 4M12 -8c0 2 -2 2 -2 4s2 2 2 4s-2 2 -2 4s2 2 2 4M16 -8c0 2 -2 2 -2 4s2 2 2 4s-2 2 -2 4s2 2 2 4"><animate attributeName="d" dur="3.45s" repeatCount="indefinite" values="M8 0c0 2 -2 2 -2 4s2 2 2 4s-2 2 -2 4s2 2 2 4M12 0c0 2 -2 2 -2 4s2 2 2 4s-2 2 -2 4s2 2 2 4M16 0c0 2 -2 2 -2 4s2 2 2 4s-2 2 -2 4s2 2 2 4;M8 -8c0 2 -2 2 -2 4s2 2 2 4s-2 2 -2 4s2 2 2 4M12 -8c0 2 -2 2 -2 4s2 2 2 4s-2 2 -2 4s2 2 2 4M16 -8c0 2 -2 2 -2 4s2 2 2 4s-2 2 -2 4s2 2 2 4"/></path><path d="M4 7h16v0h-16v12h16v-32h-16Z"><animate fill="freeze" attributeName="d" begin="1.15s" dur="0.69s" to="M4 2h16v5h-16v12h16v-24h-16Z"/></path></mask></defs><path fill="currentColor" fill-opacity="0" d="M17 14v4c0 1.66 -1.34 3 -3 3h-6c-1.66 0 -3 -1.34 -3 -3v-4Z"><animate fill="freeze" attributeName="fill-opacity" begin="1.84s" dur="0.172s" to="0.3"/></path><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path stroke-dasharray="48" d="M17 9v9c0 1.66 -1.34 3 -3 3h-6c-1.66 0 -3 -1.34 -3 -3v-9Z"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.69s" values="48;0"/></path><path stroke-dasharray="16" stroke-dashoffset="16" d="M17 9h3c0.55 0 1 0.45 1 1v3c0 0.55 -0.45 1 -1 1h-3"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.69s" dur="0.345s" to="0"/></path></g><path fill="currentColor" d="M0 0h24v24H0z" mask="url(#SVG5AkzhcyZ)"/></svg>
                <path fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 -8c0 2 -2 2 -2 4s2 2 2 4s-2 2 -2 4s2 2 2 4M12 -8c0 2 -2 2 -2 4s2 2 2 4s-2 2 -2 4s2 2 2 4M16 -8c0 2 -2 2 -2 4s2 2 2 4s-2 2 -2 4s2 2 2 4"><animate attributeName="d" dur="3.45s" repeatCount="indefinite" values="M8 0c0 2 -2 2 -2 4s2 2 2 4s-2 2 -2 4s2 2 2 4M12 0c0 2 -2 2 -2 4s2 2 2 4s-2 2 -2 4s2 2 2 4M16 0c0 2 -2 2 -2 4s2 2 2 4s-2 2 -2 4s2 2 2 4;M8 -8c0 2 -2 2 -2 4s2 2 2 4s-2 2 -2 4s2 2 2 4M12 -8c0 2 -2 2 -2 4s2 2 2 4s-2 2 -2 4s2 2 2 4M16 -8c0 2 -2 2 -2 4s2 2 2 4s-2 2 -2 4s2 2 2 4"/></path><path d="M4 7h16v0h-16v12h16v-32h-16Z"><animate fill="freeze" attributeName="d" begin="1.15s" dur="0.69s" to="M4 2h16v5h-16v12h16v-24h-16Z"/></path></mask></defs><path fill="currentColor" fill-opacity="0" d="M17 14v4c0 1.66 -1.34 3 -3 3h-6c-1.66 0 -3 -1.34 -3 -3v-4Z"><animate fill="freeze" attributeName="fill-opacity" begin="1.84s" dur="0.172s" to="0.3"/></path><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path stroke-dasharray="48" d="M17 9v9c0 1.66 -1.34 3 -3 3h-6c-1.66 0 -3 -1.34 -3 -3v-9Z"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.69s" values="48;0"/></path><path stroke-dasharray="16" stroke-dashoffset="16" d="M17 9h3c0.55 0 1 0.45 1 1v3c0 0.55 -0.45 1 -1 1h-3"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.69s" dur="0.345s" to="0"/></path></g><path fill="currentColor" d="M0 0h24v24H0z" mask="url(#SVG5AkzhcyZ)"/>
            </svg>
        </h1>
        <nav class="nav-menu">
            <a href="{{ route('customer.pesanan.menu') }}"  class="nav-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 24px; height: 24px;">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                Kembali Ke Beranda
            </a>

            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
                Dashboard
            </a>

            <div class="nav-item-dropdown {{ Request::is('admin/menu*') ? 'active' : '' }}">
                <a href="javascript:void(0)" class="nav-link dropdown-trigger">
                    <svg viewBox="0 0 24 24">
                        <path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
                        <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
                        <line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line>
                    </svg>
                    <span>Manajemen Menu</span>
                    <svg class="chevron" viewBox="0 0 24 24" style="margin-left: auto; width: 14px; height: 14px;"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </a>
                <div class="submenu">
                    <a href="{{ route('admin.menu.index') }}" class="sub-link {{ Request::is('admin/menu') ? 'current' : '' }}">📜 Daftar Menu</a>
                    <a href="{{ route('admin.menu.create') }}" class="sub-link {{ Request::is('admin/menu/create') ? 'current' : '' }}">➕ Tambah Menu Baru</a>
                </div>
            </div>

            <a href="{{ route('admin.mutasi.index') }}" class="nav-link {{ Request::is('admin/mutasi') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24">
                    <path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1-2-1z"></path>
                    <path d="M16 8h-6a2 2 0 0 0-2 2v0a2 2 0 0 0 2 2h6"></path>
                    <path d="M16 14H8"></path>
                </svg>
                Transaksi
            </a>
        </nav>

        <div style="margin-top: auto; padding-top: 20px; border-top: 2px dashed #fce4ec;">
            <a href="javascript:void(0)" class="nav-link logout-trigger" onclick="openLogoutModal(event)">
                <svg viewBox="0 0 24 24">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                <span>Keluar / Logout</span>
            </a>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </aside>

    <main class="main-content" id="app-content">
        @yield('content')
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const loader = document.getElementById('loader');
            const content = document.getElementById('app-content');
            setTimeout(() => {
                loader.style.opacity = '0';
                setTimeout(() => loader.style.display = 'none', 100);
                content.classList.add('loaded');
            }, 700);

            const sidebarToggle = document.getElementById('sidebarToggle');
            const body = document.body;

            sidebarToggle.addEventListener('click', function() {
                if (window.innerWidth > 768) {
                    body.classList.toggle('sidebar-collapsed');
                } else {
                    body.classList.toggle('sidebar-open');
                }
            });

            const dropdownTrigger = document.querySelector('.dropdown-trigger');
            const dropdownParent = document.querySelector('.nav-item-dropdown');

            dropdownTrigger.addEventListener('click', function(e) {
                e.preventDefault();
                dropdownParent.classList.toggle('active');
            });

            window.confirmDelete = function(e) {
                if(!confirm("Beneran mau hapus data ini? Nanti datanya nangis lho... 🥺")) {
                    e.preventDefault();
                }
            }
        });

        function openLogoutModal(e) {
            e.preventDefault();
            const modal = document.getElementById('logoutModal');
            const box = document.getElementById('modalBox');
            
            modal.style.display = 'flex';
            setTimeout(() => {
                modal.style.opacity = '1';
                box.style.transform = 'scale(1)';
            }, 10);
        }

        function closeLogoutModal() {
            const modal = document.getElementById('logoutModal');
            const box = document.getElementById('modalBox');
            
            modal.style.opacity = '0';
            box.style.transform = 'scale(0.8)';
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }

        window.onclick = function(event) {
            const modal = document.getElementById('logoutModal');
            if (event.target == modal) {
                closeLogoutModal();
            }
        }
    </script>
    <div id="logoutModal" style="display: none; position: fixed; inset: 0; background: rgba(93, 64, 55, 0.4); backdrop-filter: blur(5px); z-index: 2000; align-items: center; justify-content: center; opacity: 0; transition: all 0.3s ease;">
    <div style="background: white; padding: 35px; border-radius: 30px; width: 90%; max-width: 400px; text-align: center; box-shadow: 0 20px 50px rgba(141, 110, 99, 0.2); transform: scale(0.8); transition: all 0.3s var(--cb-bounce);" id="modalBox">
        
        <div style="background: #fff3f0; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#ffab91" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                <polyline points="16 17 21 12 16 7"></polyline>
                <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg>
        </div>

        <h3 style="margin: 0; color: var(--text-main); font-size: 1.5rem;">Mau istirahat?</h3>
        <p style="color: #a1887f; margin: 10px 0 25px;">Pastikan semua pesanan sudah tercatat sebelum keluar ya! ✨</p>

        <div style="display: flex; gap: 12px;">
            <button onclick="closeLogoutModal()" style="flex: 1; padding: 12px; border-radius: 15px; border: 2px solid #eee; background: white; color: #a1887f; font-weight: 700; cursor: pointer; transition: 0.3s;">
                Batal
            </button>
            <button onclick="document.getElementById('logout-form').submit();" style="flex: 1; padding: 12px; border-radius: 15px; border: none; background: var(--secondary); color: white; font-weight: 700; cursor: pointer; transition: 0.3s; box-shadow: 0 5px 15px rgba(216, 27, 96, 0.3);">
                Ya, Keluar
            </button>
        </div>
    </div>
</div>
</body>
</html>