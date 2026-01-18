@extends('layouts.admin')

@section('title', 'Tambah Menu Baru')

@section('content')
<div class="header-section">
    <h2 class="title">Tambah Menu Baru 🍰</h2>
    <p class="subtitle">Lengkapi detail menu untuk menambah koleksi Cafe Ealnya.</p>
</div>

<div class="main-container">
    <div class="box form-section">
        <form method="POST" action="{{ route('admin.menu.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid-form">
                <div class="field full-width">
                    <label>Nama Menu</label>
                    <input type="text" name="nama_menu" placeholder="Masukan nama menu..." required>
                </div>

                <div class="field">
                    <label>Kategori</label>
                    <select name="kategori" required>
                        <option value="minuman">☕ Minuman</option>
                        <option value="makanan">🍛 Makanan</option>
                        <option value="cemilan">🍰 Cemilan</option>
                    </select>
                </div>

                <div class="field">
                    <label>Stok Awal</label>
                    <input type="number" name="stok" placeholder="0" required>
                </div>

                <div class="field full-width">
                    <label>Harga (Rp)</label>
                    <input type="number" name="harga" placeholder="Contoh: 25000" required>
                </div>

                <div class="field full-width">
                    <label>Foto Menu</label>
                    <input type="file" name="gambar" id="imageInput" accept="image/*" required>
                </div>
            </div>

            <div class="action-area">
                <button type="submit" class="btn-save">Simpan Menu</button>
                <a href="{{ route('admin.menu.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>

    <div class="box preview-section">
        <h3 class="preview-title">Preview Gambar</h3>
        <div id="previewContainer" class="preview-box">
            <span id="previewPlaceholder">Belum ada foto terpilih</span>
            <img id="imagePreview" src="#" alt="Preview">
        </div>
        <p class="preview-text">Pastikan foto menu terlihat lezat agar pelanggan tertarik!</p>
    </div>
</div>

<style>
    .header-section { margin-bottom: 30px; }
    .title { margin: 0; color: var(--text-main); }
    .subtitle { color: #a1887f; margin-top: 5px; }

    .main-container {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 30px;
        align-items: start;
    }

    .grid-form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .full-width { grid-column: 1 / -1; }

    .field label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #444;
    }

    .field input, .field select {
        width: 100%;
        padding: 12px;
        border-radius: 15px;
        border: 1px solid #eee;
        outline: none;
        font-family: inherit;
        box-sizing: border-box;
    }

    .field input[type="file"] {
        background: #fffaf8;
        padding: 10px;
    }

    .action-area {
        margin-top: 30px;
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .btn-save {
        background: var(--primary);
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.4s var(--cb-bounce);
        box-shadow: 0 10px 20px rgba(255, 171, 145, 0.3);
    }

    .btn-save:hover {
        transform: scale(1.05) translateY(-3px);
        filter: brightness(1.1);
    }

    .btn-cancel {
        text-decoration: none;
        color: #a1887f;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-cancel:hover { color: #e53935; }

    input:focus, select:focus {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 4px rgba(255,171,145,0.1);
    }

    .preview-section {
        text-align: center;
        position: sticky;
        top: 40px;
    }

    .preview-title {
        margin-top: 0;
        font-size: 1rem;
        color: var(--secondary);
    }

    .preview-box {
        width: 100%;
        height: 250px;
        border-radius: 20px;
        border: 3px dashed #ffab91;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: #fffaf8;
        margin-top: 15px;
    }

    #previewPlaceholder { color: #ffab91; font-size: 0.9rem; }
    #imagePreview { display: none; width: 100%; height: 100%; object-fit: cover; }
    .preview-text { font-size: 0.8rem; color: #a1887f; margin-top: 15px; }

    /* Mobile Mode */
    @media (max-width: 768px) {
        .main-container {
            grid-template-columns: 1fr;
        }

        .preview-section {
            order: -1;
            position: static;
            margin-bottom: 20px;
        }

        .grid-form {
            grid-template-columns: 1fr;
        }

        .action-area {
            flex-direction: column;
        }

        .btn-save, .btn-cancel {
            width: 100%;
            text-align: center;
        }
    }
    /* Success Toast Styles */
    .toast-container {
        position: fixed;
        top: 20px;
        right: -400px; /* Sembunyi di luar layar kanan */
        background: white;
        padding: 15px 25px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border-left: 5px solid #4CAF50;
        z-index: 9999;
        transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        display: flex;
        align-items: center;
    }

    .toast-container.active {
        right: 40px;
    }

    .toast-content {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .toast-icon {
        font-size: 1.5rem;
    }

    .toast-message {
        display: flex;
        flex-direction: column;
    }

    .toast-title {
        font-weight: 700;
        color: #2e7d32;
    }

    #toastText {
        font-size: 0.85rem;
        color: #666;
    }
</style>

<script>
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewPlaceholder = document.getElementById('previewPlaceholder');

    imageInput.onchange = evt => {
        const [file] = imageInput.files;
        if (file) {
            imagePreview.src = URL.createObjectURL(file);
            imagePreview.style.display = 'block';
            previewPlaceholder.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            const toast = document.getElementById('successToast');
            const toastText = document.getElementById('toastText');
            
            toastText.innerText = "{{ session('success') }}";
            
            toast.classList.add('active');

            setTimeout(() => {
                toast.classList.remove('active');
            }, 4000);
        @endif
    });
</script>

<div id="successToast" class="toast-container">
    <div class="toast-content">
        <div class="toast-icon">✅</div>
        <div class="toast-message">
            <span class="toast-title">Berhasil!</span>
            <span id="toastText">Data berhasil disimpan.</span>
        </div>
    </div>
</div>
@endsection