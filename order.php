<?php
/**
 * Kaivalyamh Shuddh Pooja Spray - Order Confirmation Page
 */
if(!session_id()) session_start();

// Login check — login nahi hai to form.php pe bhejo
if(!isset($_SESSION['user_id'])){
    header("Location: form.php?redirect=order.php");
    exit;
}

$logged_in = true;
$user_name = $_SESSION['user_name'] ?? '';
$user_addr = $_SESSION['user_addr'] ?? '';
$user_id   = (int)($_SESSION['user_id'] ?? 0);

// DB se phone fetch karo
$user_phone = '';
$conn = mysqli_connect("localhost","root","","shudh_puja");
if($conn){
    $res = mysqli_query($conn, "SELECT phone FROM users WHERE id='$user_id'");
    if($row = mysqli_fetch_assoc($res)) $user_phone = $row['phone'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Order | Kaivalyamh Shuddh Pooja Spray</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Tiro+Devanagari+Hindi&family=Cormorant+Garamond:wght@300;400;600;700&display=swap"
        rel="stylesheet">
    <style>
    :root {
        --saffron: #FF6B00;
        --gold: #C9960C;
        --gold-light: #F2C94C;
        --deep-red: #6B1A1A;
        --cream: #FFF8EE;
        --brown: #3D1C00;
        --wa: #25D366;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        background: var(--cream);
        font-family: 'Cormorant Garamond', serif;
        color: var(--brown);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    body::before {
        content: 'ॐ';
        position: fixed;
        right: -4%;
        top: 50%;
        transform: translateY(-50%);
        font-size: 55vw;
        color: rgba(201, 150, 12, 0.04);
        font-family: 'Tiro Devanagari Hindi', serif;
        line-height: 1;
        pointer-events: none;
        z-index: 0;
    }

    /* NAV — same as cart.php */
    nav {
        position: sticky;
        top: 0;
        z-index: 100;
        background: rgba(255, 248, 238, 0.97);
        backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(201, 150, 12, 0.3);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 5%;
        height: 65px;
    }

    .nav-logo {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 900;
        color: var(--deep-red);
        text-decoration: none;
    }

    .nav-right {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .nav-back {
        text-decoration: none;
        color: var(--brown);
        font-size: 0.95rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: color 0.3s;
    }

    .nav-back:hover {
        color: var(--saffron);
    }

    /* PAGE */
    .page {
        position: relative;
        z-index: 1;
        flex: 1;
        padding: 40px 5%;
        max-width: 1100px;
        margin: 0 auto;
        width: 100%;
    }

    .page-header {
        margin-bottom: 32px;
        animation: fadeUp 0.6s ease both;
    }

    .page-header .label {
        font-size: 0.7rem;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--saffron);
        font-weight: 700;
        margin-bottom: 4px;
    }

    .page-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.8rem, 4vw, 2.8rem);
        color: var(--deep-red);
        font-weight: 900;
    }

    /* GRID */
    .order-layout {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 28px;
        align-items: start;
    }

    /* SECTION CARD — same as cart */
    .section-card {
        background: white;
        border: 1px solid rgba(201, 150, 12, 0.18);
        border-radius: 20px;
        padding: 28px;
        animation: fadeUp 0.7s ease both;
    }

    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.2rem;
        color: var(--deep-red);
        font-weight: 700;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* CART ITEMS — same styles as cart.php */
    .cart-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 0;
        border-bottom: 1px solid rgba(201, 150, 12, 0.12);
        animation: slideIn 0.35s ease both;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-15px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .ci-emoji {
        width: 48px;
        height: 48px;
        background: var(--cream);
        border: 1px solid rgba(201, 150, 12, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .ci-info {
        flex: 1;
    }

    .ci-name {
        font-family: 'Playfair Display', serif;
        font-size: 1rem;
        font-weight: 700;
        color: var(--deep-red);
    }

    .ci-sub {
        font-size: 0.8rem;
        color: #888;
        margin-top: 2px;
    }

    .ci-price {
        font-family: 'Playfair Display', serif;
        font-size: 1.05rem;
        font-weight: 900;
        color: var(--saffron);
        min-width: 56px;
        text-align: right;
    }

    /* EMPTY */
    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: #aaa;
    }

    .empty-state .ec-icon {
        font-size: 3rem;
        margin-bottom: 12px;
    }

    .empty-state p {
        font-size: 1rem;
        margin-bottom: 20px;
    }

    /* ADDRESS FORM */
    .addr-section {
        margin-top: 8px;
    }

    .addr-label {
        font-size: 0.7rem;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #888;
        font-weight: 700;
        margin-bottom: 6px;
        display: block;
    }

    .addr-section textarea {
        width: 100%;
        background: var(--cream);
        border: 1px solid rgba(201, 150, 12, 0.25);
        border-radius: 8px;
        padding: 10px 14px;
        font-family: 'Cormorant Garamond', serif;
        font-size: 0.95rem;
        color: var(--brown);
        outline: none;
        resize: none;
        height: 80px;
        transition: border-color 0.3s;
    }

    .addr-section textarea:focus {
        border-color: var(--gold);
        background: white;
    }

    .addr-section textarea::placeholder {
        color: #bbb;
    }

    .addr-err {
        font-size: 0.75rem;
        color: #e05500;
        margin-top: 4px;
        display: none;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .addr-err.show {
        display: block;
    }

    /* PAYMENT OPTIONS */
    .pay-options {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 4px;
    }

    .pay-opt {
        display: flex;
        align-items: center;
        gap: 12px;
        border: 1.5px solid rgba(201, 150, 12, 0.22);
        border-radius: 10px;
        padding: 12px 14px;
        cursor: pointer;
        transition: all 0.25s;
    }

    .pay-opt:hover {
        border-color: var(--gold);
        background: rgba(201, 150, 12, 0.04);
    }

    .pay-opt.selected {
        border-color: var(--saffron);
        background: rgba(255, 107, 0, 0.04);
    }

    .pay-opt input[type=radio] {
        accent-color: var(--saffron);
        width: 16px;
        height: 16px;
        flex-shrink: 0;
    }

    .pay-icon {
        font-size: 1.4rem;
    }

    .pay-label {
        font-family: 'Playfair Display', serif;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--deep-red);
    }

    .pay-sub {
        font-size: 0.78rem;
        color: #888;
    }

    /* SUMMARY CARD */
    .summary-card {
        background: white;
        border: 1px solid rgba(201, 150, 12, 0.18);
        border-radius: 20px;
        padding: 28px;
        position: sticky;
        top: 85px;
        animation: fadeUp 0.8s ease both;
    }

    .summary-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.2rem;
        color: var(--deep-red);
        font-weight: 700;
        margin-bottom: 20px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        font-size: 0.95rem;
        color: #5a3a1a;
        border-bottom: 1px solid rgba(201, 150, 12, 0.1);
    }

    .summary-row:last-of-type {
        border-bottom: none;
    }

    .summary-row.total {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 900;
        color: var(--deep-red);
        padding-top: 14px;
        margin-top: 4px;
        border-top: 2px solid rgba(201, 150, 12, 0.25);
        border-bottom: none;
    }

    .summary-row.total span:last-child {
        color: var(--saffron);
    }

    .free-tag {
        background: linear-gradient(135deg, #22c55e, #16a34a);
        color: white;
        font-size: 0.6rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 20px;
        letter-spacing: 1px;
    }

    /* PLACE ORDER BUTTON */
    .btn-place {
        width: 100%;
        background: linear-gradient(135deg, var(--wa), #1ebe5d);
        color: white;
        border: none;
        padding: 16px;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.15rem;
        font-weight: 850;
        border-radius: 12px;
        cursor: pointer;
        margin-top: 16px;
        transition: all 0.3s;
        box-shadow: 0 6px 20px rgba(37, 211, 102, 0.3);
        letter-spacing: 0.5px;
    }

    .btn-place:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(37, 211, 102, 0.45);
    }

    .btn-place:disabled {
        opacity: 0.45;
        cursor: not-allowed;
        transform: none;
    }

    .secure-note {
        text-align: center;
        font-size: 0.75rem;
        color: #bbb;
        margin-top: 10px;
        line-height: 1.6;
    }

    /* SUCCESS STATE */
    .success-wrap {
        text-align: center;
        padding: 60px 20px;
        animation: fadeUp 0.8s ease both;
    }

    .success-icon {
        width: 90px;
        height: 90px;
        background: linear-gradient(135deg, #22c55e, #16a34a);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin: 0 auto 24px;
        box-shadow: 0 10px 30px rgba(34, 197, 94, 0.3);
    }

    .success-title {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 900;
        color: var(--deep-red);
        margin-bottom: 8px;
    }

    .success-hindi {
        font-family: 'Tiro Devanagari Hindi', serif;
        font-size: 1.1rem;
        color: var(--gold);
        margin-bottom: 16px;
    }

    .success-desc {
        font-size: 1rem;
        color: #5a3a1a;
        line-height: 1.8;
        max-width: 420px;
        margin: 0 auto 24px;
    }

    .order-badge {
        display: inline-block;
        background: linear-gradient(135deg, var(--saffron), var(--gold));
        color: white;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 8px 20px;
        border-radius: 30px;
        margin-bottom: 28px;
        letter-spacing: 1px;
    }

    .btn-home {
        display: inline-block;
        background: white;
        color: var(--brown);
        border: 1.5px solid rgba(201, 150, 12, 0.4);
        padding: 13px 28px;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1rem;
        font-weight: 700;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s;
    }

    .btn-home:hover {
        border-color: var(--gold);
        background: rgba(201, 150, 12, 0.04);
    }

    /* FOOTER */
    footer {
        position: relative;
        z-index: 1;
        background: #1a0a00;
        color: rgba(255, 255, 255, 0.4);
        text-align: center;
        padding: 20px 5%;
        font-size: 0.8rem;
        margin-top: auto;
    }

    footer span {
        color: var(--gold);
    }

    /* TOAST */
    .toast {
        position: fixed;
        bottom: 28px;
        left: 50%;
        transform: translateX(-50%) translateY(80px);
        background: white;
        border: 1px solid rgba(201, 150, 12, 0.3);
        color: var(--brown);
        padding: 12px 24px;
        border-radius: 40px;
        font-size: 0.9rem;
        font-weight: 700;
        z-index: 9999;
        box-shadow: 0 8px 25px rgba(201, 150, 12, 0.2);
        transition: transform 0.4s ease, opacity 0.4s ease;
        opacity: 0;
        white-space: nowrap;
    }

    .toast.show {
        transform: translateX(-50%) translateY(0);
        opacity: 1;
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(25px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media(max-width:768px) {
        .order-layout {
            grid-template-columns: 1fr;
        }

        .summary-card {
            position: static;
        }
    }

    @media(max-width:480px) {
        .page {
            padding: 24px 4%;
        }
    }
    </style>
</head>

<body>

    <nav>
        <a href="index.php" class="nav-logo">Kaivalyamh</a>
        <div class="nav-right">
            <a href="cart.php" class="nav-back">← Back to Cart</a>
        </div>
    </nav>

    <div class="page">

        <!-- SUCCESS STATE (JS se dikhega) -->
        <div id="successWrap" style="display:none;">
            <div class="success-wrap">
                <div class="success-icon">🎉</div>
                <div class="success-title">Order has been placed!</div>
                <div class="success-hindi">Your order has been successfully placed !</div>
                <p class="success-desc">
                    Thank You <strong><?= htmlspecialchars(explode(' ',$user_name)[0]) ?></strong>ji!
                    Your order has been sent on WhatsApp
                    We will confirm soon. Delivery within 3–5 days
                </p>
                <div class="order-badge" id="orderBadge">Order Placed ✓</div>
                <br>
                <a href="index.php" class="btn-home">🏠 Go To Home</a>
            </div>
        </div>

        <!-- ORDER FORM (default) -->
        <div id="orderForm">
            <div class="page-header">
                <div class="label">Final Step</div>
                <h1>📋 Order Confirmation</h1>
            </div>

            <div class="order-layout">

                <!-- LEFT -->
                <div>

                    <!-- Cart Items -->
                    <div class="section-card" style="margin-bottom:24px;">
                        <div class="section-title">🧺 Your Selected Items</div>
                        <div id="orderCartList">
                            <!-- JS se fill hoga -->
                        </div>
                        <div id="orderEmpty" class="empty-state" style="display:none;">
                            <div class="ec-icon">🛒</div>
                            <p>Cart is empty!</p>
                            <a href="cart.php" style="color:var(--saffron);font-weight:700;text-decoration:none;">← Go to Cart</a>
                        </div>
                    </div>

                    <!-- Delivery Address -->
                    <div class="section-card" style="margin-bottom:24px;">
                        <div class="section-title">📦 Delivery Address</div>
                        <div class="addr-section">
                            <label class="addr-label">Delivery Address</label>
                            <textarea id="deliveryAddr"
                                placeholder="Street, City, State, Pincode" required><?= htmlspecialchars($user_addr) ?></textarea>
                            <div class="addr-err" id="addrErr">⚠️ Address fill is mandatory</div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="section-card">
                        <div class="section-title">💳 Payment Method</div>
                        <div class="pay-options">
                            <label class="pay-opt selected" id="opt-cod" onclick="selectPay('opt-cod')">
                                <input type="radio" name="pay" value="Cash on Delivery (COD)" checked>
                                <span class="pay-icon">💵</span>
                                <div>
                                    <div class="pay-label">Cash on Delivery</div>
                                    <div class="pay-sub">Payment after Delivery </div>
                                </div>
                            </label>
                            <label class="pay-opt" id="opt-upi" onclick="selectPay('opt-upi')">
                                <input type="radio" name="pay" value="UPI / Online">
                                <span class="pay-icon">📱</span>
                                <div>
                                    <div class="pay-label">UPI / Online</div>
                                    <div class="pay-sub">GPay, PhonePe, Paytm, etc.</div>
                                </div>
                            </label>
                            <label class="pay-opt" id="opt-bank" onclick="selectPay('opt-bank')">
                                <input type="radio" name="pay" value="Bank Transfer">
                                <span class="pay-icon">🏦</span>
                                <div>
                                    <div class="pay-label">Bank Transfer</div>
                                    <div class="pay-sub">NEFT / IMPS / RTGS</div>
                                </div>
                            </label>
                        </div>
                    </div>

                </div>

                <!-- RIGHT: Summary -->
                <div class="summary-card">
                    <div class="summary-title">🧾 Order Summary</div>

                    <div id="summaryItems"></div>

                    <div class="summary-row" id="rowDelivery" style="display:none;">
                        <span>Delivery</span>
                        <span style="font-weight:700; color:var(--saffron);">₹120</span>
                    </div>
                    <div class="summary-row total" id="rowTotal" style="display:none;">
                        <span>Total</span>
                        <span id="grandTotalEl">₹0</span>
                    </div>

                    <!-- User info preview -->
                    <div id="userInfoBox"
                        style="margin-top:16px; padding:12px 14px; background:var(--cream); border:1px solid rgba(201,150,12,0.2); border-radius:10px; font-size:0.88rem; color:#5a3a1a; line-height:1.8; display:none;">
                        👤 <strong><?= htmlspecialchars($user_name) ?></strong><br>
                        <?php if($user_phone): ?>📱 <?= htmlspecialchars($user_phone) ?><br><?php endif; ?>
                    </div>

                    <button class="btn-place" id="placeBtn" onclick="placeOrder()" disabled>
                        Place Order ✓
                    </button>
                    <p class="secure-note">🔒 Secure & Safe<br>MSME
                        Certified • Made in India 🇮🇳</p>
                </div>

            </div>
        </div>

    </div>

    <footer>
        <span>Kaivalyamh</span> ✦ Shuddh Pooja Spray &nbsp;|&nbsp; © 2026 All Rights Reserved
    </footer>

    <div class="toast" id="toast"></div>

    <script>
    // PHP data JS mein
    const USER_NAME = "<?= addslashes(htmlspecialchars($user_name)) ?>";
    const USER_PHONE = "<?= addslashes(htmlspecialchars($user_phone)) ?>";
    const USER_ADDR = "<?= addslashes(htmlspecialchars($user_addr)) ?>";
    const WA_NUMBER = "919574679695"; // ← Apna WhatsApp number yahan daalo

    // Cart localStorage se read karo
    let cart = {};
    try {
        const s = localStorage.getItem('kmh_cart');
        if (s) cart = JSON.parse(s);
    } catch (e) {
        cart = {};
    }

    // ── Render order items ─────────────────────────────────
    function renderOrder() {
        const items = Object.entries(cart);
        const subtotal = items.reduce((s, [, v]) => s + v.price * v.qty, 0);
        const grandTotal = subtotal + 120;

        const cartListEl = document.getElementById('orderCartList');
        const emptyEl = document.getElementById('orderEmpty');
        const summaryEl = document.getElementById('summaryItems');
        const rowDelivery = document.getElementById('rowDelivery');
        const rowTotal = document.getElementById('rowTotal');
        const grandTotalEl = document.getElementById('grandTotalEl');
        const placeBtn = document.getElementById('placeBtn');
        const userInfoBox = document.getElementById('userInfoBox');

        if (items.length === 0) {
            cartListEl.innerHTML = '';
            emptyEl.style.display = 'block';
            summaryEl.innerHTML = '';
            rowDelivery.style.display = 'none';
            rowTotal.style.display = 'none';
            placeBtn.disabled = true;
            return;
        }

        emptyEl.style.display = 'none';
        placeBtn.disabled = false;
        userInfoBox.style.display = 'block';

        // Cart items (same style as cart.php — readonly, no qty controls)
        cartListEl.innerHTML = items.map(([name, {
            emoji,
            price,
            qty
        }]) => `
        <div class="cart-item">
            <div class="ci-emoji">${emoji}</div>
            <div class="ci-info">
                <div class="ci-name">${name}</div>
                <div class="ci-sub">100ml • ₹${price} per bottle</div>
            </div>
            <div style="display:flex;align-items:center;gap:10px;">
                <span style="background:var(--cream);border:1px solid rgba(201,150,12,0.25);border-radius:8px;padding:6px 14px;font-weight:700;font-size:0.9rem;color:var(--brown);">Qty: ${qty}</span>
                <div class="ci-price">₹${price*qty}</div>
            </div>
        </div>
    `).join('');

        // Summary
        summaryEl.innerHTML = items.map(([name, {
            price,
            qty
        }]) => `
        <div class="summary-row">
            <span>${name} × ${qty}</span>
            <span>₹${price*qty}</span>
        </div>
    `).join('');

        rowDelivery.style.display = 'flex';
        rowTotal.style.display = 'flex';
        grandTotalEl.textContent = '₹' + grandTotal;
    }

    // ── Payment option select ──────────────────────────────
    function selectPay(id) {
        document.querySelectorAll('.pay-opt').forEach(el => el.classList.remove('selected'));
        document.getElementById(id).classList.add('selected');
    }

    // ── Place Order → WhatsApp ─────────────────────────────
    function placeOrder() {
        const addr = document.getElementById('deliveryAddr').value.trim();
        const addrErr = document.getElementById('addrErr');

        if (!addr) {
            addrErr.classList.add('show');
            document.getElementById('deliveryAddr').focus();
            return;
        }
        addrErr.classList.remove('show');

        const items = Object.entries(cart);
        if (items.length === 0) {
            showToast('🛒 Cart is empty!');
            return;
        }

        // Selected payment
        const payEl = document.querySelector('input[name="pay"]:checked');
        const payMethod = payEl ? payEl.value : 'Cash on Delivery (COD)';

        // Grand total
        const subtotal2 = items.reduce((s, [, v]) => s + v.price * v.qty, 0);
        const grandTotal = subtotal2 + 120;

        // WhatsApp message build karo
        const itemLines = items.map(([name, {
                emoji,
                price,
                qty
            }]) =>
            `  ${emoji} ${name} × ${qty}  =  ₹${price*qty}`
        ).join('\n');

        const msg =
            ` *Shuddh Pooja Spray — New Order*

 *Customer Details:*
  Name   : ${USER_NAME}
  Phone  : ${USER_PHONE || 'N/A'}
  Address: ${addr}

 *Order Items:*
${itemLines}

 *Subtotal     : ₹${subtotal2}*
 *Delivery     : ₹120*
 *Grand Total  : ₹${grandTotal}*
 *Payment      : ${payMethod}*

_Ordered from Kaivalyamh.shop_ 
_Jai Shree Ram_ `;

        // Button disable to prevent double click
        const btn = document.getElementById('placeBtn');
        btn.disabled = true;
        btn.textContent = 'Opening WhatsApp...';

        showToast('Redirecting to WhatsApp ...');

        setTimeout(() => {
            // Cart clear karo
            localStorage.removeItem('kmh_cart');

            // Success screen dikhao
            document.getElementById('orderForm').style.display = 'none';
            document.getElementById('successWrap').style.display = 'block';

            // WhatsApp open karo
            window.open('https://wa.me/' + WA_NUMBER + '?text=' + encodeURIComponent(msg), '_blank');
        }, 900);
    }

    // ── Toast ──────────────────────────────────────────────
    function showToast(msg) {
        const t = document.getElementById('toast');
        t.textContent = msg;
        t.classList.add('show');
        setTimeout(() => t.classList.remove('show'), 2800);
    }

    // ── Init ───────────────────────────────────────────────
    renderOrder();

    // PHP session localStorage sync
    localStorage.setItem('kmh_session', JSON.stringify({
        name: "<?= addslashes(htmlspecialchars($user_name)) ?>",
        id: "<?= $user_id ?>"
    }));
    </script>
</body>

</html>