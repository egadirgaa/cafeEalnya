<?php $__env->startSection('title', 'Mutasi Transaksi'); ?>

<?php $__env->startSection('content'); ?>
<div class="mutasi-wrapper">
    <div class="header-section">
        <div class="title-group">
            <h2 class="title">Mutasi Transaksi 📝</h2>
            <p class="subtitle">Pantau semua histori transaksi Cafe Eal di sini.</p>
        </div>
        <div class="count-pill">
            Total: <span id="totalCount"><?php echo e($transaksis->count()); ?></span>
        </div>
    </div>

    <div class="card-eal">
        <div class="search-container">
            <div class="search-wrapper">
                <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input type="text" id="searchInput" class="search-input" placeholder="Cari nama pelanggan atau ID...">
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table-eal">
                <thead>
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Waktu</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php $__empty_1 = true; $__currentLoopData = $transaksis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="table-row" data-search="<?php echo e(strtolower($t->user->name ?? 'guest')); ?> #trx-<?php echo e($t->id); ?>">
                        <td class="trx-id">#TRX-<?php echo e(str_pad($t->id, 4, '0', STR_PAD_LEFT)); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($t->tanggal)->format('d M Y')); ?></td>
                        <td class="customer-name"><?php echo e($t->user->name ?? 'Guest User'); ?></td>
                        <td class="total-price">Rp <?php echo e(number_format($t->total_harga, 0, ',', '.')); ?></td>
                        <td>
                            <span class="status-badge <?php echo e($t->status == 'selesai' ? 'status-done' : 'status-pending'); ?>">
                                <?php echo e(strtoupper($t->status)); ?>

                            </span>
                        </td>
                        <td style="text-align: center;">
                            <a href="<?php echo e(route('admin.mutasi.show', $t->id)); ?>" class="btn-detail">Detail</a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr id="noData">
                        <td colspan="6" class="empty-state">☕ Belum ada transaksi...</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="eal-pagination-container" id="paginationWrapper">
            <div id="pageInfo" class="page-info"></div>
            <div id="paginationControls" class="pagination-buttons"></div>
        </div>
    </div>
</div>

<style>
    /* --- Layout & Typography --- */
    .mutasi-wrapper { animation: entrance 0.8s var(--cb-bounce) forwards; }
    @keyframes entrance { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

    .header-section { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        margin-bottom: 25px; 
    }
    .title { margin: 0; color: var(--text-main); font-weight: 800; }
    .subtitle { color: #a1887f; margin: 5px 0 0; }

    .count-pill {
        background: var(--primary);
        color: white;
        padding: 8px 20px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.85rem;
        box-shadow: 0 5px 15px rgba(255, 171, 145, 0.3);
    }

    /* --- Search Section --- */
    .card-eal {
        background: white;
        border-radius: 28px;
        box-shadow: 0 15px 45px rgba(141, 110, 99, 0.05);
        border: 1px solid rgba(255, 171, 145, 0.1);
        overflow: hidden;
    }

    .search-container { padding: 25px; border-bottom: 1px solid #fff3f0; }
    .search-wrapper { position: relative; max-width: 100%; }
    .search-input {
        width: 100%;
        padding: 12px 20px 12px 50px;
        border-radius: 15px;
        border: 2px solid #fff3f0;
        background: #fffbf9;
        font-weight: 600;
        outline: none;
        transition: 0.3s;
        box-sizing: border-box;
    }
    .search-input:focus { border-color: var(--primary); background: white; }
    .search-icon { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: var(--primary); }

    /* --- Table Design --- */
    .table-eal { width: 100%; border-collapse: collapse; }
    .table-eal thead th {
        background: #fffaf8;
        padding: 18px 20px;
        text-align: left;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--secondary);
        border-bottom: 2px solid #fff3f0;
    }

    .table-eal tbody td { padding: 18px 20px; border-bottom: 1px solid #fff3f0; color: var(--text-main); }
    .trx-id { font-weight: 800; color: var(--secondary); }
    .customer-name { font-weight: 700; }
    .total-price { font-weight: 800; color: #444; }

    /* --- Badges & Buttons --- */
    .status-badge { padding: 6px 14px; border-radius: 12px; font-size: 11px; font-weight: 800; display: inline-block; }
    .status-done { background: #e8f5e9; color: #2e7d32; }
    .status-pending { background: #fff3e0; color: #ef6c00; }

    .btn-detail {
        color: var(--primary);
        font-weight: 700;
        text-decoration: none;
        padding: 6px 15px;
        border-radius: 10px;
        transition: 0.3s;
        border: 1px solid var(--primary);
    }
    .btn-detail:hover { background: var(--primary); color: white; }
    .empty-state { text-align: center; padding: 50px !important; color: #a1887f; }

    /* --- Pagination --- */
    .eal-pagination-container { padding: 20px 25px; display: flex; justify-content: space-between; align-items: center; background: #fffaf8; }
    .page-info { font-size: 0.85rem; color: #a1887f; font-weight: 600; }
    .page-btn {
        width: 35px; height: 35px; margin: 0 4px; border-radius: 10px; border: 1px solid #eee;
        background: white; font-weight: 700; cursor: pointer; transition: 0.3s;
    }
    .page-btn.active { background: var(--secondary); color: white; border-color: var(--secondary); }

    /* --- MOBILE MODE --- */
    @media (max-width: 768px) {
        .header-section { flex-direction: column; align-items: flex-start; gap: 15px; }
        
        .table-eal thead { display: none; } /* Sembunyikan header tabel di mobile */
        
        .table-eal tbody tr {
            display: block;
            padding: 20px;
            border-bottom: 8px solid #fff3f0;
        }

        .table-eal tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border: none;
            text-align: right;
        }

        .table-eal tbody td::before {
            content: attr(data-label);
            float: left;
            font-weight: 700;
            color: #a1887f;
            text-transform: uppercase;
            font-size: 0.7rem;
        }

        /* Memberi label manual via pseudo-element jika diperlukan, atau restruktur HTML */
        /* Alternatif: Kita buat td tetap tapi style-nya tumpuk */
        .table-eal td { display: block; text-align: left; padding: 5px 0; }
        .trx-id { font-size: 1.1rem; }
        .btn-detail { display: block; text-align: center; margin-top: 10px; }
        
        .eal-pagination-container { flex-direction: column; gap: 15px; text-align: center; }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('tableBody');
    const allRows = Array.from(tableBody.getElementsByClassName('table-row'));
    const paginationControls = document.getElementById('paginationControls');
    const pageInfo = document.getElementById('pageInfo');
    const totalDisplay = document.getElementById('totalCount');
    
    let filteredRows = allRows;
    let currentPage = 1;
    const rowsPerPage = 5;

    function initTable() {
        const searchTerm = searchInput.value.toLowerCase();
        filteredRows = allRows.filter(row => row.getAttribute('data-search').includes(searchTerm));
        totalDisplay.innerText = filteredRows.length;
        currentPage = 1;
        renderTable();
    }

    function renderTable() {
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        allRows.forEach(row => row.style.display = 'none');
        const currentRows = filteredRows.slice(start, end);
        currentRows.forEach(row => {
            row.style.display = (window.innerWidth <= 768) ? 'block' : 'table-row';
        });
        renderControls();
        pageInfo.innerText = filteredRows.length > 0 
            ? `Data ${start + 1}-${Math.min(end, filteredRows.length)} dari ${filteredRows.length}`
            : "Data tidak ditemukan";
    }

    function renderControls() {
        paginationControls.innerHTML = '';
        const pageCount = Math.ceil(filteredRows.length / rowsPerPage);
        if (pageCount <= 1) return;
        for (let i = 1; i <= pageCount; i++) {
            const btn = document.createElement('button');
            btn.className = `page-btn ${i === currentPage ? 'active' : ''}`;
            btn.innerText = i;
            btn.onclick = () => { currentPage = i; renderTable(); window.scrollTo({ top: 0, behavior: 'smooth' }); };
            paginationControls.appendChild(btn);
        }
    }

    searchInput.addEventListener('input', initTable);
    initTable();
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/egdrga/Documents/laravel/ealnya/ealnya/resources/views/admin/mutasi/index.blade.php ENDPATH**/ ?>