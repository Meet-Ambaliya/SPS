<?php
/**
 * Kaivalyamh Shuddh Pooja Spray - Cart Page
 */
if(!session_id()) session_start();
$logged_in = isset($_SESSION['user_id']);
$user_name = $logged_in ? $_SESSION['user_name'] : '';
$user_addr = $logged_in ? ($_SESSION['user_addr'] ?? '') : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart | Kaivalyamh Shuddh Pooja Spray</title>
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

    /* NAV */
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

    .cart-count-badge {
        background: linear-gradient(135deg, var(--saffron), var(--gold));
        color: white;
        font-size: 0.7rem;
        font-weight: 700;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
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
    .cart-layout {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 28px;
        align-items: start;
    }

    /* SECTION CARD */
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

    /* PRODUCT TILES */
    .products-picker {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }

    .prod-tile {
        border: 1.5px solid rgba(201, 150, 12, 0.2);
        border-radius: 14px;
        padding: 14px 10px;
        text-align: center;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        background: var(--cream);
    }

    .prod-tile:hover {
        border-color: var(--gold);
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(201, 150, 12, 0.15);
    }

    .prod-tile .pt-emoji {
        font-size: 2rem;
        display: block;
        margin-bottom: 6px;
    }

    .prod-tile .pt-name {
        font-family: 'Playfair Display', serif;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--deep-red);
        margin-bottom: 3px;
    }

    .prod-tile .pt-price {
        font-size: 0.8rem;
        color: var(--saffron);
        font-weight: 700;
    }

    .prod-tile .pt-add {
        margin-top: 10px;
        width: 100%;
        background: linear-gradient(135deg, var(--saffron), #e05500);
        color: white;
        border: none;
        padding: 7px 0;
        border-radius: 8px;
        font-family: 'Cormorant Garamond', serif;
        font-size: 0.85rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }

    .prod-tile .pt-add:hover {
        box-shadow: 0 4px 12px rgba(255, 107, 0, 0.4);
        transform: translateY(-1px);
    }

    /* PREMIUM TILE */
    .prod-tile.premium-tile {
        background: #0a0a0a;
        border-color: #333;
        grid-column: 1/-1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        text-align: left;
        padding: 14px 18px;
    }

    .prod-tile.premium-tile .pt-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .prod-tile.premium-tile .pt-emoji {
        margin-bottom: 0;
        font-size: 1.8rem;
    }

    .prod-tile.premium-tile .pt-name {
        color: #D4AF37;
    }

    .prod-tile.premium-tile .pt-price {
        color: #D4AF37;
    }

    .prod-tile.premium-tile .pt-add {
        width: auto;
        padding: 7px 18px;
        background: linear-gradient(135deg, #555, #D4AF37);
        margin-top: 0;
    }

    .prod-tile.premium-tile:hover {
        border-color: #D4AF37;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.35);
    }

    /* CART ITEMS */
    .cart-items-wrap {
        margin-top: 24px;
    }

    .cart-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 0;
        border-bottom: 1px solid rgba(201, 150, 12, 0.12);
        animation: slideIn 0.35s ease both;
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

    .ci-controls {
        display: flex;
        align-items: center;
        background: var(--cream);
        border: 1px solid rgba(201, 150, 12, 0.25);
        border-radius: 8px;
        overflow: hidden;
    }

    .ci-btn {
        width: 32px;
        height: 32px;
        border: none;
        background: none;
        cursor: pointer;
        font-size: 1.1rem;
        color: var(--brown);
        transition: background 0.2s, color 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Playfair Display', serif;
        font-weight: 700;
    }

    .ci-btn:hover {
        background: var(--gold);
        color: white;
    }

    .ci-qty {
        width: 32px;
        text-align: center;
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--brown);
        border-left: 1px solid rgba(201, 150, 12, 0.2);
        border-right: 1px solid rgba(201, 150, 12, 0.2);
        line-height: 32px;
    }

    .ci-price {
        font-family: 'Playfair Display', serif;
        font-size: 1.05rem;
        font-weight: 900;
        color: var(--saffron);
        min-width: 56px;
        text-align: right;
    }

    .ci-remove {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        color: #ccc;
        padding: 4px;
        transition: color 0.2s;
        line-height: 1;
    }

    .ci-remove:hover {
        color: #e05500;
    }

    /* EMPTY CART */
    .empty-cart {
        text-align: center;
        padding: 40px 20px;
        color: #aaa;
        display: none;
    }

    .empty-cart .ec-icon {
        font-size: 3rem;
        margin-bottom: 12px;
    }

    .empty-cart p {
        font-size: 1rem;
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

    /* BUTTONS */
    .btn-checkout {
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

    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(37, 211, 102, 0.45);
    }

    .btn-checkout:disabled {
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

    .link-button {
        width: 100%;
        display: inline-block;
        text-align: center;
        padding: 14px 24px;
        margin-top: 20px;
        color: white;
        text-decoration: none;
        border-radius: 12px;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.15rem;
        font-weight: 850;
        letter-spacing: 0.5px;
        transition: all 0.3s;
        box-shadow: 0 6px 20px rgba(37, 211, 102, 0.3);
        background: linear-gradient(135deg, var(--wa), #1ebe5d);
        cursor: pointer;
        border: none;
    }

    .link-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(37, 211, 102, 0.5);
    }

    .link-button.login-btn {
        background: linear-gradient(135deg, var(--saffron), #e05500);
        box-shadow: 0 6px 20px rgba(255, 107, 0, 0.3);
    }

    .link-button.login-btn:hover {
        box-shadow: 0 12px 30px rgba(255, 107, 0, 0.5);
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

    /* ══════════════════════════════════════
       RESPONSIVE — sabhi devices ke liye
       ══════════════════════════════════════ */

    /* ── Tablet: 1024px ── */
    @media(max-width:1024px) {
        .cart-layout {
            grid-template-columns: 1fr 300px;
            gap: 20px;
        }

        .page {
            padding: 32px 4%;
        }

        .section-card {
            padding: 22px 18px;
        }

        .summary-card {
            padding: 22px 18px;
        }

        .products-picker {
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .prod-tile {
            padding: 12px 8px;
        }
    }

    /* ── Mobile: 768px ── */
    @media(max-width:768px) {

        /* Layout */
        .cart-layout {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        /* Summary card sticky hatao */
        .summary-card {
            position: static;
            padding: 20px 16px;
        }

        /* Nav */
        nav {
            height: 58px;
            padding: 0 4%;
        }

        .nav-logo {
            font-size: 1.2rem;
        }

        .nav-back {
            font-size: 0.85rem;
        }

        /* Page */
        .page {
            padding: 28px 4%;
        }

        .page-header {
            margin-bottom: 22px;
        }

        .page-header h1 {
            font-size: 1.8rem;
        }

        /* Section card */
        .section-card {
            padding: 20px 16px;
            border-radius: 16px;
        }

        /* Product tiles 2 column */
        .products-picker {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .prod-tile {
            padding: 12px 8px;
            border-radius: 12px;
        }

        .prod-tile .pt-emoji {
            font-size: 1.7rem;
        }

        .prod-tile .pt-name {
            font-size: 0.8rem;
        }

        .prod-tile .pt-price {
            font-size: 0.75rem;
        }

        .prod-tile .pt-add {
            font-size: 0.8rem;
            padding: 6px 0;
        }

        /* Premium tile */
        .prod-tile.premium-tile {
            padding: 12px 14px;
        }

        .prod-tile.premium-tile .pt-emoji {
            font-size: 1.5rem;
        }

        /* Cart items */
        .ci-emoji {
            width: 42px;
            height: 42px;
            font-size: 1.3rem;
        }

        .ci-name {
            font-size: 0.92rem;
        }

        .ci-sub {
            font-size: 0.75rem;
        }

        .ci-price {
            font-size: 0.95rem;
            min-width: 48px;
        }

        .ci-btn {
            width: 28px;
            height: 28px;
            font-size: 1rem;
        }

        .ci-qty {
            width: 28px;
            font-size: 0.88rem;
            line-height: 28px;
        }

        /* Summary */
        .summary-title {
            font-size: 1.1rem;
            margin-bottom: 14px;
        }

        .summary-row {
            font-size: 0.88rem;
        }

        .summary-row.total {
            font-size: 1.2rem;
        }

        /* Buttons */
        .btn-checkout {
            font-size: 1rem;
            padding: 14px;
        }

        .link-button {
            font-size: 1rem;
            padding: 13px 18px;
        }

        .secure-note {
            font-size: 0.72rem;
        }

        /* Footer */
        footer {
            padding: 20px 4%;
        }

        .footer-logo {
            font-size: 1.1rem;
        }

        footer p {
            font-size: 0.78rem;
        }
    }

    /* ── Small Mobile: 480px ── */
    @media(max-width:480px) {
        nav {
            height: 55px;
            padding: 0 4%;
        }

        .nav-logo {
            font-size: 1.1rem;
        }

        .nav-back {
            font-size: 0.78rem;
            gap: 4px;
        }

        .page {
            padding: 22px 4%;
        }

        .page-header h1 {
            font-size: 1.5rem;
        }

        .page-header .label {
            font-size: 0.62rem;
            letter-spacing: 3px;
        }

        .section-card {
            padding: 16px 13px;
            border-radius: 14px;
        }

        .products-picker {
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }

        .prod-tile {
            padding: 10px 6px;
        }

        .prod-tile .pt-emoji {
            font-size: 1.5rem;
            margin-bottom: 4px;
        }

        .prod-tile .pt-name {
            font-size: 0.75rem;
        }

        .prod-tile .pt-add {
            font-size: 0.75rem;
            padding: 5px 0;
            margin-top: 7px;
            border-radius: 6px;
        }

        /* Premium tile stack */
        .prod-tile.premium-tile {
            flex-direction: column;
            gap: 10px;
            text-align: center;
            padding: 12px 10px;
        }

        .prod-tile.premium-tile .pt-left {
            justify-content: center;
        }

        .prod-tile.premium-tile .pt-add {
            width: 100%;
            padding: 6px 0;
            margin-top: 0;
        }

        /* Cart items */
        .cart-item {
            gap: 10px;
            padding: 11px 0;
        }

        .ci-emoji {
            width: 38px;
            height: 38px;
            font-size: 1.2rem;
            border-radius: 8px;
        }

        .ci-name {
            font-size: 0.85rem;
        }

        .ci-price {
            font-size: 0.88rem;
            min-width: 42px;
        }

        /* Summary */
        .summary-card {
            padding: 16px 13px;
            border-radius: 14px;
        }

        /* Footer */
        footer {
            padding: 16px 4%;
        }

        .footer-logo {
            font-size: 1rem;
        }

        footer p {
            font-size: 0.72rem;
        }
    }

    /* ── Very Small: 360px ── */
    @media(max-width:360px) {
        .nav-logo {
            font-size: 1rem;
        }

        .nav-back {
            font-size: 0.72rem;
        }

        .page-header h1 {
            font-size: 1.3rem;
        }

        .prod-tile .pt-name {
            font-size: 0.7rem;
        }

        .btn-checkout {
            font-size: 0.92rem;
        }

        .link-button {
            font-size: 0.92rem;
        }
    }
    </style>
</head>

<body>

    <nav>
        <a href="index.php" class="nav-logo">Kaivalyamh</a>
        <div class="nav-right">
            <a href="index.php" class="nav-back">← Back to Home</a>
            <div class="cart-count-badge" id="cartBadge">0</div>
        </div>
    </nav>

    <div class="page">
        <div class="page-header">
            <div class="label">Your Selection</div>
            <h1>🛒 My Cart</h1>
        </div>

        <div class="cart-layout">

            <!-- LEFT -->
            <div>
                <div class="section-card">
                    <div class="section-title">Choose Products to Add</div>
                    <div class="products-picker">

                        <div class="prod-tile">
                            <span class="pt-emoji">🪵</span>
                            <div class="pt-name">Chandan</div>
                            <div class="pt-price">₹99</div>
                            <button class="pt-add"  onclick="addToCart('Chandan','🪵', 99)">+ Add to
                                Cart</button>
                        </div>

                        <div class="prod-tile">
                            <span class="pt-emoji">🌸</span>
                            <div class="pt-name">Mogra</div>
                            <!-- <div class="pt-price">₹99</div> -->
                            <button class="pt-add">Coming Soon...</button>
                        </div>

                        <div class="prod-tile">
                            <span class="pt-emoji">🌹</span>
                            <div class="pt-name">Gulab</div>
                            <!-- <div class="pt-price">₹99</div> -->
                            <button class="pt-add">Coming Soon...</button>
                        </div>

                        <div class="prod-tile">
                            <span class="pt-emoji">🌿</span>
                            <div class="pt-name">Kewda</div>
                            <!-- <div class="pt-price">₹99</div> -->
                            <button class="pt-add">Coming Soon...</button>
                        </div>

                        <div class="prod-tile">
                            <span class="pt-emoji">🌼</span>
                            <div class="pt-name">Champa</div>
                            <!-- <div class="pt-price">₹99</div> -->
                            <button class="pt-add">Coming Soon...</button>
                        </div>

                        <div class="prod-tile premium-tile">
                            <div class="pt-left">
                                <span class="pt-emoji">✨</span>
                                <div>
                                    <div class="pt-name">Oud Premium</div>
                                    <!-- <div class="pt-price">₹149</div> -->
                                </div>
                            </div>
                            <button class="pt-add">Coming Soon...</button>
                        </div>

                    </div>

                    <!-- Cart Items -->
                    <div class="cart-items-wrap">
                        <div class="section-title" style="margin-top:24px; margin-bottom:10px;">🧺 Items in Cart</div>

                        <div class="empty-cart" id="emptyMsg">
                            <div class="ec-icon">🛒</div>
                            <p>Your cart is empty.<br>Add products above!</p>
                        </div>

                        <div id="cartList"></div>

                        <button id="cartActionBtn" class="link-button" onclick="goToOrder()">✅ Confirm Order</button>
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
                    <span id="totalPrice">₹0</span>
                </div>

                <div id="summaryEmpty" style="text-align:center;padding:30px 0;color:#bbb;font-size:0.95rem;">
                    🛒 Cart is empty !
                </div>

                <button class="btn-checkout" id="checkoutBtn" onclick="goToOrder()" disabled>✅ Confirm Order</button>
                <p class="secure-note">🔒 Secure & Safe <br>MSME Certified • Made in India 🇮🇳</p>
            </div>

        </div>
    </div>

    <footer>
        <span>Kaivalyamh</span> ✦ Shuddh Pooja Spray &nbsp;|&nbsp; © 2026 All Rights Reserved
    </footer>

    <div class="toast" id="toast"></div>

    <script>
    // PHP se login info JS mein
    const PHP_LOGGED_IN = <?= $logged_in ? 'true' : 'false' ?>;
    const PHP_USER_ADDR = "<?= addslashes(htmlspecialchars($user_addr)) ?>";
    const PHP_USER_NAME = "<?= addslashes(htmlspecialchars($user_name)) ?>";

    // Cart state — localStorage se restore
    let cart = {};
    try {
        const s = localStorage.getItem('kmh_cart');
        if (s) cart = JSON.parse(s);
    } catch (e) {
        cart = {};
    }

    function saveCart() {
        localStorage.setItem('kmh_cart', JSON.stringify(cart));
    }

    function addToCart(name, emoji, price) {
        if (cart[name]) cart[name].qty += 1;
        else cart[name] = {
            emoji,
            price,
            qty: 1
        };
        saveCart();
        renderCart();
        showToast('✨ ' + name + ' added!');
    }

    function removeFromCart(name) {
        delete cart[name];
        saveCart();
        renderCart();
        showToast('🗑️ Removed from cart');
    }

    function updateQty(name, delta) {
        if (!cart[name]) return;
        cart[name].qty += delta;
        if (cart[name].qty <= 0) {
            removeFromCart(name);
            return;
        }
        saveCart();
        renderCart();
    }

    function renderCart() {
        const items = Object.entries(cart);
        const totalQty = items.reduce((s, [, v]) => s + v.qty, 0);
        const subtotal = items.reduce((s, [, v]) => s + v.price * v.qty, 0);
        const grandTotal = subtotal + 120;

        // Badge
        document.getElementById('cartBadge').textContent = totalQty;

        // Empty msg
        document.getElementById('emptyMsg').style.display = items.length === 0 ? 'block' : 'none';

        // Cart list
        document.getElementById('cartList').innerHTML = items.map(([name, {
            emoji,
            price,
            qty
        }]) => `
        <div class="cart-item">
            <div class="ci-emoji">${emoji}</div>
            <div class="ci-info">
                <div class="ci-name">${name}</div>
                <div class="ci-sub">₹${price} × ${qty}</div>
            </div>
            <div class="ci-controls">
                <button class="ci-btn" onclick="updateQty('${name}',-1)">−</button>
                <div class="ci-qty">${qty}</div>
                <button class="ci-btn" onclick="updateQty('${name}',1)">+</button>
            </div>
            <div class="ci-price">₹${price*qty}</div>
            <button class="ci-remove" onclick="removeFromCart('${name}')" title="Remove">✕</button>
        </div>
    `).join('');

        // Summary panel
        const summaryEmpty = document.getElementById('summaryEmpty');
        const rowDelivery = document.getElementById('rowDelivery');
        const rowTotal = document.getElementById('rowTotal');
        const summaryItems = document.getElementById('summaryItems');

        if (items.length === 0) {
            summaryEmpty.style.display = 'block';
            summaryItems.innerHTML = '';
            rowDelivery.style.display = 'none';
            rowTotal.style.display = 'none';
        } else {
            summaryEmpty.style.display = 'none';
            rowDelivery.style.display = 'flex';
            rowTotal.style.display = 'flex';
            summaryItems.innerHTML = items.map(([name, {
                price,
                qty
            }]) => `
            <div class="summary-row">
                <span>${name} × ${qty}</span>
                <span>₹${price*qty}</span>
            </div>
        `).join('');
            document.getElementById('totalPrice').textContent = '₹' + grandTotal;
        }

        // Buttons
        const actionBtn = document.getElementById('cartActionBtn');
        const checkoutBtn = document.getElementById('checkoutBtn');
        const hasItems = items.length > 0;

        if (!PHP_LOGGED_IN) {
            actionBtn.textContent = '🔒 Sign In to Order';
            actionBtn.classList.add('login-btn');
            checkoutBtn.textContent = '🔒 Sign In to Order';
            checkoutBtn.disabled = false;
        } else {
            actionBtn.textContent = '✅ Confirm Order';
            actionBtn.classList.remove('login-btn');
            checkoutBtn.textContent = '✅ Confirm Order';
            checkoutBtn.disabled = !hasItems;
        }
        actionBtn.style.display = 'block';
    }

    function goToOrder() {
        if (!PHP_LOGGED_IN) {
            window.location.href = 'form.php?redirect=order.php';
            return;
        }
        const items = Object.entries(cart);
        if (items.length === 0) {
            showToast('Add some product to add to cart!');
            return;
        }
        window.location.href = 'order.php';
    }

    function showToast(msg) {
        const t = document.getElementById('toast');
        t.textContent = msg;
        t.classList.add('show');
        setTimeout(() => t.classList.remove('show'), 2800);
    }

    // Init
    renderCart();

    // PHP session → localStorage sync
    <?php if($logged_in): ?>
    localStorage.setItem('kmh_session', JSON.stringify({
        name: "<?= addslashes(htmlspecialchars($user_name)) ?>",
        id: "<?= (int)$_SESSION['user_id'] ?>"
    }));
    <?php else: ?>
    localStorage.removeItem('kmh_session');
    <?php endif; ?>
    </script>
</body>

</html>