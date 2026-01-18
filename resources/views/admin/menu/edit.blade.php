@extends('layouts.admin')

@section('title', 'Edit Menu - ' . $menu->nama_menu)

@section('content')
<div class="header-section">
    <h2 class="title">Edit Menu 🍰</h2>
    <p class="subtitle">Perbarui detail menu untuk koleksi Cafe Ealnya.</p>
</div>

<div class="edit-container">
    <div class="box form-card">
        <form method="POST" action="{{ route('admin.menu.update', $menu->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid-form">
                <div class="field full-width">
                    <label>Nama Menu</label>
                    <input type="text" name="nama_menu" value="{{ old('nama_menu', $menu->nama_menu) }}" required>
                    @error('nama_menu') <small class="error-text">{{ $message }}</small> @enderror
                </div>

                <div class="field">
                    <label>Kategori</label>
                    <select name="kategori" required>
                        <option value="minuman" {{ $menu->kategori == 'minuman' ? 'selected' : '' }}>☕ Minuman</option>
                        <option value="makanan" {{ $menu->kategori == 'makanan' ? 'selected' : '' }}>🍛 Makanan</option>
                        <option value="cemilan" {{ $menu->kategori == 'cemilan' ? 'selected' : '' }}>🍰 Cemilan</option>
                    </select>
                </div>

                <div class="field">
                    <label>Stok</label>
                    <input type="number" name="stok" value="{{ old('stok', $menu->stok) }}" required>
                </div>

                <div class="field full-width">
                    <label>Harga (Rp)</label>
                    <input type="number" name="harga" value="{{ old('harga', $menu->harga) }}" required>
                </div>

                <div class="field full-width">
                    <label>Ganti Foto Menu <small class="hint">(Kosongkan jika tidak diganti)</small></label>
                    <input type="file" name="gambar" id="imageInput" accept="image/*">
                    @error('gambar') <small class="error-text">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="action-buttons">
                <button type="submit" class="btn-save">Perbarui Menu</button>
                <a href="{{ route('admin.menu.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>

    <div class="box preview-card">
        <h3 class="preview-title">Preview Gambar</h3>
        <div id="previewContainer" class="image-frame">
            @php
                $imagePath = str_contains($menu->gambar, 'menu/') ? asset('storage/' . $menu->gambar) : asset('storage/menu/' . $menu->gambar);
            @endphp
            <img id="imagePreview" src="{{ $imagePath }}" alt="Preview">
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
@endsection