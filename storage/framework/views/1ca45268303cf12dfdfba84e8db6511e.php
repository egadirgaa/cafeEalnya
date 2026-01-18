<?php $__env->startSection('title', 'Edit Menu - ' . $menu->nama_menu); ?>

<?php $__env->startSection('content'); ?>
<div class="header-section">
    <h2 class="title">Edit Menu 🍰</h2>
    <p class="subtitle">Perbarui detail menu untuk koleksi Cafe Ealnya.</p>
</div>

<div class="edit-container">
    <div class="box form-card">
        <form method="POST" action="<?php echo e(route('admin.menu.update', $menu->id)); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <div class="grid-form">
                <div class="field full-width">
                    <label>Nama Menu</label>
                    <input type="text" name="nama_menu" value="<?php echo e(old('nama_menu', $menu->nama_menu)); ?>" required>
                    <?php $__errorArgs = ['nama_menu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="error-text"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="field">
                    <label>Kategori</label>
                    <select name="kategori" required>
                        <option value="minuman" <?php echo e($menu->kategori == 'minuman' ? 'selected' : ''); ?>>☕ Minuman</option>
                        <option value="makanan" <?php echo e($menu->kategori == 'makanan' ? 'selected' : ''); ?>>🍛 Makanan</option>
                        <option value="cemilan" <?php echo e($menu->kategori == 'cemilan' ? 'selected' : ''); ?>>🍰 Cemilan</option>
                    </select>
                </div>

                <div class="field">
                    <label>Stok</label>
                    <input type="number" name="stok" value="<?php echo e(old('stok', $menu->stok)); ?>" required>
                </div>

                <div class="field full-width">
                    <label>Harga (Rp)</label>
                    <input type="number" name="harga" value="<?php echo e(old('harga', $menu->harga)); ?>" required>
                </div>

                <div class="field full-width">
                    <label>Ganti Foto Menu <small class="hint">(Kosongkan jika tidak diganti)</small></label>
                    <input type="file" name="gambar" id="imageInput" accept="image/*">
                    <?php $__errorArgs = ['gambar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="error-text"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="action-buttons">
                <button type="submit" class="btn-save">Perbarui Menu</button>
                <a href="<?php echo e(route('admin.menu.index')); ?>" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>

    <div class="box preview-card">
        <h3 class="preview-title">Preview Gambar</h3>
        <div id="previewContainer" class="image-frame">
            <?php
                $imagePath = str_contains($menu->gambar, 'menu/') ? asset('storage/' . $menu->gambar) : asset('storage/menu/' . $menu->gambar);
            ?>
            <img id="imagePreview" src="<?php echo e($imagePath); ?>" alt="Preview">
        </div>
        <p class="preview-hint">Tampilan saat ini. Pilih file baru untuk mengubah gambar.</p>
    </div>
</div>

<style>
    /* Layout Foundation */
    .header-section { margin-bottom: 30px; }
    .title { margin: 0; color: var(--text-main); font-size: 1.5rem; }
    .subtitle { color: #a1887f; margin-top: 5px; }

    .edit-container {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 30px;
        align-items: start;
    }

    /* Form Styles */
    .grid-form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    .full-width { grid-column: 1 / -1; }

    .field label { display: block; margin-bottom: 8px; font-weight: 600; color: #444; }
    .field input, .field select {
        width: 100%;
        padding: 12px;
        border-radius: 15px;
        border: 1px solid #eee;
        outline: none;
        font-family: inherit;
        box-sizing: border-box;
    }
    .field input[type="file"] { background: #fffaf8; }
    .hint { font-weight: 400; color: #a1887f; }
    .error-text { color: #e53935; display: block; margin-top: 5px; }

    /* Buttons */
    .action-buttons { margin-top: 30px; display: flex; gap: 15px; align-items: center; }
    .btn-save {
        background: var(--primary);
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.4s ease;
        box-shadow: 0 10px 20px rgba(255, 171, 145, 0.3);
    }
    .btn-save:hover { transform: translateY(-3px); filter: brightness(1.1); }
    .btn-cancel { text-decoration: none; color: #a1887f; font-weight: 600; transition: 0.3s; }
    .btn-cancel:hover { color: #e53935; }

    /* Preview Card */
    .preview-card { text-align: center; position: sticky; top: 40px; }
    .preview-title { margin-top: 0; font-size: 1rem; color: var(--secondary); margin-bottom: 15px; }
    .image-frame {
        width: 100%;
        height: 250px;
        border-radius: 20px;
        border: 3px dashed #ffab91;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: #fffaf8;
    }
    .image-frame img { width: 100%; height: 100%; object-fit: cover; }
    .preview-hint { font-size: 0.8rem; color: #a1887f; margin-top: 15px; }

    /* --- RESPONSIVE / MOBILE MODE --- */
    @media (max-width: 768px) {
        .edit-container {
            grid-template-columns: 1fr; /* Stack vertical */
            gap: 20px;
        }

        .preview-card {
            order: -1;
            position: static;
        }

        .grid-form {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
            width: 100%;
        }

        .btn-save { width: 100%; order: 1; }
        .btn-cancel { order: 2; width: 100%; text-align: center; }
        
        .image-frame { height: 200px; }
    }
</style>

<script>
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');

    imageInput.onchange = evt => {
        const [file] = imageInput.files;
        if (file) {
            imagePreview.src = URL.createObjectURL(file);
        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/egdrga/Documents/laravel/ealnya/ealnya/resources/views/admin/menu/edit.blade.php ENDPATH**/ ?>