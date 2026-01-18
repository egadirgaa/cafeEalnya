@extends('layouts.app')

@section('title', 'Keranjang Cantikmu - Cafe Ealnya')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    :root {
        --pink-3: #ff85a2;
        --pink-4: #f75c7e;
        --cb-bounce: cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .cart-wrapper { animation: fadeInUp 0.6s var(--cb-bounce); }

    .page-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .page-title h1 {
        margin: 0;
        font-size: 26px;
        font-weight: 900;
        color: var(--pink-4);
    }

    /* Cart Item Card */
    .cart-item {
        background: white;
        border-radius: 20px;
        padding: 15px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 8px 20px rgba(180, 0, 106, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.8);
        transition: 0.3s var(--cb-bounce);
    }

    .item-info { flex: 1; }
    .item-info h3 { margin: 0; font-size: 16px; color: #333; text-transform: capitalize; }
    .item-info p { margin: 4px 0 0; color: var(--pink-3); font-weight: 700; font-size: 14px; }

    /* Quantity Controls */
    .qty-controls {
        display: flex;
        align-items: center;
        background: #fff0f3;
        border-radius: 12px;
        padding: 4px;
        gap: 8px;
    }

    .btn-qty {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        border: none;
        background: white;
        color: var(--pink-4);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.2s;
        padding: 0;
    }

    .btn-qty:hover { background: var(--pink-4); color: white; }
    .btn-qty:disabled { opacity: 0.5; cursor: not-allowed; }

    .qty-number {
        font-weight: 800;
        color: var(--pink-4);
        min-width: 20px;
        text-align: center;
        font-size: 14px;
    }

    .subtotal-text {
        font-weight: 900;
        color: #333;
        min-width: 90px;
        text-align: right;
    }

    .btn-delete {
        background: #fff5f5;
        color: #ff4757;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-delete:hover { background: #ff4757; color: white; }

    /* Layouts lainnya sama seperti sebelumnya */
    .checkout-card { background: white; border-radius: 24px; padding: 20px; margin-top: 30px; border: 2px dashed var(--pink-3); }
    .summary-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .summary-row .total-price { font-size: 24px; font-weight: 900; color: var(--pink-4); }
    .action-group { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .btn-custom { padding: 14px; border-radius: 15px; border: none; font-weight: 800; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: 0.3s var(--cb-bounce); }
    .btn-outline { background: white; color: #666; border: 2px solid #eee; }
    .btn-checkout { background: linear-gradient(135deg, var(--pink-3), var(--pink-4)); color: white; width: 100%; }
    
    .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; min-height: 80vh; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(4px); display: none; align-items: center; justify-content: center; z-index: 1000; padding: 20px; }
    .modal-content { background: white; width: 100%; max-width: 450px; border-radius: 25px; padding: 25px; animation: modalPop 0.4s var(--cb-bounce); position: relative; }
    #successState { display: none; text-align: center; padding: 20px 0; }
    .check-icon { font-size: 80px; color: #40c057; animation: scaleIn 0.5s var(--cb-bounce); }
    
    .payment-options-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 15px; }
    .payment-radio { display: none; }
    .payment-label { border: 2px solid #f0f0f0; border-radius: 15px; padding: 12px; display: flex; flex-direction: column; align-items: center; gap: 5px; cursor: pointer; transition: 0.2s; }
    .payment-radio:checked + .payment-label { border-color: var(--pink-3); background: #fff9fb; }

    @keyframes scaleIn { from { transform: scale(0); } to { transform: scale(1); } }
    @keyframes modalPop { from { transform: scale(0.8); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="cart-wrapper">
    <div class="page-title">
        <span class="material-symbols-rounded" style="color: var(--pink-3); font-size: 32px;">shopping_basket</span>
        <h1>Keranjangku</h1>
    </div>

    <div id="cart-container">
        @if(count($keranjang) === 0)
            <div id="empty-cart" style="text-align: center; padding: 50px;">
                <span class="material-symbols-rounded" style="font-size: 80px; color: #eee;">production_quantity_limits</span>
                <p style="font-weight: 700; color: #888; margin-top: 15px;">Yah, keranjangmu masih kosong nih...</p>
                <a href="{{ route('customer.pesanan.menu') }}" class="btn-custom btn-checkout" style="display: inline-flex; margin-top: 10px; width: auto;">
                    Cari Menu Enak ✨
                </a>
            </div>
        @else
            <div class="cart-list">
                @foreach($keranjang as $id => $row)
                    <div class="cart-item" id="item-{{ $id }}">
                        <div class="item-info">
                            <h3>{{ $row['nama'] }}</h3>
                            <p>Rp {{ number_format($row['harga'], 0, ',', '.') }}</p>
                        </div>
                        
                        <div class="qty-controls">
                            <button class="btn-qty" onclick="updateQty('{{ $id }}', 'minus')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            </button>
                            <span class="qty-number" id="qty-val-{{ $id }}">{{ $row['qty'] }}</span>
                            <button class="btn-qty" onclick="updateQty('{{ $id }}', 'plus')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            </button>
                        </div>

                        <div class="subtotal-text" id="subtotal-{{ $id }}">
                            Rp {{ number_format($row['subtotal'], 0, ',', '.') }}
                        </div>

                        <button onclick="deleteItem('{{ $id }}')" class="btn-delete" title="Hapus">
                            <span class="material-symbols-rounded">delete</span>
                        </button>
                    </div>
                @endforeach
            </div>

            <div class="checkout-card">
                <div class="summary-row">
                    <span style="font-weight: 700; color: #666;">Total Pesanan</span>
                    <span class="total-price" id="grand-total">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="action-group">
                    <button onclick="clearCart()" class="btn-custom btn-outline">
                        <span class="material-symbols-rounded">delete_sweep</span> Kosongkan
                    </button>
                    <button type="button" class="btn-custom btn-checkout" onclick="openCheckoutModal()">
                        <span class="material-symbols-rounded">shopping_cart_checkout</span> Checkout
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
@include('components.checkout-modal', ['total' => $total])

<script>
    const csrfToken = "{{ csrf_token() }}";

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number).replace('IDR', 'Rp');
    }

    function updateQty(id, type) {
        fetch("{{ url('customer/keranjang/update') }}/" + id, {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrfToken },
            body: JSON.stringify({ type: type })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                document.getElementById(`qty-val-${id}`).innerText = data.item_qty;
                document.getElementById(`subtotal-${id}`).innerText = formatRupiah(data.item_subtotal);
                updateGrandTotal(data.grand_total);
                updateBadge(data.total_qty);
            } else if (data.message) {
                Swal.fire('Oops!', data.message, 'warning');
            }
        });
    }

    function deleteItem(id) {
        Swal.fire({
            title: 'Hapus item?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#f75c7e',
            confirmButtonText: 'Ya, Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("{{ url('customer/keranjang/hapus') }}/" + id, {
                    method: "POST",
                    headers: { "X-CSRF-TOKEN": csrfToken }
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        const element = document.getElementById(`item-${id}`);
                        element.style.transform = "translateX(100px)";
                        element.style.opacity = "0";
                        setTimeout(() => {
                            element.remove();
                            if(data.grand_total == 0) location.reload();
                            updateGrandTotal(data.grand_total);
                            updateBadge(data.total_qty);
                        }, 300);
                    }
                });
            }
        });
    }

    function clearCart() {
        Swal.fire({
            title: 'Kosongkan keranjang?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff4757',
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("{{ route('customer.pesanan.clear') }}", {
                    method: "POST",
                    headers: { "X-CSRF-TOKEN": csrfToken }
                }).then(() => location.reload());
            }
        });
    }

    function updateGrandTotal(total) {
        document.getElementById('grand-total').innerText = formatRupiah(total);
        const modalTotal = document.getElementById('modal-total');
        if(modalTotal) modalTotal.innerText = formatRupiah(total);
    }

    function updateBadge(count) {
        const badge = document.getElementById('cart-count');
        if(badge) {
            badge.innerText = count;
            badge.style.display = count > 0 ? 'flex' : 'none';
        }
    }
</script>
@endsection