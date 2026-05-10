<?php
/* Kaivalyamh - Shuddh Pooja Spray */
if(!session_id()) session_start();

$current_year = date("Y");
$starting_price = 99;
$logged_in = isset($_SESSION['user_id']);
$user_name  = $logged_in ? $_SESSION['user_name'] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Shuddh Pooja Spray - Made with Ganga Jal, Sandalwood and Camphor. The sacred fragrance of a temple, now in your home. Only Rs.<?php echo $starting_price; ?>">
    <meta name="keywords" content="pooja spray, ganga jal, sandalwood, camphor, pure, sacred, temple, kaivalyamh">
    <meta property="og:title" content="Shuddh Pooja Spray | Kaivalyamh">
    <meta property="og:description"
        content="The sacred fragrance of a temple, now in every home - Only Rs.<?php echo $starting_price; ?>">
    <meta property="og:url" content="https://kaivalyamh.shop">
    <title>Shuddh Pooja Spray | Kaivalyamh</title>
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
        overflow-x: hidden;
    }

    /* NAV */
    nav {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
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
        font-size: 1.5rem;
        font-weight: 900;
        color: var(--deep-red);
    }

    .nav-logo span {
        color: var(--gold);
    }

    .nav-links {
        display: flex;
        gap: 1rem;
        list-style: none;
        align-items: center;
    }

    .nav-links a {
        text-decoration: none;
        color: var(--brown);
        font-size: 0.95rem;
        font-weight: 900;
        transition: color 0.2s;
    }

    .nav-links a:hover {
        color: var(--saffron);
    }

    .nav-order {
        background: linear-gradient(135deg, var(--saffron), var(--gold));
        color: white !important;
        padding: 8px 14px;
        border-radius: 4px;
    }

    /* SIGN IN BUTTON STYLE */
    .nav-login-btn {
        border: 1.5px solid var(--gold);
        color: var(--gold) !important;
        padding: 7px 14px;
        border-radius: 4px;
        font-weight: 900;
    }

    .nav-login-btn:hover {
        background: var(--gold);
        color: white !important;
    }

    /* USER GREETING in nav */
    .nav-user {
        display: flex;
        align-items: center;
        gap: 8px;
        background: rgba(201, 150, 12, 0.1);
        border: 1px solid rgba(201, 150, 12, 0.3);
        border-radius: 20px;
        padding: 5px 14px 5px 8px;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--deep-red);
    }

    .nav-user .user-avatar {
        width: 26px;
        height: 26px;
        background: linear-gradient(135deg, var(--saffron), var(--gold));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.75rem;
        font-weight: 900;
        flex-shrink: 0;
    }

    .hamburger {
        display: none;
        flex-direction: column;
        gap: 5px;
        cursor: pointer;
        background: none;
        border: none;
    }

    .hamburger span {
        width: 25px;
        height: 2px;
        background: var(--brown);
        border-radius: 2px;
        display: block;
        transition: all 0.3s;
    }

    .mobile-menu {
        display: none;
        position: fixed;
        top: 65px;
        left: 0;
        right: 0;
        background: var(--cream);
        border-bottom: 2px solid var(--gold);
        z-index: 999;
        padding: 20px;
        flex-direction: column;
        gap: 15px;
    }

    .mobile-menu a {
        text-decoration: none;
        color: var(--brown);
        font-size: 1.1rem;
        font-weight: 600;
        padding: 8px 0;
        border-bottom: 1px solid rgba(201, 150, 12, 0.2);
    }

    .mobile-menu.open {
        display: flex;
    }

    /* HERO */
    #home {
        min-height: 100vh;
        display: flex;
        align-items: center;
        padding: 100px 5% 60px;
        position: relative;
        overflow: hidden;
    }

    .hero-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-items: center;
        gap: 40px;
        width: 100%;
        position: relative;
        z-index: 1;
    }

    /* BOTTLE MOCKUP */
    .bottle-wrap {
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        height: 460px;
        animation: fadeUp 1.1s ease both;
    }

    .bottle-glow {
        position: absolute;
        width: 280px;
        height: 280px;
        background: radial-gradient(circle, rgba(201, 150, 12, 0.22) 0%, transparent 70%);
        border-radius: 50%;
        animation: pulseGlow 3s ease-in-out infinite;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    @keyframes pulseGlow {

        0%,
        100% {
            transform: translate(-50%, -50%) scale(1);
            opacity: 0.7;
        }

        50% {
            transform: translate(-50%, -50%) scale(1.2);
            opacity: 1;
        }
    }

    .bottle-svg-wrap {
        position: relative;
        z-index: 2;
        animation: floatBottle 4s ease-in-out infinite;
    }

    @keyframes floatBottle {

        0%,
        100% {
            transform: translateY(0px) rotate(-1.5deg);
        }

        50% {
            transform: translateY(-20px) rotate(1.5deg);
        }
    }

    .ing-tag {
        position: absolute;
        background: white;
        border: 1px solid rgba(201, 150, 12, 0.35);
        border-radius: 30px;
        padding: 7px 14px;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--brown);
        display: flex;
        align-items: center;
        gap: 5px;
        box-shadow: 0 4px 16px rgba(201, 150, 12, 0.15);
        z-index: 4;
        white-space: nowrap;
        animation: floatTag var(--td, 3.5s) ease-in-out infinite;
    }

    @keyframes floatTag {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-9px);
        }
    }

    .bottle-badge {
        position: absolute;
        background: linear-gradient(135deg, var(--saffron));
        color: white;
        font-family: 'Playfair Display', serif;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 1px;
        padding: 8px 14px;
        border-radius: 50px;
        z-index: 4;
        animation: floatTag 3s ease-in-out infinite;
        --td: 3s;
        text-align: center;
    }

    @media(max-width: 768px) {
        .hero-layout {
            grid-template-columns: 1fr;
        }

        .bottle-wrap {
            display: none;
        }
    }

    .hero-bg {
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at 70% 50%, rgba(201, 150, 12, 0.1) 0%, transparent 60%),
            linear-gradient(160deg, #FFF8EE 0%, #FFF0D6 100%);
    }

    .hero-bg::before {
        content: 'ॐ';
        position: absolute;
        right: 3%;
        top: 50%;
        transform: translateY(-50%);
        font-size: 38vw;
        color: rgba(201, 150, 12, 0.04);
        font-family: 'Tiro Devanagari Hindi', serif;
        line-height: 1;
        pointer-events: none;
    }

    .hero-inner {
        position: relative;
        z-index: 1;
        animation: fadeUp 0.9s ease both;
    }

    .hero-badge {
        display: inline-block;
        background: linear-gradient(135deg, var(--saffron), var(--gold));
        color: white;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
        padding: 6px 16px;
        border-radius: 2px;
        margin-bottom: 1.2rem;
    }

    .hero-hindi {
        font-family: 'Tiro Devanagari Hindi', serif;
        font-size: clamp(1rem, 2.5vw, 1.4rem);
        color: var(--saffron);
        margin-bottom: 0.6rem;
    }

    .hero-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2.8rem, 6vw, 5rem);
        line-height: 1.05;
        color: var(--deep-red);
        font-weight: 900;
        margin-bottom: 1rem;
    }

    .hero-title .gold {
        color: var(--gold);
    }

    .hero-desc {
        font-size: 1.1rem;
        color: #5a3a1a;
        line-height: 1.8;
        margin-bottom: 2rem;
        max-width: 460px;
    }

    .hero-btns {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--saffron), #e05500);
        color: white;
        border: none;
        padding: 15px 32px;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem;
        font-weight: 700;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        box-shadow: 0 8px 25px rgba(255, 107, 0, 0.35);
        transition: all 0.3s;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(255, 107, 0, 0.45);
    }

    .btn-wa {
        background: var(--wa);
        color: white;
        border: none;
        padding: 15px 28px;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem;
        font-weight: 700;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 8px 25px rgba(37, 211, 102, 0.3);
        transition: all 0.3s;
    }

    .btn-wa:hover {
        transform: translateY(-2px);
        background: #1ebe5d;
    }

    /* STRIP */
    .strip {
        background: linear-gradient(135deg, var(--deep-red), #8B2500);
        color: white;
        padding: 16px 5%;
        display: flex;
        justify-content: center;
        gap: 3rem;
        flex-wrap: wrap;
    }

    .strip-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 1px;
    }

    /* SECTIONS */
    section {
        padding: 70px 5%;
    }

    .sec-label {
        font-size: 0.72rem;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--saffron);
        font-weight: 700;
        margin-bottom: 0.4rem;
    }

    .sec-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.8rem, 4vw, 3rem);
        color: var(--deep-red);
        line-height: 1.2;
        margin-bottom: 0.5rem;
    }

    .sec-hindi {
        font-family: 'Tiro Devanagari Hindi', serif;
        font-size: clamp(1rem, 2vw, 1.4rem);
        color: var(--gold);
        margin-bottom: 1.5rem;
    }

    /* PRODUCTS */
    #products {
        background: linear-gradient(160deg, #FFF8EE, #FFF0D6);
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 24px;
        margin-top: 2rem;
    }

    .product-card {
        background: white;
        border: 1px solid rgba(201, 150, 12, 0.2);
        border-radius: 16px;
        padding: 24px 20px;
        text-align: center;
        transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 22px 50px rgba(201, 150, 12, 0.2);
        border-color: var(--gold);
    }

    .product-card.featured {
        border: 2px solid var(--gold);
    }

    .product-card.featured-gulab {
        border: 2px solid var(--gold);
    }

    .product-card.premium {
        border: 2px solid #000;
        background: #0a0a0a;
        grid-column: 1 / -1;
        max-width: 280px;
        margin: 0 auto;
        width: 100%;
    }

    .product-card.premium:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 22px 50px rgba(0, 0, 0, 0.6), 0 0 30px rgba(212, 175, 55, 0.15);
        border-color: #D4AF37;
    }

    .badge-featured {
        position: absolute;
        top: -10px;
        left: 50%;
        transform: translateX(-50%);
        background: linear-gradient(135deg, var(--saffron), var(--gold));
        color: white;
        font-size: 0.6rem;
        font-weight: 700;
        letter-spacing: 2px;
        padding: 4px 14px;
        border-radius: 20px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .product-emoji {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .product-name {
        font-family: 'Playfair Display', serif;
        font-size: 1.3rem;
        color: var(--deep-red);
        font-weight: 700;
        margin-bottom: 4px;
    }

    .rem {
        text-decoration: none;
    }

    .product-hindi {
        font-family: 'Tiro Devanagari Hindi', serif;
        font-size: 0.9rem;
        color: var(--gold);
        margin-bottom: 10px;
    }

    .product-desc {
        font-size: 0.9rem;
        color: #5a3a1a;
        line-height: 1.6;
        margin-bottom: 14px;
    }

    .product-price {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 900;
        color: var(--saffron);
        margin-bottom: 14px;
    }

    .product-price span {
        font-size: 25px;
        color: #888;
        font-weight: 400;
        font-family: 'Cormorant Garamond', serif;
    }

    .btn-order-card {
        width: 100%;
        background: linear-gradient(135deg, var(--wa), #1ebe5d);
        color: white;
        border: none;
        padding: 12px;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1rem;
        font-weight: 700;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: block;
    }

    .btn-order-card:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
    }

    /* INGREDIENTS */
    #ingredients {
        background: white;
    }

    .ing-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 20px;
        margin-top: 1.5rem;
    }

    .ing-card {
        background: var(--cream);
        border: 1px solid rgba(201, 150, 12, 0.2);
        border-radius: 12px;
        padding: 24px 16px;
        text-align: center;
        transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .ing-card:hover {
        border-color: var(--gold);
        transform: translateY(-10px) scale(1.03);
        box-shadow: 0 18px 40px rgba(201, 150, 12, 0.18);
    }

    .ing-icon {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .ing-name {
        font-family: 'Playfair Display', serif;
        font-size: 1.1rem;
        color: var(--deep-red);
        font-weight: 700;
    }

    .ing-hindi {
        font-family: 'Tiro Devanagari Hindi', serif;
        font-size: 0.85rem;
        color: var(--gold);
        margin: 4px 0;
    }

    .ing-desc {
        font-size: 0.85rem;
        color: #5a3a1a;
        line-height: 1.5;
    }

    /* HOW TO ORDER */
    #order {
        background: linear-gradient(160deg, #FFF8EE, #FFF0D6);
    }

    .steps-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 1.5rem;
    }

    .step-card {
        text-align: center;
        padding: 20px;
        border-radius: 14px;
        border: 1px solid rgba(201, 150, 12, 0.1);
        transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        cursor: default;
    }

    .step-card:hover {
        transform: translateY(-10px) scale(1.03);
        box-shadow: 0 18px 40px rgba(201, 150, 12, 0.18);
        border-color: var(--gold);
    }

    .step-num {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--saffron), var(--gold));
        color: white;
        font-size: 1.4rem;
        font-weight: 900;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        font-family: 'Playfair Display', serif;
    }

    .step-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.1rem;
        color: var(--deep-red);
        font-weight: 700;
        margin-bottom: 6px;
    }

    .step-desc {
        font-size: 0.9rem;
        color: #5a3a1a;
        line-height: 1.6;
    }

    /* CONTACT CTA */
    #contact {
        background: linear-gradient(160deg, var(--deep-red), #3D1C00);
        color: white;
    }

    #contact .sec-title {
        color: var(--gold-light);
    }

    #contact .sec-label {
        color: rgba(255, 255, 255, 0.7);
    }

    #contact .sec-hindi {
        color: rgba(255, 255, 255, 0.8);
    }

    /* ABOUT */
    #about {
        background: white;
    }

    .about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 50px;
        align-items: center;
    }

    .about-text p {
        font-size: 1.05rem;
        line-height: 1.9;
        color: #5a3a1a;
        margin-bottom: 1rem;
    }

    .about-values {
        list-style: none;
        margin-top: 1rem;
    }

    .about-values li {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 0;
        border-bottom: 1px solid rgba(201, 150, 12, 0.15);
        font-size: 1rem;
        color: #5a3a1a;
    }

    .check {
        width: 22px;
        height: 22px;
        background: linear-gradient(135deg, var(--saffron), var(--gold));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.7rem;
        flex-shrink: 0;
    }

    .about-visual {
        background: linear-gradient(135deg, rgba(255, 107, 0, 0.05), rgba(201, 150, 12, 0.1));
        border: 1px solid rgba(201, 150, 12, 0.2);
        border-radius: 20px;
        padding: 40px 30px;
        text-align: center;
    }

    .om {
        font-family: 'Tiro Devanagari Hindi', serif;
        font-size: 7rem;
        color: var(--gold);
        opacity: 0.8;
        display: block;
        line-height: 1;
        margin-bottom: 16px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .stat {
        background: white;
        border-radius: 10px;
        padding: 16px;
        border: 1px solid rgba(201, 150, 12, 0.2);
        transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        cursor: default;
    }

    .stat:hover {
        transform: translateY(-8px) scale(1.05);
        box-shadow: 0 14px 35px rgba(201, 150, 12, 0.2);
        border-color: var(--gold);
    }

    .stat .num {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        font-weight: 900;
        color: var(--saffron);
    }

    .stat .lbl {
        font-size: 0.8rem;
        color: #5a3a1a;
    }

    /* FOOTER */
    footer {
        background: #1a0a00;
        color: rgba(255, 255, 255, 0.55);
        text-align: center;
        padding: 28px 5%;
    }

    .footer-logo {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 900;
        color: var(--gold);
        margin-bottom: 8px;
    }

    footer p {
        font-size: 0.85rem;
        margin: 4px 0;
    }

    footer a {
        color: var(--gold);
        text-decoration: none;
    }

    /* ANIMATIONS */
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(35px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .reveal {
        opacity: 0;
        transform: translateY(25px);
        transition: opacity 0.7s ease, transform 0.7s ease;
    }

    .reveal.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* ══════════════════════════════════════
       RESPONSIVE — sabhi devices ke liye
       ══════════════════════════════════════ */

    /* ── Tablet: 1024px ── */
    @media(max-width:1024px) {
        nav {
            padding: 0 4%;
        }

        .hero-layout {
            gap: 24px;
        }

        .hero-title {
            font-size: clamp(2.4rem, 5vw, 4rem);
        }

        .bottle-wrap {
            height: 380px;
        }

        .products-grid {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }

        .about-grid {
            gap: 30px;
        }

        section {
            padding: 55px 4%;
        }

        .strip {
            gap: 2rem;
            padding: 16px 4%;
        }
    }

    /* ── Mobile: 768px ── */
    @media(max-width:768px) {

        /* NAV */
        nav {
            padding: 0 5%;
            height: 60px;
        }

        .nav-links {
            display: none;
        }

        .hamburger {
            display: flex;
        }

        /* Mobile menu links spacing */
        .mobile-menu {
            padding: 16px 5%;
            gap: 10px;
        }

        .mobile-menu a {
            font-size: 1rem;
            padding: 10px 0;
        }

        /* HERO */
        #home {
            padding: 80px 5% 50px;
            min-height: auto;
        }

        .hero-layout {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .bottle-wrap {
            display: none;
        }

        .hero-bg::before {
            display: none;
        }

        .hero-badge {
            font-size: 0.62rem;
            letter-spacing: 2px;
        }

        .hero-hindi {
            font-size: 0.95rem;
        }

        .hero-title {
            font-size: 2.4rem;
            line-height: 1.1;
        }

        .hero-desc {
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }

        .hero-btns {
            flex-direction: column;
            gap: 0.75rem;
        }

        .btn-primary,
        .btn-wa {
            width: 100%;
            justify-content: center;
            text-align: center;
            padding: 14px 20px;
            font-size: 1rem;
        }

        /* STRIP */
        .strip {
            gap: 1rem;
            padding: 14px 5%;
            justify-content: flex-start;
        }

        .strip-item {
            font-size: 0.78rem;
        }

        /* SECTIONS */
        section {
            padding: 48px 5%;
        }

        .sec-title {
            font-size: clamp(1.5rem, 5vw, 2rem);
        }

        .sec-hindi {
            font-size: 0.95rem;
        }

        /* PRODUCTS */
        .products-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
        }

        .product-card {
            padding: 18px 14px;
        }

        .product-card.premium {
            grid-column: 1 / -1;
            max-width: 100%;
        }

        .product-name {
            font-size: 1.1rem;
        }

        .product-price {
            font-size: 1.6rem;
        }

        .btn-cart {
            font-size: 0.88rem;
            padding: 9px;
        }

        /* INGREDIENTS */
        .ing-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
        }

        .ing-card {
            padding: 18px 12px;
        }

        .ing-icon {
            font-size: 2rem;
        }

        .ing-name {
            font-size: 1rem;
        }

        .ing-desc {
            font-size: 0.8rem;
        }

        /* HOW TO ORDER */
        .steps-grid {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .step-card {
            padding: 18px 16px;
        }

        /* ABOUT */
        .about-grid {
            grid-template-columns: 1fr;
            gap: 28px;
        }

        .about-text p {
            font-size: 0.95rem;
            line-height: 1.8;
        }

        .about-visual {
            padding: 28px 20px;
        }

        .om {
            font-size: 5rem;
        }

        .stats-grid {
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .stat {
            padding: 12px;
        }

        .stat .num {
            font-size: 1.5rem;
        }

        /* CONTACT CTA */
        #contact {
            padding: 48px 5%;
        }

        #contact .btn-primary {
            font-size: 1rem !important;
            padding: 14px 28px !important;
            width: 100%;
            display: block !important;
            text-align: center;
        }

        /* FOOTER */
        footer {
            padding: 22px 5%;
        }

        .footer-logo {
            font-size: 1.1rem;
        }

        footer p {
            font-size: 0.78rem;
        }

        /* USER DROPDOWN */
        .user-dropdown {
            right: -10px;
            min-width: 170px;
        }
    }

    /* ── Small Mobile: 480px ── */
    @media(max-width:480px) {

        /* NAV */
        nav {
            padding: 0 4%;
        }

        .nav-logo {
            font-size: 1.2rem;
        }

        /* HERO */
        #home {
            padding: 75px 4% 44px;
        }

        .hero-title {
            font-size: 2rem;
        }

        .hero-desc {
            font-size: 0.95rem;
        }

        .hero-badge {
            font-size: 0.58rem;
            padding: 5px 12px;
        }

        /* STRIP */
        .strip {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
            padding: 14px 4%;
        }

        /* SECTIONS */
        section {
            padding: 40px 4%;
        }

        /* PRODUCTS — single column on very small screens */
        .products-grid {
            grid-template-columns: 1fr;
        }

        .product-card.premium {
            max-width: 100%;
        }

        /* INGREDIENTS — single column */
        .ing-grid {
            grid-template-columns: 1fr;
        }

        /* ABOUT stats */
        .stats-grid {
            grid-template-columns: 1fr 1fr;
        }

        /* CONTACT */
        #contact .btn-primary {
            font-size: 0.95rem !important;
            padding: 13px 20px !important;
        }

        /* MOBILE MENU */
        .mobile-menu {
            padding: 14px 4%;
        }
    }

    .btn-cart {
        width: 100%;
        background: linear-gradient(135deg, var(--saffron), #e05500);
        color: white;
        border: none;
        padding: 11px;
        font-family: 'Cormorant Garamond', serif;
        font-size: 0.95rem;
        font-weight: 700;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: block;
        margin-top: 8px;
        letter-spacing: 0.5px;
    }

    .btn-cart:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 107, 0, 0.4);
    }

    /* User dropdown */
    .nav-user-wrap {
        position: relative;
    }

    .nav-user {
        cursor: pointer;
        user-select: none;
    }

    .user-dropdown {
        display: none;
        position: absolute;
        top: calc(100% + 10px);
        right: 0;
        background: white;
        border: 1px solid rgba(201, 150, 12, 0.25);
        border-radius: 10px;
        box-shadow: 0 12px 35px rgba(61, 28, 0, 0.15);
        min-width: 180px;
        z-index: 2000;
        overflow: hidden;
    }

    .user-dropdown.open {
        display: block;
    }

    .user-dropdown a,
    .user-dropdown button {
        display: block;
        width: 100%;
        padding: 11px 16px;
        text-align: left;
        font-family: 'Cormorant Garamond', serif;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--brown);
        text-decoration: none;
        background: none;
        border: none;
        cursor: pointer;
        border-bottom: 1px solid rgba(201, 150, 12, 0.12);
        transition: background 0.2s;
    }

    .user-dropdown a:last-child,
    .user-dropdown button:last-child {
        border-bottom: none;
    }

    .user-dropdown a:hover,
    .user-dropdown button:hover {
        background: rgba(201, 150, 12, 0.08);
        color: var(--saffron);
    }

    .user-dropdown .dd-logout {
        color: var(--deep-red);
    }

    .user-dropdown .dd-logout:hover {
        background: rgba(107, 26, 26, 0.07);
        color: var(--deep-red);
    }
    </style>
</head>

<body>

    <nav>
        <div class="nav-logo">Kaivalyamh</div>
        <ul class="nav-links">
            <li><a href="#home">Home</a></li>
            <li><a href="#products">Products</a></li>
            <li><a href="#ingredients">Ingredients</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact-us">Contact Us</a></li>
            <li><a href="cart.php" class="nav-order">Add To Cart</a></li>
            <li><a href="order.php" class="nav-order">🛒 Order Now</a></li>

            <?php if($logged_in): ?>
            <li class="nav-user-wrap">
                <div class="nav-user" onclick="toggleDropdown()" id="navUserBtn">
                    <div class="user-avatar"><?= strtoupper(substr($user_name, 0, 1)) ?></div>
                    <span><?= htmlspecialchars(explode(' ', $user_name)[0]) ?></span>
                </div>
                <div class="user-dropdown" id="userDropdown">
                    <a href="change-password.php">🔒 Change Password</a>
                    <a href="edit-profile.php">✏️ Edit Profile</a>
                    <form method="POST" action="form.php" style="margin:0;">
                        <input type="hidden" name="action" value="logout">
                        <button type="submit" class="dd-logout">🚪 Log Out</button>
                    </form>
                </div>
            </li>
            <?php else: ?>
            <li>
                <a href="form.php?redirect=<?= urlencode($_SERVER['REQUEST_URI']) ?>" class="nav-login-btn"
                    id="navLoginBtn">Sign In / Log In</a>
            </li>
            <?php endif; ?>
        </ul>
        <button class="hamburger" onclick="toggleMenu()" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>
    </nav>

    <div class="mobile-menu" id="mobileMenu">
        <a href="#home" onclick="closeMenu()">🏠 Home</a>
        <a href="#products" onclick="closeMenu()">🧴 Products</a>
        <a href="#ingredients" onclick="closeMenu()">🌿 Ingredients</a>
        <a href="#about" onclick="closeMenu()">🙏 About Us</a>
        <a href="#contact-us" onclick="closeMenu()">📞 Contact Us</a>
        <a href="order.php" onclick="closeMenu()">🛒 Order Now</a>
        <?php if($logged_in): ?>
        <form method="POST" action="form.php" style="margin:0;">
            <input type="hidden" name="action" value="logout">
            <button type="submit"
                style="background:none;border:none;font-size:1.1rem;color:var(--brown);cursor:pointer;padding:8px 0;width:100%;text-align:left;font-family:inherit;">
                👋 Logout (<?= htmlspecialchars(explode(' ', $user_name)[0]) ?>)
            </button>
        </form>
        <?php else: ?>
        <a href="form.php?redirect=<?= urlencode($_SERVER['REQUEST_URI']) ?>" onclick="closeMenu()">👤 Sign In</a>
        <?php endif; ?>
    </div>

    <section id="home">
        <div class="hero-bg"></div>
        <div class="hero-layout">
            <div class="hero-inner">
                <div class="hero-badge">Made in India • MSME Registered • Natural</div>
                <div class="hero-hindi">The Sacred Fragrance of a Temple — Now in Every Home</div>
                <h1 class="hero-title">Shuddh<br><span class="gold">Pooja</span> Spray</h1>
                <p class="hero-desc">A sacred blend of Ganga Jal, Sandalwood, and Camphor — for pure, positive energy in
                    your home, just like a temple. Just one spray!</p>
            </div>

            <div class="bottle-wrap">
                <div class="bottle-glow"></div>
                <div class="ing-tag" style="top:12%; left:2%; --td:3.2s;">💧 Ganga Jal</div>
                <div class="ing-tag" style="top:35%; right:4%; --td:4s;">🪵 Sandalwood</div>
                <div class="ing-tag" style="bottom:22%; left:4%; --td:2.8s;">🤍 Camphor</div>
                <div class="ing-tag" style="bottom:7%; right:15%; --td:3.6s;">🌿 Natural</div>
                <div class="ing-tag" style="top:0%; right:25%; --td:2.4s;">🌹 Gulab</div>

                <div class="bottle-svg-wrap">
                    <svg width="200" height="320" viewBox="0 0 200 340" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="bodyGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" stop-color="#e8c97a" />
                                <stop offset="30%" stop-color="#f5e4a0" />
                                <stop offset="60%" stop-color="#fffbe8" />
                                <stop offset="85%" stop-color="#f0d878" />
                                <stop offset="100%" stop-color="#c9960c" />
                            </linearGradient>
                            <linearGradient id="capGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#8B2500" />
                                <stop offset="50%" stop-color="#6B1A1A" />
                                <stop offset="100%" stop-color="#3D1C00" />
                            </linearGradient>
                            <linearGradient id="labelGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" stop-color="#fff8ee" />
                                <stop offset="100%" stop-color="#ffe8c0" />
                            </linearGradient>
                            <linearGradient id="shineGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" stop-color="rgba(255,255,255,0)" />
                                <stop offset="40%" stop-color="rgba(255,255,255,0.55)" />
                                <stop offset="100%" stop-color="rgba(255,255,255,0)" />
                            </linearGradient>
                            <filter id="shadow">
                                <feDropShadow dx="6" dy="12" stdDeviation="10" flood-color="rgba(100,50,0,0.3)" />
                            </filter>
                            <clipPath id="bottleClip">
                                <path
                                    d="M72,55 L65,80 Q55,90 55,110 L55,280 Q55,300 100,300 Q145,300 145,280 L145,110 Q145,90 135,80 L128,55 Z" />
                            </clipPath>
                        </defs>
                        <path
                            d="M72,55 L65,80 Q55,90 55,110 L55,280 Q55,300 100,300 Q145,300 145,280 L145,110 Q145,90 135,80 L128,55 Z"
                            fill="url(#bodyGrad)" filter="url(#shadow)" />
                        <rect x="60" y="120" width="80" height="130" rx="6" fill="url(#labelGrad)"
                            clip-path="url(#bottleClip)" />
                        <rect x="63" y="123" width="74" height="124" rx="4" fill="none" stroke="#C9960C"
                            stroke-width="1.2" clip-path="url(#bottleClip)" />
                        <text x="100" y="158" text-anchor="middle" font-family="serif" font-size="32" fill="#C9960C"
                            opacity="0.25">ॐ</text>
                        <text x="100" y="194" text-anchor="middle" font-family="Georgia,serif" font-size="13"
                            font-weight="900" fill="#3D1C00">Shuddh</text>
                        <text x="100" y="210" text-anchor="middle" font-family="Georgia,serif" font-size="10"
                            font-weight="900" fill="#FF6B00">Pooja Spray</text>
                        <line x1="72" y1="217" x2="128" y2="217" stroke="#C9960C" stroke-width="0.8" opacity="0.6" />
                        <text x="100" y="229" text-anchor="middle" font-family="Georgia,serif" font-size="5"
                            fill="#5a3a1a" opacity="0.8">Ganga Jal • Chandan • Camphor</text>
                        <rect x="55" y="55" width="25" height="245" rx="4" fill="url(#shineGrad)" opacity="0.5"
                            clip-path="url(#bottleClip)" />
                        <rect x="84" y="22" width="32" height="14" rx="4" fill="url(#capGrad)" />
                        <rect x="93" y="8" width="14" height="20" rx="3" fill="url(#capGrad)" />
                        <rect x="107" y="14" width="24" height="7" rx="3" fill="url(#capGrad)" />
                        <rect x="78" y="50" width="44" height="9" rx="3" fill="#C9960C" opacity="0.9" />
                        <rect x="80" y="52" width="40" height="5" rx="2" fill="#F2C94C" opacity="0.5" />
                        <ellipse cx="100" cy="295" rx="38" ry="5" fill="rgba(201,150,12,0.2)" />
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <div class="strip">
        <div class="strip-item">🌿 Natural Ingredients</div>
        <div class="strip-item">💧 Ganga Jal</div>
        <div class="strip-item">🚚 All India Delivery</div>
        <div class="strip-item">✅ MSME Certified</div>
    </div>

    <section id="products">
        <div class="reveal">
            <div class="sec-label">Our Products</div>
            <h2 class="sec-title">Shuddh Pooja Spray Range</h2>
            <div class="sec-hindi">Pure Pooja Spray</div>
        </div>
        <div class="products-grid">

            <!-- CHANDAN -->
            <div class="product-card featured reveal">
                <div class="badge-featured">Bestseller</div>
                <div class="product-emoji"><a href="product-detail.php?id=chandan" class="rem">🪵</a></div>
                <div class="product-name">Chandan</div>
                <div class="product-hindi">Sandalwood Pooja Spray</div>
                <div class="product-desc">Classic Sandalwood fragrance with Ganga Jal & Camphor. Perfect for every
                    prayer ritual.</div>
                <div class="product-price"><span>100ml</span></div>
                <a href="cart.php" class="btn-cart">🛒 Add to Cart</a>
            </div>

            <!-- MOGRA -->
            <div class="product-card reveal">
                <div class="product-emoji"><a href="product-detail.php?id=mogra" class="rem">🌸</a></div>
                <div class="product-name">Mogra</div>
                <div class="product-hindi">Jasmine Pooja Spray</div>
                <div class="product-desc">The sweet fragrance of Jasmine with Ganga Jal. Ideal for Ganesh ji and Lakshmi
                    ji worship.</div>
                <div class="product-price"><span>100ml</span></div>
                <a href="cart.php" class="btn-cart">🛒 Add to Cart</a>
            </div>

            <!-- GULAB -->
            <div class="product-card featured-gulab reveal">
                <div class="badge-featured">Bestseller</div>
                <div class="product-emoji"><a href="product-detail.php?id=gulab" class="rem">🌹</a></div>
                <div class="product-name">Gulab</div>
                <div class="product-hindi">Rose Pooja Spray</div>
                <div class="product-desc">The sacred fragrance of Rose with Ganga Jal. Perfect for Durga Mata and Ram ji
                    worship.</div>
                <div class="product-price"><span>100ml</span></div>
                <a href="cart.php" class="btn-cart">🛒 Add to Cart</a>
            </div>

            <!-- KEWDA -->
            <div class="product-card reveal">
                <div class="product-emoji"><a href="product-detail.php?id=kewda" class="rem">🌿</a></div>
                <div class="product-name">Kewda</div>
                <div class="product-hindi">Kewda Pooja Spray</div>
                <div class="product-desc">Traditional Kewda fragrance with Ganga Jal. The most beloved choice among Shiv
                    devotees.</div>
                <div class="product-price"><span>100ml</span></div>
                <a href="cart.php" class="btn-cart">🛒 Add to Cart</a>
            </div>

            <!-- CHAMPA -->
            <div class="product-card reveal">
                <div class="product-emoji"><a href="product-detail.php?id=champa" class="rem">🌼</a></div>
                <div class="product-name">Champa</div>
                <div class="product-hindi">Champa Pooja Spray</div>
                <div class="product-desc">Warm Champa fragrance with Ganga Jal. Specially used in Vishnu ji's worship
                    rituals.</div>
                <div class="product-price"><span>100ml</span></div>
                <a href="cart.php" class="btn-cart">🛒 Add to Cart</a>
            </div>

            <!-- OUD PREMIUM -->
            <div class="product-card premium reveal">
                <div class="badge-featured" style="background:linear-gradient(135deg,#333,#D4AF37);">✦ Premium</div>
                <div class="product-emoji">✨</div>
                <div class="product-name" style="color:#D4AF37;">Oud Premium</div>
                <div class="product-hindi" style="color:#B8960C;">Oud Premium Spray</div>
                <div class="product-desc" style="color:#ccc;">Luxury Oud fragrance with Ganga Jal. The best choice for
                    premium gifting.</div>
                <div class="product-price" style="color:#D4AF37;"><span style="color:#888;">100ml</span></div>
                <a href="cart.php" class="btn-cart">🛒 Add to Cart</a>
            </div>

        </div>
    </section>

    <section id="ingredients">
        <div class="reveal">
            <div class="sec-label">Sacred Ingredients</div>
            <h2 class="sec-title">What's Inside?</h2>
            <div class="sec-hindi">Pure & Natural Ingredients</div>
        </div>
        <div class="ing-grid">
            <div class="ing-card reveal">
                <div class="ing-icon">💧</div>
                <div class="ing-name">Ganga Jal</div>
                <div class="ing-hindi">गंगा जल</div>
                <div class="ing-desc">Sacred water of the Ganges — purifies and sanctifies your home. Eliminates
                    negative energy.</div>
            </div>
            <div class="ing-card reveal">
                <div class="ing-icon">🪵</div>
                <div class="ing-name">Sandalwood</div>
                <div class="ing-hindi">चंदन</div>
                <div class="ing-desc">Pure Sandalwood fragrance — brings positive energy and peace. Calms and soothes
                    the mind.</div>
            </div>
            <div class="ing-card reveal">
                <div class="ing-icon">🤍</div>
                <div class="ing-name">Camphor</div>
                <div class="ing-hindi">कपूर</div>
                <div class="ing-desc">Pure white Camphor — purifies the air. Eliminates bacteria and germs naturally.
                </div>
            </div>
            <div class="ing-card reveal">
                <div class="ing-icon">🧴</div>
                <div class="ing-name">Natural Base</div>
                <div class="ing-hindi">प्राकृतिक आधार</div>
                <div class="ing-desc">Distilled water and natural emulsifier — no harmful chemicals. A completely
                    skin-safe formula.</div>
            </div>
        </div>
    </section>

    <section id="order">
        <div class="reveal">
            <div class="sec-label">How to Order?</div>
            <h2 class="sec-title">3 Simple Steps</h2>
            <div class="sec-hindi">Order from the comfort of your home — just 3 easy steps</div>
        </div>
        <div class="steps-grid reveal">
            <div class="step-card">
                <div class="step-num">1</div>
                <div class="step-title">Message on WhatsApp</div>
                <div class="step-desc">Click the button below to get started.</div>
            </div>
            <div class="step-card">
                <div class="step-num">2</div>
                <div class="step-title">Choose Your Product</div>
                <div class="step-desc">Tell us which variant you want and the quantity required.</div>
            </div>
            <div class="step-card">
                <div class="step-num">3</div>
                <div class="step-title">Receive at Home</div>
                <div class="step-desc">After payment confirmation, your order will be delivered within 3–5 days!</div>
            </div>
        </div>
    </section>

    <section id="contact">
        <div style="text-align:center; max-width:600px; margin:0 auto;">
            <div class="reveal">
                <div class="sec-label">Ready to Order?</div>
                <h2 class="sec-title" style="color:var(--gold-light);">Bring the Temple Home</h2>
                <div class="sec-hindi">Place Your Order Now</div>
                <p style="font-size:1.1rem; line-height:1.8; opacity:0.85; margin-bottom:2rem;">Sign up or log in to
                    place your order. It takes just 30 seconds!</p>
                <?php if($logged_in): ?>
                <a href="cart.php" class="btn-primary"
                    style="font-size:1.2rem; padding:18px 48px; display:inline-block;">🛒 Go to Cart</a>
                <?php else: ?>
                <a href="form.php?redirect=cart.php" class="btn-primary"
                    style="font-size:1.2rem; padding:18px 48px; display:inline-block;">Sign In / Log In</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section id="about">
        <div class="about-grid">
            <div class="about-text reveal">
                <div class="sec-label">About Us</div>
                <h2 class="sec-title">Kaivalyamh Group</h2>
                <div class="sec-hindi">Our Story</div>
                <p>Kaivalyamh Group believes that every Indian home deserves the sacred purity of a temple. Shuddh Pooja
                    Spray is the result of this belief.</p>
                <p>Made from a sacred blend of Ganga Jal, Sandalwood, and Camphor, this spray fills your home with
                    purity, sanctity, and positive energy.</p>
                <ul class="about-values">
                    <li><span class="check">✓</span> MSME Registered Indian Brand</li>
                    <li><span class="check">✓</span> Natural Ingredients</li>
                    <li><span class="check">✓</span> No Harmful Chemicals</li>
                    <li><span class="check">✓</span> Ganga Jal</li>
                    <li><span class="check">✓</span> Made with Love in India</li>
                </ul>
            </div>
            <div class="about-visual reveal">
                <span class="om">ॐ</span>
                <div class="stats-grid">
                    <div class="stat">
                        <div class="num">6+</div>
                        <div class="lbl">Variants</div>
                    </div>
                    <div class="stat">
                        <div class="num">₹<?php echo $starting_price; ?></div>
                        <div class="lbl">Starting Price</div>
                    </div>
                    <div class="stat">
                        <div class="num">🇮🇳</div>
                        <div class="lbl">Made in India</div>
                    </div>
                    <div class="stat">
                        <div class="num">ALL</div>
                        <div class="lbl">India Delivery</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="contact-us" style="background:white;">
        <div class="reveal">
            <div class="sec-label">Get In Touch</div>
            <h2 class="sec-title">Contact Us</h2>
        </div>
        <div
            style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:20px; margin-top:1.5rem;">

            <!-- WhatsApp -->
            <div class="ing-card reveal" style="cursor:pointer;"
                onclick="window.open('https://wa.me/919979709769','_blank')">
                <div class="ing-icon">📲</div>
                <div class="ing-name">WhatsApp</div>
                <div class="ing-desc">Chat with us directly.<br>
                    <strong style="color:var(--wa);">+91 6356 411 281</strong>
                </div>
            </div>

            <!-- Email -->
            <div class="ing-card reveal" style="cursor:pointer;"
                onclick="window.location.href='mailto:kaivalyamh.grpofbrd@gmail.com'">
                <div class="ing-icon">📧</div>
                <div class="ing-name">Email</div>
                <div class="ing-desc">Email your query.<br>
                    <strong style="color:var(--saffron);">kaivalyamh.grpofbrd@gmail.com</strong>
                </div>
            </div>

            <!-- Location -->
            <div class="ing-card reveal">
                <div class="ing-icon">📍</div>
                <div class="ing-name">Location</div>
                <div class="ing-desc">
                    Kaivalyamh Group<br>
                    <strong style="color:var(--gold);">Surat, Gujarat, India 🇮🇳</strong>
                </div>
            </div>

        </div>
    </section>

    <footer>
        <div class="footer-logo">Kaivalyamh ✦ Shuddh Pooja Spray</div>
        <p>Shuddh Pooja Spray | MSME Registered | Made in India</p>
        <p style="margin-top:8px; font-size:0.75rem;">©️ <?php echo $current_year; ?> Kaivalyamh Group. All Rights
            Reserved.</p>
    </footer>

    <script>
    function toggleMenu() {
        document.getElementById('mobileMenu').classList.toggle('open');
    }

    function closeMenu() {
        document.getElementById('mobileMenu').classList.remove('open');
    }

    // User dropdown toggle
    function toggleDropdown() {
        document.getElementById('userDropdown').classList.toggle('open');
    }

    // Dropdown band ho jaye agar bahar click karo
    document.addEventListener('click', function(e) {
        const wrap = document.querySelector('.nav-user-wrap');
        if (wrap && !wrap.contains(e.target)) {
            const dd = document.getElementById('userDropdown');
            if (dd) dd.classList.remove('open');
        }
    });

    const reveals = document.querySelectorAll('.reveal');
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) e.target.classList.add('visible');
        });
    }, {
        threshold: 0.1
    });
    reveals.forEach(r => obs.observe(r));

    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const t = document.querySelector(a.getAttribute('href'));
            if (t) {
                e.preventDefault();
                t.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // ── PHP session ko localStorage ke saath sync karo ──
    (function() {
        <?php if($logged_in): ?>
        // User logged in hai — localStorage update karo
        localStorage.setItem('kmh_session', JSON.stringify({
            name: "<?= addslashes(htmlspecialchars($user_name)) ?>",
            id: "<?= (int)$_SESSION['user_id'] ?>"
        }));
        <?php else: ?>
        // User logged out hai — localStorage clean karo
        localStorage.removeItem('kmh_session');
        <?php endif; ?>
    })();

    // ── Welcome toast agar ?welcome=1 aaya (signup ke baad) ──
    (function() {
        const params = new URLSearchParams(window.location.search);
        if (params.get('welcome') === '1') {
            <?php if($logged_in): ?>
            const toast = document.createElement('div');
            toast.style.cssText =
                'position:fixed;bottom:30px;left:50%;transform:translateX(-50%);background:linear-gradient(135deg,var(--saffron),var(--gold));color:white;padding:14px 28px;border-radius:40px;z-index:9999;font-weight:700;font-size:0.95rem;box-shadow:0 8px 25px rgba(255,107,0,0.4);transition:opacity 0.7s;';
            toast.textContent =
            '🙏 Swagat hai, <?= addslashes(htmlspecialchars(explode(' ', $user_name)[0])) ?>ji!';
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
            }, 3500);
            setTimeout(() => {
                toast.remove();
            }, 4200);
            <?php endif; ?>
            // URL se ?welcome=1 hata do
            history.replaceState({}, '', window.location.pathname);
        }
    })();
    </script>
</body>

</html>