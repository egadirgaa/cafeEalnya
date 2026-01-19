<?php $__env->startSection('title', 'Cafe Ealnya - Menu'); ?>

<?php $__env->startSection('content'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .menu-wrapper { 
        animation: fadeInUp 0.8s var(--cb-bounce); 
    }
    
    .overlay-content { 
        background: linear-gradient(rgba(255,214,232,.6), rgba(255,214,232,.6)); 
        border-radius: 30px; 
        padding: 30px; 
        min-height: calc(100vh - 40px); 
    }

    .header-content { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        margin-bottom: 25px; 
        flex-wrap: wrap; 
        gap: 15px; 
    }

    .header-content h1 { 
        margin: 0; 
        font-size: clamp(24px, 5vw, 32px); 
        font-weight: 900; 
        color: var(--pink-4); 
        letter-spacing: -1px; 
    }

    .card-menu { 
        background: rgba(255, 255, 255, 0.9); 
        border: 1px solid rgba(255, 255, 255, 0.5); 
        border-radius: 24px; 
        padding: 25px; 
        box-shadow: 0 15px 35px rgba(180, 0, 106, 0.05); 
    }

    .card-menu h2 { 
        margin: 0 0 25px; 
        font-size: 20px; 
        color: var(--pink-4); 
        display: flex; 
        align-items: center; 
        gap: 10px; 
    }

    .grid { 
        display: grid; 
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); 
        gap: 20px; 
    }

    .item { 
        background: #fff; 
        border-radius: 20px; 
        overflow: hidden; 
        box-shadow: 0 8px 20px rgba(0,0,0,0.03); 
        display: flex; 
        flex-direction: column; 
        transition: 0.4s var(--cb-bounce);
        border: 1px solid #f0f0f0; 
    }

    .item:hover { 
        transform: translateY(-8px); 
        box-shadow: 0 15px 30px rgba(180, 0, 106, 0.12); 
    }

    .item img { 
        width: 100%; 
        height: 180px; 
        object-fit: cover; 
        transition: 0.6s var(--cb-bounce); 
    }

    .item-body { padding: 15px; display: flex; flex-direction: column; gap: 8px; flex: 1; }
    
    .name { margin: 0; font-size: 17px; font-weight: 800; color: #333; }

    .meta { display: flex; justify-content: space-between; align-items: center; font-size: 12px; }
    
    .badge-kat { 
        background: var(--pink-1); 
        color: var(--pink-4); 
        padding: 4px 10px; 
        border-radius: 10px; 
        font-weight: 800; 
        text-transform: uppercase; 
    }

    .price { font-weight: 900; color: var(--pink-4); font-size: 20px; margin: 5px 0; }
    
    .bottom-action { margin-top: auto; display: flex; gap: 8px; }

    .qty-input { 
        width: 55px; 
        padding: 10px; 
        border-radius: 12px; 
        border: 2px solid var(--pink-1); 
        text-align: center; 
        font-weight: bold; 
        outline: none; 
    }

    .btn-add { 
        background: linear-gradient(135deg, var(--pink-3), var(--pink-4)); 
        color: white; 
        border: none; 
        padding: 10px; 
        border-radius: 12px; 
        font-weight: 800; 
        flex: 1; 
        cursor: pointer; 
        transition: 0.3s var(--cb-bounce); 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        gap: 5px; 
    }

    .btn-add:hover { filter: brightness(1.1); }
    .btn-add:disabled { background: #ccc !important; cursor: not-allowed; }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .btn-filter {
    padding: 10px 20px;
    border-radius: 12px;
    border: 2px solid var(--pink-1);
    background: white;
    color: var(--pink-4);
    font-weight: 700;
    cursor: pointer;
    transition: 0.3s;
    white-space: nowrap;
}

    .btn-filter.active, .btn-filter:hover {
        background: var(--pink-3);
        color: white;
        border-color: var(--pink-3);
    }

    .item.hidden {
        display: none;
    }
</style>

<div class="menu-wrapper">
    <div class="overlay-content">
            <div class="header-content">
                <div>
                    <h1>Cafe Ealnya ✨</h1>
                    <p style="margin:5px 0 0; opacity:0.8; font-weight:600;">Mood booster-mu dimulai dari sini!</p>
                </div>

                <div class="menu-controls" style="display: flex; gap: 10px; flex-wrap: wrap; width: 100%; margin-top: 10px;">
                    <div class="search-box" style="position: relative; flex: 1; min-width: 250px;">
                        <span class="material-symbols-rounded" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--pink-3);">search</span>
                        <input type="text" id="menuSearch" placeholder="Cari menu favoritmu..." 
                            style="width: 100%; padding: 12px 12px 12px 40px; border-radius: 15px; border: 2px solid var(--pink-1); outline: none; font-weight: 600;">
                    </div>
                    
                    <div class="filter-group" style="display: flex; gap: 8px; overflow-x: auto; padding-bottom: 5px;">
                        <button class="btn-filter active" data-category="all">Semua</button>
                        <button class="btn-filter" data-category="makanan">Makanan</button>
                        <button class="btn-filter" data-category="minuman">Minuman</button>
                        <button class="btn-filter" data-category="cemilan">Cemilan</button>
                    </div>
                </div>
            </div>
        

        <div class="card-menu">
            <h2>
                <span class="material-symbols-rounded" style="color:var(--pink-3)">auto_awesome</span> 
                Menu Cafe Ealnya
            </h2>

            <?php if($menus->isEmpty()): ?>
                <div style="text-align:center; padding:60px 20px;">
                    <span class="material-symbols-rounded" style="font-size: 64px; color: var(--pink-2);">cookie</span>
                    <p style="color:#888; font-weight:600; margin-top:15px;">Oops! Menu belum tersedia, tunggu sebentar ya!</p>
                </div>
            <?php else: ?>
                <div class="grid">
                    <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="item" id="menu-card-<?php echo e($m->id); ?>">
                            <img src="<?php echo e(str_contains($m->gambar, 'menu/') ? asset('storage/' . $m->gambar) : asset('storage/menu/' . $m->gambar)); ?>" onerror="this.src='https://ui-avatars.com/api/?name=<?php echo e(urlencode($m->nama_menu)); ?>&color=ff6fb1&background=ffd6e8'">

                            <div class="item-body">
                                <p class="name"><?php echo e($m->nama_menu); ?></p>

                                <div class="meta">
                                    <span class="badge-kat"><?php echo e($m->kategori); ?></span>
                                    <span style="opacity:0.6; font-weight:700;">Tersedia: <span id="stok-text-<?php echo e($m->id); ?>"><?php echo e($m->stok); ?></span></span>
                                </div>

                                <div class="price">Rp <?php echo e(number_format($m->harga, 0, ',', '.')); ?></div>

                                <form class="bottom-action ajax-form" data-id="<?php echo e($m->id); ?>" action="<?php echo e(route('customer.pesanan.tambah', $m->id)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <input class="qty-input" type="number" name="qty" id="qty-<?php echo e($m->id); ?>" value="1" min="1" max="<?php echo e($m->stok); ?>" <?php echo e($m->stok <= 0 ? 'disabled' : ''); ?>>
                                    
                                    <button class="btn-add" type="submit" id="btn-<?php echo e($m->id); ?>" <?php echo e($m->stok <= 0 ? 'disabled' : ''); ?>>
                                        <span class="material-symbols-rounded" style="font-size:18px;">
                                            <?php echo e($m->stok <= 0 ? 'block' : 'add_shopping_cart'); ?>

                                        </span>
                                        <span class="btn-text"><?php echo e($m->stok <= 0 ? 'Habis' : 'Tambah'); ?></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.ajax-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const menuId = this.getAttribute('data-id');
        const qtyInput = document.getElementById(`qty-${menuId}`);
        const btn = document.getElementById(`btn-${menuId}`);
        const btnText = btn.querySelector('.btn-text');
        const stokText = document.getElementById(`stok-text-${menuId}`);
        
        const originalContent = btn.innerHTML;
        
        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm" style="width: 1.2rem; height: 1.2rem;"></span>`;

        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            }
        })
        .then(response => {
            if (!response.ok) throw response;
            return response.json();
        })
        .then(data => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });

            Toast.fire({
                icon: 'success',
                title: 'Masuk keranjang! ✨'
            });

            const badge = document.getElementById('cart-count');
            if (badge) {
                badge.innerText = data.total_qty; 
                badge.style.display = 'flex';
                
                badge.style.animation = 'none';
                badge.offsetHeight; 
                badge.style.animation = 'popIn 0.3s var(--cb-bounce)';
            }

            let currentStok = parseInt(stokText.innerText);
            let addedQty = parseInt(qtyInput.value);
            let newStok = currentStok - addedQty;
            
            stokText.innerText = newStok;
            qtyInput.max = newStok;
            qtyInput.value = (newStok > 0) ? 1 : 0;

            if (newStok <= 0) {
                btn.disabled = true;
                btn.innerHTML = `<span class="material-symbols-rounded" style="font-size:18px;">block</span> Habis`;
                qtyInput.disabled = true;
            } else {
                btn.innerHTML = originalContent;
                btn.disabled = false;
            }
        })
        .catch(async (error) => {
            let errorMsg = "Terjadi kesalahan";
            try {
                const data = await error.json();
                errorMsg = data.message || errorMsg;
            } catch(e) {}
            
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: errorMsg,
                confirmButtonColor: '#f75c7e'
            });
            
            btn.innerHTML = originalContent;
            btn.disabled = false;
        });
    });
});
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('menuSearch');
    const filterButtons = document.querySelectorAll('.btn-filter');
    const menuItems = document.querySelectorAll('.grid .item');

    function filterMenu() {
        const searchTerm = searchInput.value.toLowerCase();
        const activeCategory = document.querySelector('.btn-filter.active').getAttribute('data-category').toLowerCase();

        menuItems.forEach(item => {
            const menuName = item.querySelector('.name').innerText.toLowerCase();
            const menuCategory = item.querySelector('.badge-kat').innerText.toLowerCase();
            
            const matchesSearch = menuName.includes(searchTerm);
            const matchesCategory = (activeCategory === 'all' || menuCategory === activeCategory);

            if (matchesSearch && matchesCategory) {
                item.style.display = 'flex';
                item.style.animation = 'fadeInUp 0.4s ease forwards';
            } else {
                item.style.display = 'none';
            }
        });

        const visibleItems = document.querySelectorAll('.item[style="display: flex;"]');
    }

    searchInput.addEventListener('input', filterMenu);

    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            filterButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            filterMenu();
        });
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/egdrga/Documents/laravel/ealnya/ealnya/resources/views/customer/menu/index.blade.php ENDPATH**/ ?>