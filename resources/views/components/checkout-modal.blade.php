<div id="checkoutModal" class="modal-overlay">
    <div class="modal-content">
        <div id="formState">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 style="margin: 0; font-size: 20px; color: var(--pink-4); font-weight: 900;">Konfirmasi Pesanan</h2>
                <button onclick="closeCheckoutModal()" style="background:none; border:none; font-size:24px; color:#ccc; cursor:pointer;">&times;</button>
            </div>
            
            <form id="checkoutForm" onsubmit="handleCheckout(event)">
                @csrf
                @guest
                    <div style="margin-bottom: 15px;">
                        <label style="display:block; margin-bottom:8px; font-weight:700; color:#555;">Siapa nama kamu? ✨</label>
                        <input type="text" name="name" required placeholder="Contoh: Mulyono" style="width:100%; padding:12px; border-radius:12px; border:2px solid #eee; outline:none;">
                    </div>
                @endguest

                <p style="font-weight: 700; color: #555; margin-bottom: 10px;">Pilih Metode Pembayaran:</p>
                <div class="payment-options-grid">
                    <input type="radio" name="metode" value="QRIS" id="pay-qris" class="payment-radio" checked onchange="switchPaymentInfo('qris')">
                    <label for="pay-qris" class="payment-label">
                        <span class="material-symbols-rounded">qr_code_2</span>
                        <span style="font-size: 11px; font-weight: 700;">QRIS</span>
                    </label>
                    
                    <input type="radio" name="metode" value="Transfer" id="pay-bank" class="payment-radio" onchange="switchPaymentInfo('bank')">
                    <label for="pay-bank" class="payment-label">
                        <span class="material-symbols-rounded">account_balance_wallet</span>
                        <span style="font-size: 11px; font-weight: 700;">Transfer</span>
                    </label>

                    <input type="radio" name="metode" value="Tunai" id="pay-cash" class="payment-radio" onchange="switchPaymentInfo('tunai')">
                    <label for="pay-cash" class="payment-label">
                        <span class="material-symbols-rounded">payments</span>
                        <span style="font-size: 11px; font-weight: 700;">Tunai</span>
                    </label>
                </div>

                <div id="payment-info-box" style="margin-top: 15px; padding: 15px; background: #fafafa; border-radius: 15px; border: 1px solid #eee;">
                    
                    <div id="info-qris" class="payment-detail">
                        <div style="text-align: center;">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=CAFE-EAL-{{ $total ?? 0 }}" alt="QRIS" style="width: 130px; border-radius: 10px; border: 4px solid white; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                            <p style="font-size: 11px; color: #888; margin-top: 8px;">Scan QRIS di atas untuk membayar cepat ✨</p>
                        </div>
                    </div>

                    <div id="info-bank" class="payment-detail" style="display: none;">
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 10px; border-radius: 10px;">
                                <div>
                                    <p style="font-size: 10px; margin: 0; color: #aaa; font-weight: 700;">BCA - Admin</p>
                                    <p style="font-size: 14px; margin: 0; font-weight: 900; color: #333;">1234 567 890</p>
                                </div>
                                <button type="button" onclick="copyText('1234567890')" style="background: var(--pink-3); color: white; border: none; padding: 5px 10px; border-radius: 8px; font-size: 10px; font-weight: 800; cursor: pointer;">SALIN</button>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 10px; border-radius: 10px;">
                                <div>
                                    <p style="font-size: 10px; margin: 0; color: #aaa; font-weight: 700;">DANA/GOPAY</p>
                                    <p style="font-size: 14px; margin: 0; font-weight: 900; color: #333;">0812 3456 789</p>
                                </div>
                                <button type="button" onclick="copyText('08123456789')" style="background: var(--pink-3); color: white; border: none; padding: 5px 10px; border-radius: 8px; font-size: 10px; font-weight: 800; cursor: pointer;">SALIN</button>
                            </div>
                        </div>
                    </div>

                    <div id="info-tunai" class="payment-detail" style="display: none;">
                        <p style="text-align: center; font-size: 12px; color: #666; margin: 0; padding: 10px;">
                            Silahkan bayar langsung di kasir setelah pesanan dibuat ya! <br>
                            atau Siapkan uang anda saat karyawan memberikan pesanan! 😊
                        </p>
                    </div>

                </div>

                <div style="background: #fff0f3; padding: 15px; border-radius: 15px; display: flex; justify-content: space-between; align-items: center; margin: 20px 0;">
                    <span style="font-weight: 700; color: #666;">Total:</span>
                    <span style="font-weight: 900; color: var(--pink-4); font-size: 1.2rem;" id="modal-total">
                        Rp {{ number_format($total ?? 0, 0, ',', '.') }}
                    </span>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <button type="button" class="btn-custom btn-outline" onclick="closeCheckoutModal()">Batal</button>
                    <button type="submit" id="btnSubmit" class="btn-custom btn-checkout">Buat Pesanan</button>
                </div>
            </form>
        </div>

        <div id="successState" style="display: none; text-align: center; padding: 20px;">
            <span class="material-symbols-rounded check-icon" style="font-size: 80px; color: #40c057;">check_circle</span>
            <h2 style="color: #333; font-weight: 900; margin: 10px 0 5px;">Pesanan Diterima!</h2>
            <p style="color: #888;">Segera kami siapkan untukmu... ✨</p>
        </div>
    </div>
</div>
<style>
    .modal-overlay { 
        position: fixed;
        top: 0; 
        left: 0; 
        width: 100%; 
        min-height: 80vh; 
        height: 100%; 
        background: rgba(0,0,0,0.4); 
        backdrop-filter: blur(4px); 
        display: none; 
        align-items: center; 
        justify-content: center; 
        z-index: 1000; 
        padding: 20px; 
    }
    .modal-content { 
        background: white; 
        width: 100%; 
        max-width: 450px; 
        border-radius: 25px; 
        padding: 25px; animation: modalPop 0.4s var(--cb-bounce); 
        position: relative; 
    }
    #successState { 
        display: none; 
        text-align: center; 
        padding: 20px 0; 
    }
    .check-icon { 
        ont-size: 80px; 
        color: #40c057; 
        animation: scaleIn 0.5s var(--cb-bounce); 
    }

    .payment-options-grid { 
        display: grid; 
        grid-template-columns: 1fr 1fr; 
        gap: 10px; 
        margin-top: 15px; 
    }
    .payment-radio { 
        display: none; 
    }
    .payment-label { 
        border: 2px solid #f0f0f0; 
        border-radius: 15px; 
        padding: 12px; 
        display: flex; 
        flex-direction: column; 
        align-items: center; 
        gap: 5px; 
        cursor: pointer; 
        transition: 0.2s; 
    }
    .payment-radio:checked + .payment-label { border-color: var(--pink-3); background: #fff9fb; }

    @keyframes scaleIn { from { transform: scale(0); } to { transform: scale(1); } }
    @keyframes modalPop { from { transform: scale(0.8); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

</style>

<script>
    function openCheckoutModal() { 
        document.getElementById('checkoutModal').style.display = 'flex'; 
    }

    function closeCheckoutModal() { 
        document.getElementById('checkoutModal').style.display = 'none'; 
    }

    function switchPaymentInfo(type) {
        document.querySelectorAll('.payment-detail').forEach(el => el.style.display = 'none');
        document.getElementById('info-' + type).style.display = 'block';
    }

    function copyText(text) {
        navigator.clipboard.writeText(text);
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Berhasil disalin!',
            showConfirmButton: false,
            timer: 1500
        });
    }
    
    function handleCheckout(e) {
        e.preventDefault();
        const btn = document.getElementById('btnSubmit');
        const originalText = btn.innerHTML;
        
        btn.innerHTML = `Memproses...`;
        btn.disabled = true;

        fetch("{{ route('customer.pesanan.prosesCheckout') }}", {
            method: "POST",
            body: new FormData(e.target),
            headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" }
        })
        .then(res => {
            if(res.ok) {
                document.getElementById('formState').style.display = 'none';
                document.getElementById('successState').style.display = 'block';
                setTimeout(() => window.location.href = "{{ route('customer.mutasi.index') }}", 2000);
            } else {
                btn.disabled = false;
                btn.innerHTML = originalText;
                Swal.fire('Oops!', 'Terjadi kesalahan, silakan coba lagi.', 'error');
            }
        });
    }
</script>