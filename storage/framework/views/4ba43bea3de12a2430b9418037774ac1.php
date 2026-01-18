<?php $__env->startSection('title', 'Riwayat Pesananku - Cafe Ealnya'); ?>

<?php $__env->startSection('content'); ?>
<style>
    :root {
        --pink-3: #ff85a2;
        --pink-4: #f72585;
        --cb-bounce: cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .mutasi-wrapper { animation: fadeInUp 0.6s var(--cb-bounce); }
    
    .history-card {
        background-color: rgb(255, 255, 255);
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        border-left: 5px solid var(--pink-3);
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .history-card:hover {
        background-color: rgb(221, 221, 221);
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.1);
    }

    .status-badge {
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
    }
    .status-pending { background: #fff4e6; color: #fd7e14; }
    .status-success { background: #ebfbee; color: #40c057; }

    .modal-overlay {
        position: fixed;
        top: 0; 
        left: 0; 
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        backdrop-filter: blur(4px);
    }

    .modal-content {
        background: white;
        width: 90%;
        max-width: 450px;
        border-radius: 24px;
        padding: 25px;
        position: relative;
        animation: modalSlideUp 0.3s ease-out;
    }

    @keyframes modalSlideUp {
        from { transform: translateY(50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .close-modal {
        position: absolute;
        top: 15px; right: 15px;
        background: #f8f9fa;
        border: none;
        border-radius: 50%;
        width: 32px; height: 32px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 14px;
    }

    .divider {
        border-top: 1px dashed #ddd;
        margin: 15px 0;
    }
</style>

<div class="mutasi-wrapper">
    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 25px;">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--pink-3)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h1 style="margin:0; font-size: 24px; font-weight: 900; color: var(--pink-4);">Riwayat Pesanan</h1>
    </div>

    <?php if($riwayat->isEmpty()): ?>
        <div style="text-align: center; padding: 50px;">
            <p style="color: #888;">Belum ada pesanan nih. Yuk jajan dulu!</p>
            <a href="<?php echo e(route('customer.pesanan.menu')); ?>" class="btn-custom" style="text-decoration: none; background: var(--pink-3); color: white; padding: 10px 20px; border-radius: 10px; display: inline-block;">Lihat Menu</a>
        </div>
    <?php else: ?>
        <?php $__currentLoopData = $riwayat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="history-card" onclick="openDetail('<?php echo e($trx->id); ?>')">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                    <div>
                        <div style="font-size: 11px; color: #999;"><?php echo e(\Carbon\Carbon::parse($trx->tanggal)->format('d M Y, H:i')); ?></div>
                        <div style="font-weight: 800; color: #333;">Order #TRX-<?php echo e($trx->id); ?></div>
                    </div>
                    <span class="status-badge <?php echo e($trx->status == 'Menunggu Pembayaran' ? 'status-pending' : 'status-success'); ?>">
                        <?php echo e($trx->status); ?>

                    </span>
                </div>

                <div style="font-size: 13px; color: #666;">
                    <?php echo e($trx->pesanans->first()->nama_menu); ?> 
                    <?php if($trx->pesanans->count() > 1): ?>
                        <span style="color: var(--pink-3);">+<?php echo e($trx->pesanans->count() - 1); ?> item lainnya</span>
                    <?php endif; ?>
                </div>

                <div style="display: flex; justify-content: space-between; margin-top: 15px;">
                    <span style="font-size: 14px; font-weight: 600;">Total</span>
                    <span style="font-weight: 900; color: var(--pink-4);">
                        Rp <?php echo e(number_format($trx->total_harga, 0, ',', '.')); ?>

                    </span>
                </div>
            </div>

            <template id="data-<?php echo e($trx->id); ?>">
                <div class="modal-body">
                    <h3 style="margin-bottom: 5px; font-weight: 900;">Detail Pesanan</h3>
                    <p style="font-size: 12px; color: #999; margin-bottom: 20px;">#TRX-<?php echo e($trx->id); ?> • <?php echo e($trx->tanggal); ?></p>
                    
                    <div style="margin-bottom: 20px;">
                        <p style="font-weight: 700; font-size: 14px; margin-bottom: 10px;">Item yang dibeli:</p>
                        <?php $__currentLoopData = $trx->pesanans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="detail-row">
                            <span><?php echo e($item->qty); ?>x <?php echo e($item->nama_menu); ?></span>
                            <span style="font-weight: 600;">Rp <?php echo e(number_format($item->total, 0, ',', '.')); ?></span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="divider"></div>

                    <div class="detail-row">
                        <span>Metode Pembayaran</span>
                        <span style="font-weight: 700; color: #333;"><?php echo e($trx->metode_pembayaran ?? 'Cash'); ?></span>
                    </div>
                    <div class="detail-row">
                        <span>Status</span>
                        <span class="status-badge <?php echo e($trx->status == 'Menunggu Pembayaran' ? 'status-pending' : 'status-success'); ?>"><?php echo e($trx->status); ?></span>
                    </div>

                    <div class="divider"></div>

                    <div class="detail-row" style="font-size: 18px;">
                        <span style="font-weight: 800;">Total Bayar</span>
                        <span style="font-weight: 900; color: var(--pink-4);">Rp <?php echo e(number_format($trx->total_harga, 0, ',', '.')); ?></span>
                    </div>
                </div>
            </template>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</div>

<div id="modalDetail" class="modal-overlay" onclick="closeModal(event)">
    <div class="modal-content" onclick="event.stopPropagation()">
        <button class="close-modal" onclick="closeModal()">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
        <div id="modalContentInner">
            </div>
        <button onclick="closeModal()" style="width: 100%; margin-top: 20px; padding: 12px; border: none; border-radius: 12px; background: #f8f9fa; font-weight: 700; cursor: pointer;">Tutup</button>
    </div>
</div>

<script>
    function openDetail(id) {
        const modal = document.getElementById('modalDetail');
        const contentInner = document.getElementById('modalContentInner');
        const template = document.getElementById('data-' + id);
        
        contentInner.innerHTML = template.innerHTML;
        
        modal.style.display = 'flex';
        document.body.style.overflow = 'auto';
    }

    function closeModal(event) {
        const modal = document.getElementById('modalDetail');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    window.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeModal();
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/egdrga/Documents/laravel/ealnya/ealnya/resources/views/customer/mutasi/index.blade.php ENDPATH**/ ?>