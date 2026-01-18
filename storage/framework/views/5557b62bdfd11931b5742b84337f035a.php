<?php $__env->startSection('title', 'Detail Transaksi #' . $transaksi->id); ?>

<?php $__env->startSection('content'); ?>
<style>
    .detail-wrapper {
        max-width: 900px;
        margin: 0 auto;
        animation: slideUp 0.6s var(--cb-bounce);
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .invoice-card {
        background: white;
        border-radius: 30px;
        box-shadow: 0 20px 50px rgba(141, 110, 99, 0.05);
        border: 2px dashed #fce4ec;
        overflow: hidden;
        position: relative;
    }

    /* Dekorasi Struk di Atas */
    .invoice-card::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 8px;
        background: repeating-linear-gradient(45deg, var(--primary), var(--primary) 10px, var(--secondary) 10px, var(--secondary) 20px);
    }

    .invoice-header {
        padding: 40px;
        text-align: center;
        background: #fffbf9;
        border-bottom: 2px dashed #fce4ec;
    }

    .invoice-header h2 {
        color: var(--secondary);
        font-weight: 700;
        margin: 0;
        font-size: 1.8rem;
    }

    .trx-id {
        background: var(--primary);
        color: white;
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 700;
        display: inline-block;
        margin-top: 10px;
    }

    .invoice-body { padding: 40px; }

    .info-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    .info-box label {
        display: block;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #a1887f;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .info-box p {
        color: var(--text-main);
        font-weight: 700;
        font-size: 1.05rem;
        margin: 0;
    }

    .status-badge {
        padding: 6px 16px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 700;
        display: inline-block;
    }
    .status-selesai { background: #e8f5e9; color: #2e7d32; }
    .status-pending { background: #fff3e0; color: #ef6c00; }

    /* Table Styling */
    .item-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .item-table th {
        padding: 15px;
        color: var(--secondary);
        font-weight: 700;
        text-align: left;
        border-bottom: 2px solid #fff3f0;
    }

    .item-table td {
        padding: 15px;
        background: #fffbf9;
        border: none;
    }

    .item-table tr td:first-child { border-radius: 15px 0 0 15px; }
    .item-table tr td:last-child { border-radius: 0 15px 15px 0; }

    .item-name { color: var(--text-main); font-weight: 700; }

    .total-section {
        margin-top: 30px;
        padding: 25px;
        background: linear-gradient(135deg, #fff3f0, #fff9f0);
        border-radius: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .total-label { font-weight: 700; color: #a1887f; }
    .total-amount { font-size: 1.5rem; font-weight: 800; color: var(--secondary); }

    .action-bar {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 30px;
    }

    .btn-action {
        padding: 12px 25px;
        border-radius: 15px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s var(--cb-bounce);
        border: none;
        text-decoration: none;
    }

    .btn-print { background: var(--primary); color: white; }
    .btn-print:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(255, 171, 145, 0.3); }

    .btn-back { background: #fce4ec; color: var(--secondary); }
    .btn-back:hover { background: var(--secondary); color: white; }

    @media print {
        .sidebar, .hamburger-btn, .action-bar, .btn-back-mutasi { display: none !important; }
        .main-content { margin: 0; padding: 0; }
        .invoice-card { box-shadow: none; border: 1px solid #eee; }
        body { background: white; }
    }
</style>

<div class="detail-wrapper">
    <div class="invoice-card">
        <div class="invoice-header">
            <h2>Ealnya Cafe</h2>
            <p style="color: #a1887f; margin: 5px 0;">Terima kasih sudah mampir! ✨</p>
            <div class="trx-id">Nota #TRX<?php echo e(str_pad($transaksi->id, 5, '0', STR_PAD_LEFT)); ?></div>
        </div>

        <div class="invoice-body">
            <div class="info-section">
                <div class="info-box">
                    <label>Pelanggan</label>
                    <p><?php echo e($transaksi->user->name ?? 'Teman Ealnya'); ?></p>
                </div>
                <div class="info-box">
                    <label>Tanggal</label>
                    <p><?php echo e(\Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y, H:i')); ?></p>
                </div>
                <div class="info-box">
                    <label>Status Pesanan</label>
                    <div>
                        <span class="status-badge <?php echo e($transaksi->status == 'selesai' ? 'status-selesai' : 'status-pending'); ?>">
                            <?php echo e(ucfirst($transaksi->status)); ?>

                        </span>
                    </div>
                </div>
            </div>

            <table class="item-table">
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th style="text-align: center;">Qty</th>
                        <th style="text-align: right;">Harga</th>
                        <th style="text-align: right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $transaksi->pesanans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="item-name">☕ <?php echo e($item->nama_menu); ?></td>
                        <td style="text-align: center;">x<?php echo e($item->qty); ?></td>
                        <td style="text-align: right;"><?php echo e(number_format($item->harga, 0, ',', '.')); ?></td>
                        <td style="text-align: right; font-weight: 700;"><?php echo e(number_format($item->total, 0, ',', '.')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <div class="total-section">
                <div class="total-label">Total yang dibayar</div>
                <div class="total-amount">Rp <?php echo e(number_format($transaksi->total_harga, 0, ',', '.')); ?></div>
            </div>
        </div>
    </div>

    <div class="action-bar no-print">
        <a href="<?php echo e(route('admin.mutasi.index')); ?>" class="btn-action btn-back">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Daftar Transaksi
        </a>
        <button onclick="window.print()" class="btn-action btn-print">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
            Cetak Nota
        </button>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/egdrga/Documents/laravel/ealnya/ealnya/resources/views/admin/mutasi/show.blade.php ENDPATH**/ ?>