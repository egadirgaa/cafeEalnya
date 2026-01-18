<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* --- Animasi Muncul --- */
    .reveal { opacity: 0; }
    
    @keyframes slideInRight { from { opacity: 0; transform: translateX(-30px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes slideInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes popIn { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }

    .animate-header { animation: slideInRight 0.8s var(--cb-bounce) forwards; }
    .animate-card { animation: popIn 0.8s var(--cb-bounce) forwards; }
    .animate-table { animation: slideInUp 0.8s var(--cb-bounce) forwards; }

    /* --- Stats Section --- */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    .stat-card-new {
        background: white;
        padding: 30px;
        border-radius: 28px;
        border: 1px solid rgba(255, 171, 145, 0.15);
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.4s var(--cb-bounce);
        box-shadow: 0 10px 30px rgba(141, 110, 99, 0.03);
    }

    .stat-card-new:hover {
        transform: translateY(-8px);
        border-color: var(--primary);
        box-shadow: 0 15px 35px rgba(216, 27, 96, 0.1);
    }

    .icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* --- Table Design --- */
    .dashboard-card {
        background: white;
        padding: 35px;
        border-radius: 32px;
        box-shadow: 0 15px 45px rgba(141, 110, 99, 0.04);
        border: 1px solid rgba(255, 171, 145, 0.1);
    }

    .user-pill {
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 700;
        color: var(--text-main);
    }

    .avatar-sm {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
    }

    /* --- Pagination Dots --- */
    .dot-pagination {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 30px;
    }

    .dot-item {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: none;
        background: #eee;
        cursor: pointer;
        transition: 0.3s;
    }

    .dot-item.active {
        background: var(--secondary);
        transform: scale(1.4);
    }
</style>

<div class="dashboard-wrapper">
    <div id="header-reveal" class="reveal" style="display: flex; align-items: center; gap: 15px; margin-bottom: 35px;">
        <div style="background: var(--primary); padding: 12px; border-radius: 18px; color: white;">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
        </div>
        <div>
            <h2 style="margin: 0; color: var(--text-main); font-weight: 800;">Ringkasan Ealnya</h2>
            <p style="margin: 0; color: #a1887f;">Dashboard pengelolaan transaksi & menu.</p>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card-new reveal" id="card-1">
            <div class="icon-circle" style="background: #fff3f0; color: var(--primary);">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
            </div>
            <div>
                <span style="font-size: 0.8rem; color: #a1887f; font-weight: 700; text-transform: uppercase;">Omzet Hari Ini</span>
                <h3 style="margin: 0; color: var(--text-main); font-size: 1.5rem;">
                    
                    Rp <?php echo e(number_format($pendapatanHariIni ?? 0, 0, ',', '.')); ?>

                </h3>
            </div>
        </div>

        <div class="stat-card-new reveal" id="card-2">
            <div class="icon-circle" style="background: #f0f4ff; color: #448aff;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            </div>
            <div>
                <span style="font-size: 0.8rem; color: #a1887f; font-weight: 700; text-transform: uppercase;">Pesanan Hari Ini</span>
                <h3 style="margin: 0; color: var(--text-main); font-size: 1.5rem;"><?php echo e($transaksiHariIni->count()); ?> Order</h3>
            </div>
        </div>

        <div class="stat-card-new reveal" id="card-3">
            <div class="icon-circle" style="background: #fff0f6; color: var(--secondary);">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg>
            </div>
            <div>
                <span style="font-size: 0.8rem; color: #a1887f; font-weight: 700; text-transform: uppercase;">Koleksi Menu</span>
                <h3 style="margin: 0; color: var(--text-main); font-size: 1.5rem;"><?php echo e($totalMenu); ?> Menu</h3>
            </div>
        </div>
    </div>

    <div class="dashboard-card reveal" id="table-reveal">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--secondary)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <h3 style="margin:0; font-weight: 800; color: var(--text-main);">Pesanan Masuk Terbaru</h3>
            </div>
        </div>

        <div class="table-responsive">
            <table style="width: 100%; border-collapse: separate; border-spacing: 0 12px;">
                <thead>
                    <tr style="text-align: left; color: #a1887f; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1.5px;">
                        <th style="padding: 0 20px;">Pelanggan</th>
                        <th>Waktu</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th style="text-align: center;">Opsi</th>
                    </tr>
                </thead>
                <tbody id="dashTableBody">
                    <?php $__empty_1 = true; $__currentLoopData = $transaksiHariIni; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="dash-row">
                        <td style="padding: 15px 20px; background: #fffcfb; border-radius: 20px 0 0 20px;">
                            <div class="user-pill">
                                <div class="avatar-sm"><?php echo e(strtoupper(substr($trx->user->name ?? 'G', 0, 1))); ?></div>
                                <span><?php echo e($trx->user->name ?? 'Guest User'); ?></span>
                            </div>
                        </td>
                        <td style="background: #fffcfb; color: #8d6e63; font-weight: 600;"><?php echo e($trx->created_at->format('H:i')); ?> WIB</td>
                        <td style="background: #fffcfb; font-weight: 800; color: var(--secondary);">Rp <?php echo e(number_format($trx->total_harga, 0, ',', '.')); ?></td>
                        <td style="background: #fffcfb;">
                            <span class="status-badge" style="<?php echo e($trx->status == 'selesai' ? 'background:#e8f5e9;color:#2e7d32' : 'background:#fff3e0;color:#ef6c00'); ?>">
                                <?php echo e($trx->status); ?>

                            </span>
                        </td>
                        <td style="background: #fffcfb; border-radius: 0 20px 20px 0; text-align: center;">
                            <a href="<?php echo e(route('admin.mutasi.show', $trx->id)); ?>" style="color: var(--primary);">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 50px; color: #a1887f;">☕ Belum ada aktivitas pesanan hari ini.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="dot-pagination" id="dashPagination"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Staggered Entrance dengan SVG Support
    const components = [
        { id: 'header-reveal', anim: 'animate-header', delay: 100 },
        { id: 'card-1', anim: 'animate-card', delay: 300 },
        { id: 'card-2', anim: 'animate-card', delay: 450 },
        { id: 'card-3', anim: 'animate-card', delay: 600 },
        { id: 'table-reveal', anim: 'animate-table', delay: 800 }
    ];

    components.forEach(item => {
        setTimeout(() => {
            const el = document.getElementById(item.id);
            if(el) {
                el.classList.add(item.anim);
                el.style.opacity = '1';
            }
        }, item.delay);
    });

    // 2. Client-Side Pagination Logic
    const perPage = 5;
    const rows = Array.from(document.getElementsByClassName('dash-row'));
    const pagination = document.getElementById('dashPagination');

    function goToPage(num) {
        const start = (num - 1) * perPage;
        const end = start + perPage;

        rows.forEach((row, i) => {
            row.style.display = (i >= start && i < end) ? '' : 'none';
        });

        drawDots(num);
    }

    function drawDots(active) {
        pagination.innerHTML = '';
        const count = Math.ceil(rows.length / perPage);
        if(count <= 1) return;

        for(let i=1; i<=count; i++) {
            const dot = document.createElement('button');
            dot.className = `dot-item ${i === active ? 'active' : ''}`;
            dot.onclick = () => goToPage(i);
            pagination.appendChild(dot);
        }
    }

    if(rows.length > 0) goToPage(1);
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/egdrga/Documents/laravel/ealnya/ealnya/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>