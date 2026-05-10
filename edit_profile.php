<?php
/* Kaivalyamh - Edit Profile */
if(!session_id()) session_start();

// Login check
if(!isset($_SESSION['user_id'])){
    header("Location: form.php?redirect=edit-profile.php");
    exit;
}

$conn = mysqli_connect("localhost","root","","shudh_puja");
if(!$conn) die("Connection failed: " . mysqli_connect_error());

$user_id   = (int)$_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? '';
$logged_in = true;

$error_msg   = '';
$success_msg = '';

// ── Current user data DB se fetch karo ────────────
$res  = mysqli_query($conn, "SELECT name, phone, email, address FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($res);

// ── Update Logic ───────────────────────────────────
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $new_name  = trim(mysqli_real_escape_string($conn, $_POST['name']  ?? ''));
    $new_phone = trim(mysqli_real_escape_string($conn, $_POST['phone'] ?? ''));
    $new_email = trim(mysqli_real_escape_string($conn, $_POST['email'] ?? ''));
    $new_addr  = trim(mysqli_real_escape_string($conn, $_POST['addr']  ?? ''));

    // Validation
    if(empty($new_name)){
        $error_msg = "Name cannot be empty";
    } elseif(strlen($new_phone) !== 10 || !ctype_digit($new_phone)){
        $error_msg = "Phone number must be 10 digits long";
    } elseif(!filter_var($new_email, FILTER_VALIDATE_EMAIL)){
        $error_msg = "Enter Valid email Address !.";
    } elseif(empty($new_addr)){
        $error_msg = "Address cannot be empty";
    } else {
        // Check email/phone duplicate (dusre users mein)
        $check = mysqli_query($conn,
            "SELECT id FROM users WHERE (phone='$new_phone' OR email='$new_email') AND id != '$user_id'"
        );
        if(mysqli_num_rows($check) > 0){
            $error_msg = "This phone or email is already registered to another account.";
        } else {
            $sql = "UPDATE users SET
                        name    = '$new_name',
                        phone   = '$new_phone',
                        email   = '$new_email',
                        address = '$new_addr'
                    WHERE id = '$user_id'";

            if(mysqli_query($conn, $sql)){
                // Session update karo
                $_SESSION['user_name'] = $new_name;
                $_SESSION['user_addr'] = $new_addr;
                $user_name = $new_name;

                // Reload karo taaza data ke liye
                $res  = mysqli_query($conn, "SELECT name, phone, email, address FROM users WHERE id='$user_id'");
                $user = mysqli_fetch_assoc($res);

                $success_msg = "Profile is successfully update ! ";
            } else {
                $error_msg = "It hasn't updated. Please try again..";
            }
        }
    }
}

$current_year = date("Y");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | Kaivalyamh</title>
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
        height: 100%;
    }

    body {
        background: var(--cream);
        font-family: 'Cormorant Garamond', serif;
        color: var(--brown);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        overflow-x: hidden;
    }

    /* BG OM */
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

    /* NAV USER DROPDOWN */
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
        cursor: pointer;
        user-select: none;
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

    .nav-user-wrap {
        position: relative;
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

    /* PAGE */
    .page {
        position: relative;
        z-index: 1;
        flex: 1;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding: 40px 5%;
    }

    /* CARD */
    .form-card {
        background: white;
        border: 1px solid rgba(201, 150, 12, 0.2);
        border-radius: 24px;
        padding: 40px 36px;
        width: 100%;
        max-width: 540px;
        box-shadow: 0 10px 40px rgba(61, 28, 0, 0.07);
        animation: fadeUp 0.7s ease both;
    }

    /* AVATAR CIRCLE */
    .profile-avatar-wrap {
        text-align: center;
        margin-bottom: 24px;
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--saffron), var(--gold));
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-family: 'Playfair Display', serif;
        font-size: 2.2rem;
        font-weight: 900;
        color: white;
        box-shadow: 0 8px 24px rgba(255, 107, 0, 0.3);
        margin-bottom: 10px;
    }

    .profile-greeting {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        font-weight: 900;
        color: var(--deep-red);
        margin-bottom: 2px;
    }

    .profile-sub {
        font-family: 'Tiro Devanagari Hindi', serif;
        font-size: 0.9rem;
        color: var(--gold);
    }

    /* DIVIDER */
    .divider {
        border: none;
        border-top: 1px solid rgba(201, 150, 12, 0.18);
        margin: 22px 0;
    }

    /* FORM FIELDS */
    .fg {
        margin-bottom: 18px;
    }

    .fg label {
        display: block;
        font-size: 0.7rem;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #888;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .fg input,
    .fg textarea {
        width: 100%;
        background: var(--cream);
        border: 1.5px solid rgba(201, 150, 12, 0.25);
        border-radius: 10px;
        padding: 12px 16px;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1rem;
        color: var(--brown);
        outline: none;
        transition: border-color 0.25s, background 0.25s;
    }

    .fg input:focus,
    .fg textarea:focus {
        border-color: var(--gold);
        background: white;
    }

    .fg textarea {
        resize: vertical;
        min-height: 85px;
    }

    /* TWO COLUMN ROW */
    .fg-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    /* ALERTS */
    .alert {
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 700;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
        line-height: 1.5;
    }

    .alert-error {
        background: rgba(220, 38, 38, 0.07);
        color: #dc2626;
        border: 1px solid rgba(220, 38, 38, 0.2);
    }

    .alert-success {
        background: rgba(34, 197, 94, 0.07);
        color: #16a34a;
        border: 1px solid rgba(34, 197, 94, 0.2);
    }

    /* SUBMIT BUTTON */
    .btn-submit {
        width: 100%;
        background: linear-gradient(135deg, var(--saffron), #e05500);
        color: white;
        border: none;
        padding: 15px;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem;
        font-weight: 700;
        border-radius: 12px;
        cursor: pointer;
        margin-top: 6px;
        box-shadow: 0 6px 20px rgba(255, 107, 0, 0.3);
        transition: all 0.3s;
        letter-spacing: 0.5px;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(255, 107, 0, 0.4);
    }

    .back-link {
        display: block;
        text-align: center;
        margin-top: 18px;
        color: var(--gold);
        font-weight: 700;
        font-size: 0.9rem;
        text-decoration: none;
    }

    .back-link:hover {
        color: var(--saffron);
    }

    /* FOOTER */
    footer {
        background: #1a0a00;
        color: rgba(255, 255, 255, 0.55);
        text-align: center;
        padding: 22px 5%;
        font-size: 0.85rem;
    }

    .footer-logo {
        font-family: 'Playfair Display', serif;
        font-size: 1.2rem;
        font-weight: 900;
        color: var(--gold);
        margin-bottom: 6px;
    }

    footer p {
        font-size: 0.78rem;
        margin: 3px 0;
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

    /* RESPONSIVE */
    @media(max-width:600px) {
        nav {
            padding: 0 4%;
            height: 58px;
        }

        .nav-logo {
            font-size: 1.2rem;
        }

        .nav-back {
            font-size: 0.85rem;
        }

        .page {
            padding: 24px 4%;
            align-items: flex-start;
        }

        .form-card {
            padding: 24px 18px;
            border-radius: 18px;
        }

        .fg-row {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .profile-greeting {
            font-size: 1.3rem;
        }

        .profile-avatar {
            width: 68px;
            height: 68px;
            font-size: 1.8rem;
        }
    }
    </style>
</head>

<body>

    <!-- NAV -->
    <nav>
        <a href="index.php" class="nav-logo">Kaivalyamh</a>
        <div class="nav-right">
            <a href="index.php" class="nav-back">← Go to Home</a>
            <div class="nav-user-wrap">
            </div>
        </div>
    </nav>

    <div class="page">
        <div class="form-card">

            <!-- Avatar + Greeting -->
            <div class="profile-avatar-wrap">
                <div class="profile-avatar"><?= strtoupper(substr($user_name,0,1)) ?></div>
                <div class="profile-greeting"><?= htmlspecialchars(explode(' ',$user_name)[0]) ?></div>
                <div class="profile-sub">Update your profile</div>
            </div>

            <hr class="divider">

            <!-- Alerts -->
            <?php if($error_msg): ?>
            <div class="alert alert-error">⚠️ <?= htmlspecialchars($error_msg) ?></div>
            <?php endif; ?>
            <?php if($success_msg): ?>
            <div class="alert alert-success">✅ <?= htmlspecialchars($success_msg) ?></div>
            <?php endif; ?>

            <!-- Form -->
            <form method="POST" onsubmit="return validateForm()">

                <!-- Name + Phone -->
                <div class="fg-row">
                    <div class="fg">
                        <label>Full Name</label>
                        <input type="text" name="name" id="fName" value="<?= htmlspecialchars($user['name'] ?? '') ?>"
                            placeholder="Aapka poora naam" oninput="this.value=this.value.replace(/[^a-zA-Z\s]/g,'')"
                            required>
                    </div>
                    <div class="fg">
                        <label>WhatsApp Number</label>
                        <input type="text" name="phone" id="fPhone"
                            value="<?= htmlspecialchars($user['phone'] ?? '') ?>" maxlength="10"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'')" placeholder="10 digit number"
                            required>
                    </div>
                </div>

                <!-- Email -->
                <div class="fg">
                    <label>Email Address</label>
                    <input type="email" name="email" id="fEmail" value="<?= htmlspecialchars($user['email'] ?? '') ?>"
                        placeholder="example@gmail.com" style="text-transform:none;" required>
                </div>

                <!-- Address -->
                <div class="fg">
                    <label>Delivery Address</label>
                    <textarea name="addr" id="fAddr" placeholder="Street, City, State, Pincode"
                        required><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                </div>

                <button type="submit" class="btn-submit"> Update Profile</button>
            </form>

            <a href="index.php" class="back-link">← Return</a>
        </div>
    </div>

    <footer>
        <div class="footer-logo">Kaivalyamh ✦ Shuddh Pooja Spray</div>
        <p>MSME Registered | Made in India</p>
        <p>©️ <?= $current_year ?> Kaivalyamh Group. All Rights Reserved.</p>
    </footer>

    <script>
    function toggleDropdown() {
        document.getElementById('userDropdown').classList.toggle('open');
    }
    document.addEventListener('click', function(e) {
        const wrap = document.querySelector('.nav-user-wrap');
        if (wrap && !wrap.contains(e.target)) {
            document.getElementById('userDropdown').classList.remove('open');
        }
    });

    function validateForm() {
        const phone = document.getElementById('fPhone').value;
        if (phone.length !== 10) {
            alert('WhatsApp number should be 10 digits long!');
            return false;
        }
        return true;
    }

    // Session localStorage sync
    localStorage.setItem('kmh_session', JSON.stringify({
        name: "<?= addslashes(htmlspecialchars($user_name)) ?>",
        id: "<?= $user_id ?>"
    }));
    </script>
</body>

</html>