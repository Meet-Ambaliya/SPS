<?php
/* Dynamic Product Detail Page - Full Page Entrance Animation Version */

// 1. Data Dictionary
$products = [
    'chandan' => [
        'label_name' => 'Chandan',
        'title' => 'Chandan Pooja Spray - 100% Pure Sandalwood with Ganga Jal & Camphor',
        'hindi' => 'चंदन पूजा स्प्रे',
        'price' => 99,
        'desc' => 'Bring the soul-soothing aroma of sacred Sandalwood into your home. Infused with authentic Ganga Jal and pure Camphor, this spray is designed to create a meditative atmosphere instantly.',
        'features' => ['100% Alcohol-Free', 'Pure Ganga Jal Base', 'Skin Safe & Natural']
    ],
    'mogra' => [
        'label_name' => 'Mogra',
        'title' => 'Mogra Pooja Spray - Divine Jasmine Aroma for Spiritual Purity',
        'hindi' => 'मोगरा पूजा स्प्रे',
        'price' => 99,
        'desc' => 'The divine scent of blooming Jasmine (Mogra) is traditionally used to welcome Goddess Lakshmi. This refreshing spray clears stagnant energy and fills your space with floral purity.',
        'features' => ['Authentic Jasmine Aroma', 'Perfect for morning Pooja', 'MSME Certified', 'Natural Emulsifiers']
    ],
    'gulab' => [
        'label_name' => 'Gulab',
        'title' => 'Gulab Pooja Spray - Fresh Rose Essence for Rituals',
        'hindi' => 'गुलाब पूजा स्प्रे',
        'price' => 99,
        'desc' => 'Capturing the essence of fresh Indian Gulab. Rose is known for its heart-opening properties and is used in almost every sacred ritual across India.',
        'features' => ['Premium Rose Extract', 'Ganga Jal Infused', 'Calming Properties', 'No Synthetic Gas']
    ],
    'kewda' => [
        'label_name' => 'Kewda',
        'title' => 'Kewda Pooja Spray - Traditional Earthy Fragrance for Meditation',
        'hindi' => 'केवड़ा पूजा स्प्रे',
        'price' => 99,
        'desc' => 'The traditional fragrance of Kewda is highly beloved by Lord Shiva. This earthy, sweet aroma is perfect for deep spiritual practices.',
        'features' => ['Earthy Fragrance', 'Traditional Blend', 'Safe for Fabrics', 'Pure Ingredients']
    ],
    'champa' => [
        'label_name' => 'Champa',
        'title' => 'Champa Pooja Spray - Warm Floral Fragrance for Vishnu Worship',
        'hindi' => 'चंपा पूजा स्प्रे',
        'price' => 99,
        'desc' => 'Warm Champa fragrance with Ganga Jal. Specially used in Vishnu ji\'s worship rituals. The sacred scent of Champa flowers fills your home with divine energy and peace.',
        'features' => ['Authentic Champa Aroma', 'Ganga Jal Infused', 'No Harmful Chemicals']
    ],
];

$id = isset($_GET['id']) ? $_GET['id'] : 'chandan';
$p = array_key_exists($id, $products) ? $products[$id] : $products['chandan'];
$current_year = date("Y");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $p['label_name']; ?> | Kaivalyamh</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Cormorant+Garamond:wght@400;600;700&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
    :root {
        --saffron: #FF6B00;
        --gold: #C9960C;
        --deep-red: #6B1A1A;
        --cream: #FFF8EE;
        --brown: #3D1C00;
        --liquid-brown: linear-gradient(135deg, #8B4513 0%, #D2691E 50%, #5C3317 100%);
        --glass-shine: linear-gradient(to right, rgba(255, 255, 255, 0.4) 0%, rgba(255, 255, 255, 0.1) 50%, rgba(255, 255, 255, 0.4) 100%);
    }

    html {
        scroll-behavior: smooth;
        height: 100%;
    }

    body {
        margin: 0;
        padding: 75px 0 0 0;
        background: var(--cream);
        font-family: 'Cormorant Garamond', serif;
        color: var(--brown);
        overflow-x: hidden;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    /* --- FULL PAGE ENTRANCE ANIMATION --- */
    @keyframes pageFadeIn {
        0% {
            opacity: 0;
            transform: translateY(30px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .main-wrapper {
        animation: pageFadeIn 1.2s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .main-wrapper .container {
        flex: 1;
    }

    /* --- Fixed Navigation --- */
    .nav-simple {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        box-sizing: border-box;
        padding: 15px 5%;
        background: rgba(255, 248, 238, 0.98);
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(201, 150, 12, 0.3);
        backdrop-filter: blur(5px);
    }

    .brand-name {
        font-family: 'Playfair Display', serif;
        font-weight: 900;
        color: var(--deep-red);
        font-size: 1.5rem;
    }

    .nav-simple a {
        text-decoration: none;
        color: var(--gold);
        font-weight: 700;
        font-size: 0.9rem;
    }

    /* --- Layout Container --- */
    .container {
        max-width: 1400px;
        margin: 20px auto;
        padding: 0 3%;
        display: grid;
        grid-template-columns: 0.8fr 1.2fr;
        gap: 30px;
        align-items: start;
    }

    /* --- Bottle Visual & Floating --- */
    @keyframes float {

        0%,
        100% {
            transform: translateY(0px) rotateY(-5deg);
        }

        50% {
            transform: translateY(-20px) rotateY(5deg);
        }
    }

    .bottle-visual {
        position: sticky;
        top: 100px;
        display: flex;
        justify-content: flex-start;
    }

    .bottle-backdrop {
        background-color: white;
        padding: 60px 50px;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.03);
        display: flex;
        justify-content: center;
        align-items: center;
        border: 1px solid #f0f0f0;
        width: 100%;
    }

    .bottle-container {
        width: 170px;
        position: relative;
        animation: float 6s ease-in-out infinite;
        transform-style: preserve-3d;
    }

    /* Bottle Design Parts */
    .sprayer-head {
        width: 45px;
        height: 55px;
        background: #fff;
        margin: 0 auto;
        border-radius: 5px;
        border: 1px solid #ddd;
        position: relative;
        z-index: 5;
    }

    .nozzle {
        width: 12px;
        height: 10px;
        background: #eee;
        position: absolute;
        right: -7px;
        top: 12px;
        border-radius: 0 3px 3px 0;
    }

    .sprayer-neck {
        width: 60px;
        height: 15px;
        background: #fff;
        border: 1px solid #ddd;
        margin: -5px auto 0;
        border-radius: 3px;
        position: relative;
        z-index: 4;
    }

    .bottle-body {
        width: 100%;
        height: 360px;
        background: var(--liquid-brown);
        border-radius: 60px 60px 25px 25px;
        border: 3px solid rgba(255, 255, 255, 0.4);
        position: relative;
        box-shadow: 20px 30px 40px rgba(0, 0, 0, 0.1), inset 0 0 20px rgba(0, 0, 0, 0.3);
        display: flex;
        flex-direction: column;
        align-items: center;
        padding-top: 60px;
        overflow: hidden;
    }

    .bottle-body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: var(--glass-shine);
        z-index: 3;
        opacity: 0.6;
    }

    .vintage-label {
        width: 125px;
        height: 220px;
        background: #fdf5e6;
        border: 1.5px solid #b8860b;
        z-index: 10;
        padding: 15px 5px;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    /* --- Product Details --- */
    .product-details {
        padding-top: 10px;
        border-left: 1px solid #eee;
        padding-left: 30px;
    }

    .brand-link {
        color: #007185;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
    }

    .product-title {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 900;
        color: var(--deep-red);
        margin: 5px 0 10px 0;
        line-height: 1.2;
    }

    .hindi-title {
        font-family: 'Cormorant Garamond', serif;
        color: var(--gold);
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .divider {
        border-top: 1px solid #eee;
        margin: 20px 0;
    }

    .price-tag {
        font-size: 2.5rem;
        color: #B12704;
        font-weight: 700;
    }

    .price-tg {
        font-size: 1.3rem;
        font-weight: 900;
        text-decoration: line-through;
    }

    .feature-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .feature-list li {
        margin-bottom: 10px;
        padding-left: 20px;
        position: relative;
        font-size: 16px;
        line-height: 1.6;
    }

    .feature-list li::before {
        content: "✓";
        position: absolute;
        left: 0;
        color: var(--gold);
        font-weight: 900;
    }

    .btn-whatsapp {
        background: #25D366;
        color: white;
        padding: 15px 20px;
        text-decoration: none;
        border-radius: 30px;
        font-size: 1.1rem;
        font-weight: 700;
        display: block;
        text-align: center;
        transition: transform 0.3s;
    }

    .btn-whatsapp:hover {
        transform: translateY(-3px);
        background: #1eb954;
    }

    /* FOOTER */
    footer {
        background: #1a0a00;
        /* Dark background */
        color: rgba(255, 255, 255, 0.55);
        /* Muted white text */
        text-align: center;
        padding: 28px 5%;
        font-family: 'Cormorant Garamond', serif;
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
        line-height: 1.5;
    }

    footer a {
        color: var(--gold);
        text-decoration: none;
    }

    /* ══════════════════════════════════════
       RESPONSIVE — sabhi devices ke liye
       ══════════════════════════════════════ */

    /* ── Tablet: 1024px ── */
    @media(max-width:1024px) {
        .container {
            grid-template-columns: 1fr 1.3fr;
            gap: 24px;
            padding: 0 4%;
        }

        .bottle-backdrop {
            padding: 40px 30px;
        }

        .product-title {
            font-size: 1.7rem;
        }

        .hindi-title {
            font-size: 1.3rem;
        }

        .price-tag {
            font-size: 2rem;
        }
    }

    /* ── Mobile: 900px (existing breakpoint enhanced) ── */
    @media(max-width:900px) {
        body {
            padding-top: 65px;
        }

        .nav-simple {
            padding: 12px 5%;
        }

        .brand-name {
            font-size: 1.3rem;
        }

        .nav-simple a {
            font-size: 0.82rem;
        }

        .container {
            grid-template-columns: 1fr;
            margin: 16px auto;
            padding: 0 4%;
            gap: 24px;
        }

        /* Bottle — center karo, sticky hatao */
        .bottle-visual {
            position: relative;
            top: 0;
            justify-content: center;
        }

        .bottle-backdrop {
            padding: 36px 24px;
        }

        .bottle-container {
            width: 150px;
        }

        .bottle-body {
            height: 310px;
        }

        .vintage-label {
            width: 110px;
            height: 190px;
        }

        /* Product details — left border hatao */
        .product-details {
            border-left: none;
            padding-left: 0;
            padding-top: 0;
        }

        .product-title {
            font-size: 1.6rem;
        }

        .hindi-title {
            font-size: 1.2rem;
        }

        .price-tag {
            font-size: 2rem;
        }

        .feature-list li {
            font-size: 15px;
        }
    }

    /* ── Mobile: 768px ── */
    @media(max-width:768px) {
        body {
            padding-top: 60px;
        }

        .nav-simple {
            padding: 11px 5%;
        }

        .brand-name {
            font-size: 1.2rem;
        }

        .container {
            padding: 0 4%;
            gap: 20px;
        }

        .bottle-backdrop {
            padding: 28px 20px;
        }

        .bottle-container {
            width: 135px;
        }

        .bottle-body {
            height: 280px;
            padding-top: 45px;
        }

        .vintage-label {
            width: 100px;
            height: 170px;
            padding: 10px 4px;
        }

        .vintage-label h3 {
            font-size: 1.1rem !important;
        }

        .product-title {
            font-size: 1.45rem;
            line-height: 1.25;
        }

        .hindi-title {
            font-size: 1.1rem;
            margin-bottom: 12px;
        }

        .price-tag {
            font-size: 1.8rem;
        }

        .price-tg {
            font-size: 1.1rem;
        }

        .feature-list li {
            font-size: 14px;
            margin-bottom: 8px;
        }

        .divider {
            margin: 14px 0;
        }

        .btn-whatsapp {
            font-size: 1rem;
            padding: 13px 16px;
        }

        footer {
            padding: 22px 5%;
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
        body {
            padding-top: 58px;
        }

        .nav-simple {
            padding: 10px 4%;
        }

        .brand-name {
            font-size: 1.1rem;
        }

        .nav-simple a {
            font-size: 0.76rem;
        }

        .container {
            padding: 0 4%;
            gap: 18px;
            margin: 12px auto;
        }

        .bottle-backdrop {
            padding: 22px 16px;
            border-radius: 12px;
        }

        .bottle-container {
            width: 120px;
        }

        .bottle-body {
            height: 250px;
            padding-top: 38px;
            border-radius: 50px 50px 20px 20px;
        }

        .sprayer-head {
            width: 38px;
            height: 46px;
        }

        .sprayer-neck {
            width: 50px;
            height: 13px;
        }

        .vintage-label {
            width: 88px;
            height: 150px;
            padding: 8px 3px;
        }

        .vintage-label h3 {
            font-size: 0.95rem !important;
        }

        .product-title {
            font-size: 1.25rem;
        }

        .hindi-title {
            font-size: 1rem;
        }

        .brand-link {
            font-size: 12px;
        }

        .price-tag {
            font-size: 1.6rem;
        }

        .price-tg {
            font-size: 1rem;
        }

        .feature-list li {
            font-size: 13px;
            padding-left: 16px;
        }

        .btn-whatsapp {
            font-size: 0.95rem;
            padding: 12px 14px;
            border-radius: 25px;
        }

        .divider {
            margin: 12px 0;
        }

        footer {
            padding: 18px 4%;
        }

        .footer-logo {
            font-size: 1rem;
        }

        footer p {
            font-size: 0.73rem;
        }
    }

    /* ── Very Small: 360px ── */
    @media(max-width:360px) {
        .brand-name {
            font-size: 1rem;
        }

        .nav-simple a {
            font-size: 0.7rem;
        }

        .product-title {
            font-size: 1.15rem;
        }

        .bottle-container {
            width: 110px;
        }

        .bottle-body {
            height: 230px;
        }

        .vintage-label {
            width: 80px;
            height: 138px;
        }

        .price-tag {
            font-size: 1.45rem;
        }
    }
    </style>
</head>

<body>

    <nav class="nav-simple">
        <a href="index.php" style="text-decoration:none;">
            <div class="brand-name">Kaivalyamh</div>
        </a>
        <a href="index.php">Back to Home →</a>
    </nav>

    <div class="main-wrapper">
        <div class="container">
            <div class="bottle-visual">
                <div class="bottle-backdrop">
                    <div class="bottle-container">
                        <div class="sprayer-head">
                            <div class="nozzle"></div>
                        </div>
                        <div class="sprayer-neck"></div>
                        <div class="bottle-body">
                            <div class="vintage-label">
                                <div>
                                    <h3
                                        style="font-family:'Playfair Display'; margin:0; font-size:1.3rem; color:#4a2111;">
                                        <?php echo $p['label_name']; ?></h3>
                                    <p
                                        style="font-size:0.5rem; letter-spacing:1px; margin:0; text-transform:uppercase; color:#8b4513;">
                                        Pooja Spray</p>
                                </div>
                                <div style="font-size:2.5rem; color:#b8860b;">ॐ</div>
                                <div
                                    style="font-size:0.6rem; border-top:1px solid #b8860b; padding-top:5px; font-weight:bold; color:#4a2111;">
                                    100% PURE</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="product-details">
                <a href="#" class="brand-link">Visit the Kaivalyamh Store</a>
                <h1 class="product-title"><?php echo $p['title']; ?></h1>
                <div class="hindi-title"><?php echo isset($p['hindi']) ? $p['hindi'] : ''; ?></div>

                <div class="divider"></div>
                <div class="price-container">
                    <span style="font-size:14px; vertical-align:top; color:#565959;">M.R.P:</span>
                    <span class="price-tag">₹<?php echo $p['price']; ?>.00</span>
                    <span class="price-tg"> ₹ 199</span>
                </div>
                <div class="divider"></div>

                <div class="about-section">
                    <h3
                        style="font-family:'Playfair Display',serif; font-size:1.2rem; color:var(--deep-red); font-weight:700; margin-bottom:15px;">
                        About this item</h3>
                    <ul class="feature-list">
                        <?php foreach($p['features'] as $f): ?>
                        <li><?php echo $f; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div
                    style="font-size:1.1rem; line-height:1.8; margin-top:30px; border-top:1px solid #f0f0f0; padding-top:20px; color:#444;">
                    <?php echo $p['desc']; ?>
                </div>
            </div>
        </div>

        <footer>
            <div class="footer-logo">Kaivalyamh ✦ Shuddh Pooja Spray</div>
                <p>Shuddh Pooja Spray | MSME Registered | Made in India</p>
            <p style="margin-top:8px; font-size:0.75rem;">
                ©️ <?php echo $current_year; ?> Kaivalyamh Group. All Rights Reserved.
            </p>
        </footer>
    </div>

</body>

</html>