@extends('layouts.admin')

@section('title', 'Manajemen Menu')

@section('content')
<style>
    .menu-wrapper {
        animation: entrance 0.8s var(--cb-bounce) forwards;
    }

    @keyframes entrance {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* --- Search Bar Styling --- */
    .search-section {
        margin-bottom: 30px;
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        align-items: center;
        justify-content: space-between;
    }

    .search-box {
        position: relative;
        flex: 1;
        max-width: 400px;
    }

    .search-box input {
        width: 100%;
        padding: 12px 20px 12px 45px;
        border-radius: 18px;
        border: 2px solid #fff3f0;
        background: white;
        font-family: 'Quicksand', sans-serif;
        font-weight: 600;
        transition: all 0.3s var(--cb-bounce);
    }

    .search-box input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 10px 20px rgba(255, 171, 145, 0.15);
    }

    .search-box svg {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary);
    }

    /* --- Card Styles --- */
    .menu-card {
        background: white;
        border-radius: 25px;
        overflow: hidden;
        border: 1px solid #f0f0f0;
        transition: all 0.4s var(--cb-bounce);
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .menu-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(141, 110, 99, 0.15);
    }

    .fade-item {
        animation: cardFade 0.4s ease forwards;
    }

    @keyframes cardFade {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    .pagination-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }

    .pagination-buttons {
        display: flex;
        gap: 8px;
    }

    .page-btn {
        min-width: 45px;
        height: 45px;
        border-radius: 15px;
        border: 2px solid #fff3f0;
        background: white;
        color: var(--text-main);
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
    }

    .page-btn.active {
        background: var(--secondary);
        border-color: var(--secondary);
        color: white;
    }

    .page-btn:disabled { opacity: 0.4; cursor: not-allowed; }
    /* notif */
    .flash-container {
        position: sticky;
        top: 30px;
        right: 30px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 15px;
        max-width: 350px;
        width: calc(100% - 60px);
    }

    .alert-custom {
        display: flex;
        align-items: center;
        padding: 16px 20px;
        border-radius: 20px;
        background: white;
        box-shadow: 0 15px 30px rgba(0,0,0,0.12); /* Shadow lebih dalam agar terlihat melayang */
        border: 1px solid rgba(0,0,0,0.05);
        animation: slideInRight 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        position: relative;
    }

    .alert-success {
        border-left: 6px solid #43a047;
        background-color: #ffffff;
        color: #2e7d32;
    }

    .alert-danger {
        border-left: 6px solid #e53935;
        background-color: #ffffff;
        color: #c62828;
    }

    .alert-icon {
        font-size: 1.4rem;
        margin-right: 15px;
    }

    .alert-content strong {
        display: block;
        font-size: 1rem;
        margin-bottom: 2px;
    }

    .alert-content p {
        margin: 0;
        font-size: 0.85rem;
        color: #6d4c41;
    }

    .close-alert {
        margin-left: 15px;
        background: none;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        color: #a1887f;
        transition: 0.3s;
    }

    .close-alert:hover {
        color: #5d4037;
        transform: scale(1.1);
    }

    @keyframes slideInRight {
        from { 
            opacity: 0; 
            transform: translateX(-100px); 
        }
        to { 
            opacity: 1; 
            transform: translateX(0); 
        }
    }

    .fade-out {
        animation: slideOutRight 0.5s ease forwards !important;
    }

    @keyframes slideOutRight {
        from { opacity: 1; transform: translateX(0); }
        to { opacity: 0; transform: translateX(-100px); }
    }
</style>

<div class="menu-wrapper">
    <div class="flash-container">
    @if(session('success'))
        <div class="alert-custom alert-success">
            <div class="alert-icon">✅</div>
            <div class="alert-content">
                <strong>Berhasil!</strong>
                <p>{{ session('success') }}</p>
            </div>
            <button type="button" class="close-alert" onclick="this.parentElement.remove()">×</button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert-custom alert-danger">
            <div class="alert-icon">❌</div>
            <div class="alert-content">
                <strong>Gagal!</strong>
                <p>{{ session('error') }}</p>
            </div>
            <button type="button" class="close-alert" onclick="this.parentElement.remove()">×</button>
        </div>
    @endif
</div>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h2 style="margin: 0; color: var(--text-main);">Daftar Menu Cafe 🍰</h2>
            <p style="color: #a1887f; margin-top: 5px;">Total <span id="totalMenuCount">{{ $menus->count() }}</span> menu tersedia.</p>
        </div>
    </div>

    <div class="search-section">
        <div class="search-box">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input type="text" id="menuSearch" placeholder="Cari nama menu atau kategori...">
        </div>
         <div class="pagination-container" id="menuPagination">
            <div id="menuPageInfo" style="font-size: 0.9rem; color: #a1887f; font-weight: 600;"></div>
            <div class="pagination-buttons" id="menuPaginationButtons"></div>
        </div>
    </div>

   

    @if($menus->isEmpty())
        <div style="text-align: center; padding: 100px 20px; background: white; border-radius: 30px; border: 2px dashed #ffe0b2;">
            <span style="font-size: 50px;">🥘</span>
            <h3 style="color: #8d6e63; margin-top: 20px;">Belum Ada Menu</h3>
        </div>
    @else
        <div id="menuGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px;">
            @foreach($menus as $menu)
            <div class="menu-card searchable-item" data-name="{{ strtolower($menu->nama_menu) }}" data-category="{{ strtolower($menu->kategori) }}">
                <div class="category-tag" style="position: absolute; top: 15px; left: 15px; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(8px); padding: 6px 14px; border-radius: 12px; font-size: 0.8rem; font-weight: 700; z-index: 2; color: #5d4037;">
                    @if(strtolower($menu->kategori) == 'minuman') ☕ 
                    @elseif(strtolower($menu->kategori) == 'makanan') 🍛 
                    @else 🍰 @endif 
                    {{ ucfirst($menu->kategori) }}
                </div>

                <div style="width: 100%; height: 200px; overflow: hidden;">
                    <img src="{{ str_contains($menu->gambar, 'menu/') ? asset('storage/' . $menu->gambar) : asset('storage/menu/' . $menu->gambar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                </div>

                <div style="padding: 20px; flex-grow: 1; display: flex; flex-direction: column;">
                    <h3 style="margin: 0 0 10px 0; font-size: 1.2rem; color: #4e342e;">{{ $menu->nama_menu }}</h3>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <div>
                            <span style="display: block; font-size: 0.75rem; color: #a1887f; text-transform: uppercase;">Harga</span>
                            <span style="color: var(--secondary); font-weight: 800; font-size: 1.1rem;">Rp{{ number_format($menu->harga, 0, ',', '.') }}</span>
                        </div>
                        <div style="text-align: right;">
                            <span style="display: block; font-size: 0.75rem; color: #a1887f; text-transform: uppercase;">Stok</span>
                            <span style="font-weight: 700; color: {{ $menu->stok < 10 ? '#e53935' : '#43a047' }};">{{ $menu->stok }} pcs</span>
                        </div>
                    </div>

                    <div style="display: flex; gap: 10px; margin-top: auto;">
                        <a href="{{ route('admin.menu.edit', $menu->id) }}" style="flex: 1; text-align: center; padding: 10px; border-radius: 12px; background: #fff3e0; color: #ef6c00; text-decoration: none; font-weight: 700; font-size: 0.85rem;">✏️ Edit</a>
                        
                        <form action="{{ route('admin.menu.destroy', $menu->id) }}" method="POST" style="flex: 1;">
                            @csrf
                            @method('DELETE')
                            <button type="button" 
                                    class="delete-menu-btn" 
                                    data-id="{{ $menu->id }}" 
                                    data-name="{{ $menu->nama_menu }}"
                                    style="flex: 1; padding: 10px; border-radius: 12px; background: #ffebee; color: #c62828; border: none; font-weight: 700; font-size: 0.85rem; cursor: pointer;">
                                🗑️ Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('menuSearch');
    const menuGrid = document.getElementById('menuGrid');
    const allItems = Array.from(document.getElementsByClassName('searchable-item'));
    const paginationButtons = document.getElementById('menuPaginationButtons');
    const pageInfo = document.getElementById('menuPageInfo');
    const totalCountLabel = document.getElementById('totalMenuCount');

    let filteredItems = allItems;
    let currentPage = 1;
    const itemsPerPage = 10;

    function performSearch() {
        const query = searchInput.value.toLowerCase();
        
        filteredItems = allItems.filter(item => {
            const name = item.getAttribute('data-name');
            const category = item.getAttribute('data-category');
            return name.includes(query) || category.includes(query);
        });

        totalCountLabel.innerText = filteredItems.length;
        currentPage = 1;
        updateDisplay();
    }

function showFlash(type, message) {
    const container = document.querySelector('.flash-container');
    const icon = type === 'success' ? '✅' : '❌';
    const title = type === 'success' ? 'Berhasil!' : 'Gagal!';
    
    const alertHtml = `
        <div class="alert-custom alert-${type}">
            <div class="alert-icon">${icon}</div>
            <div class="alert-content">
                <strong>${title}</strong>
                <p>${message}</p>
            </div>
            <button type="button" class="close-alert" onclick="this.parentElement.remove()">×</button>
        </div>
    `;
    
    const newAlert = document.createElement('div');
    newAlert.innerHTML = alertHtml.trim();
    const alertElem = newAlert.firstChild;
    
    container.appendChild(alertElem);

    setTimeout(() => {
        alertElem.classList.add('fade-out');
        setTimeout(() => alertElem.remove(), 500);
    }, 4000);
}

    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('delete-menu-btn')) {
            const btn = e.target;
            const menuId = btn.getAttribute('data-id');
            const menuName = btn.getAttribute('data-name');

            if (confirm(`Hapus menu ${menuName}?`)) {
                btn.innerText = '⏳...';
                btn.style.opacity = '0.5';
                btn.disabled = true;

                fetch(`/admin/menu/${menuId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const card = btn.closest('.menu-card');
                        card.style.transition = '0.4s';
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.8)';
                        
                        setTimeout(() => {
                            card.remove();
                            const index = allItems.indexOf(card);
                            if (index > -1) allItems.splice(index, 1);
                            
                            performSearch(); 
                            showFlash('success', data.message);
                        }, 400);
                    } else {
                        showFlash('error', 'Gagal menghapus data.');
                        btn.innerText = '🗑️ Hapus';
                        btn.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showFlash('error', 'Terjadi kesalahan sistem.');
                    btn.innerText = '🗑️ Hapus';
                    btn.disabled = false;
                });
            }
        }
    });

    function updateDisplay() {
        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;

        allItems.forEach(item => {
            item.style.display = 'none';
            item.classList.remove('fade-item');
        });

        const pageItems = filteredItems.slice(start, end);
        pageItems.forEach(item => {
            item.style.display = 'flex';
            item.classList.add('fade-item');
        });

        renderPagination();
        
        if (filteredItems.length > 0) {
            pageInfo.innerText = `Menampilkan ${start + 1}-${Math.min(end, filteredItems.length)} dari ${filteredRows = filteredItems.length} menu`;
            document.getElementById('menuPagination').style.display = 'flex';
        } else {
            pageInfo.innerText = "Menu tidak ditemukan... 🍰";
            document.getElementById('menuPagination').style.display = 'none';
        }
    }

    function renderPagination() {
        paginationButtons.innerHTML = '';
        const pageCount = Math.ceil(filteredItems.length / itemsPerPage);

        if (pageCount <= 1) return;

        const prevBtn = document.createElement('button');
        prevBtn.className = 'page-btn';
        prevBtn.innerText = '←';
        prevBtn.disabled = currentPage === 1;
        prevBtn.onclick = () => { currentPage--; updateDisplay(); scrollUp(); };
        paginationButtons.appendChild(prevBtn);

        for (let i = 1; i <= pageCount; i++) {
            const btn = document.createElement('button');
            btn.className = `page-btn ${i === currentPage ? 'active' : ''}`;
            btn.innerText = i;
            btn.onclick = () => { currentPage = i; updateDisplay(); scrollUp(); };
            paginationButtons.appendChild(btn);
        }

        const nextBtn = document.createElement('button');
        nextBtn.className = 'page-btn';
        nextBtn.innerText = '→';
        nextBtn.disabled = currentPage === pageCount;
        nextBtn.onclick = () => { currentPage++; updateDisplay(); scrollUp(); };
        paginationButtons.appendChild(nextBtn);
    }

    function scrollUp() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    searchInput.addEventListener('input', performSearch);
    updateDisplay();
});

document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert-custom');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.classList.add('fade-out');
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 4000);
    });
});
</script>
@endsection