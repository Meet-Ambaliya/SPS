<?php
/* Kaivalyamh - Change Password */
if(!session_id()) session_start();

// Login check
if(!isset($_SESSION['user_id'])){
    header("Location: form.php?redirect=change-password.php");
    exit;
}

$conn = mysqli_connect("localhost","root","","shudh_puja");
if(!$conn) die("Connection failed: " . mysqli_connect_error());

$user_id   = (int)$_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? '';
$logged_in = true;

$error_msg   = '';
$success_msg = '';

// ── Password Change Logic ──────────────────────
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $old_pass  = $_POST['old_pass']  ?? '';
    $new_pass  = $_POST['new_pass']  ?? '';
    $conf_pass = $_POST['conf_pass'] ?? '';

    // Purana password DB se fetch karo
    $res = mysqli_query($conn, "SELECT password FROM users WHERE id='$user_id'");
    $row = mysqli_fetch_assoc($res);

    if(!$row){
        $error_msg = "User not found Please Log in/Sign in";
    } elseif(!password_verify($old_pass, $row['password'])){
        $error_msg = "Your old Password is Wrong !";
    } elseif(strlen($new_pass) < 6){
        $error_msg = "Min 6 Character requied for new password";
    } elseif($new_pass !== $conf_pass){
        $error_msg = "New password is not same as confirm password!";
    } elseif(password_verify($new_pass, $row['password'])){
        $error_msg = "New password is not same as old password !";
    } else {
        $hashed = password_hash($new_pass, PASSWORD_DEFAULT);
        $hashed_esc = mysqli_real_escape_string($conn, $hashed);
        if(mysqli_query($conn, "UPDATE users SET password='$hashed_esc' WHERE id='$user_id'")){
            $success_msg = "Password is successfully Changed ! 🎉";
        } else {
            $error_msg = "Password is not changed , please try again ! ";
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
    <title>Change Password | Kaivalyamh</title>
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

    /* NAV USER */
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
        align-items: center;
        justify-content: center;
        padding: 40px 5%;
    }

    /* FORM CARD */
    .form-card {
        background: white;
        border: 1px solid rgba(201, 150, 12, 0.2);
        border-radius: 24px;
        padding: 40px 36px;
        width: 100%;
        max-width: 480px;
        box-shadow: 0 10px 40px rgba(61, 28, 0, 0.07);
        animation: fadeUp 0.7s ease both;
    }

    .card-icon {
        font-size: 2.5rem;
        text-align: center;
        margin-bottom: 10px;
    }

    .card-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        font-weight: 900;
        color: var(--deep-red);
        text-align: center;
        margin-bottom: 4px;
    }

    .card-sub {
        font-family: 'Tiro Devanagari Hindi', serif;
        font-size: 0.95rem;
        color: var(--gold);
        text-align: center;
        margin-bottom: 28px;
    }

    /* FORM FIELDS */
    .fg {
        margin-bottom: 18px;
        position: relative;
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

    .fg input {
        width: 100%;
        background: var(--cream);
        border: 1.5px solid rgba(201, 150, 12, 0.25);
        border-radius: 10px;
        padding: 12px 44px 12px 16px;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1rem;
        color: var(--brown);
        outline: none;
        transition: border-color 0.25s, background 0.25s;
    }

    .fg input:focus {
        border-color: var(--gold);
        background: white;
    }

    .toggle-eye {
        position: absolute;
        right: 14px;
        top: 35px;
        cursor: pointer;
        font-size: 1rem;
        color: #bbb;
        transition: color 0.2s;
        background: none;
        border: none;
        line-height: 1;
    }

    .toggle-eye:hover {
        color: var(--gold);
    }

    /* STRENGTH BAR */
    .strength-wrap {
        margin-top: 6px;
    }

    .strength-bar {
        height: 4px;
        border-radius: 4px;
        background: #eee;
        overflow: hidden;
        margin-bottom: 4px;
    }

    .strength-fill {
        height: 100%;
        border-radius: 4px;
        width: 0%;
        transition: width 0.3s, background 0.3s;
    }

    .strength-text {
        font-size: 0.7rem;
        font-weight: 700;
        color: #aaa;
    }

    /* ALERTS */
    .alert {
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 0.88rem;
        font-weight: 700;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .alert-error {
        background: rgba(220, 38, 38, 0.08);
        color: #dc2626;
        border: 1px solid rgba(220, 38, 38, 0.2);
    }

    .alert-success {
        background: rgba(34, 197, 94, 0.08);
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

        .page {
            padding: 28px 4%;
            align-items: flex-start;
        }

        .form-card {
            padding: 28px 20px;
            border-radius: 18px;
        }

        .card-title {
            font-size: 1.5rem;
        }
    }
    </style>
</head>

<body>

    <nav>
        <a href="index.php" class="nav-logo">Kaivalyamh</a>
        <div class="nav-right">
            <a href="index.php" class="nav-back">← Back To Home</a>
            <div class="nav-user-wrap">
                <div class="nav-user" onclick="toggleDropdown()">
                    <div class="user-avatar"><?= strtoupper(substr($user_name,0,1)) ?></div>
                    <span><?= htmlspecialchars(explode(' ',$user_name)[0]) ?></span>
                </div>
                <div class="user-dropdown" id="userDropdown">
                    <!-- <a href="change-password.php">🔒 Change Password</a> -->
                    <a href="edit_profile.php">✏️ Edit Profile</a>
                    <form method="POST" action="form.php" style="margin:0;">
                        <input type="hidden" name="action" value="logout">
                        <button type="submit" class="dd-logout">🚪 Log Out</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="page">
        <div class="form-card">
            <div class="card-icon">🔒</div>
            <div class="card-title">Change Password</div>
            <div class="card-sub">Change Your Password here !</div>

            <?php if($error_msg): ?>
            <div class="alert alert-error">⚠️ <?= htmlspecialchars($error_msg) ?></div>
            <?php endif; ?>

            <?php if($success_msg): ?>
            <div class="alert alert-success">✅ <?= htmlspecialchars($success_msg) ?></div>
            <?php endif; ?>

            <?php if(!$success_msg): ?>
            <form method="POST">

                <div class="fg">
                    <label>Enter Old Password</label>
                    <input type="password" name="old_pass" id="oldPass" placeholder="Enter Your Current Password Here"
                        required autocomplete="current-password">
                    <button type="button" class="toggle-eye" onclick="togglePass('oldPass',this)">👁</button>
                </div>

                <div class="fg">
                    <label>New Password</label>
                    <input type="password" name="new_pass" id="newPass" placeholder="Min 6 characters" required
                        autocomplete="new-password" oninput="checkStrength(this.value)">
                    <button type="button" class="toggle-eye" onclick="togglePass('newPass',this)">👁</button>
                    <div class="strength-wrap">
                        <div class="strength-bar">
                            <div class="strength-fill" id="strengthFill"></div>
                        </div>
                        <span class="strength-text" id="strengthText"></span>
                    </div>
                </div>

                <div class="fg">
                    <label>Confirm new Password</label>
                    <input type="password" name="conf_pass" id="confPass" placeholder="Enter same password as New Password"
                        required autocomplete="new-password" oninput="checkMatch()">
                    <button type="button" class="toggle-eye" onclick="togglePass('confPass',this)">👁</button>
                    <div id="matchMsg" style="font-size:0.7rem;font-weight:700;margin-top:4px;display:none;"></div>
                </div>

                <button type="submit" class="btn-submit">🔐 Change Password</button>
            </form>
            <?php else: ?>
            <a href="index.php" class="btn-submit"
                style="display:block;text-align:center;text-decoration:none;margin-top:0;">🏠Go To  Home </a>
            <?php endif; ?>

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

    function togglePass(id, btn) {
        const el = document.getElementById(id);
        el.type = el.type === 'password' ? 'text' : 'password';
        btn.textContent = el.type === 'password' ? '👁' : '🙈';
    }

    function checkStrength(val) {
        const fill = document.getElementById('strengthFill');
        const text = document.getElementById('strengthText');
        let score = 0;
        if (val.length >= 6) score++;
        if (val.length >= 10) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const levels = [{
                w: '0%',
                bg: '#eee',
                t: ''
            },
            {
                w: '25%',
                bg: '#ef4444',
                t: 'Bahut Weak'
            },
            {
                w: '50%',
                bg: '#f97316',
                t: 'Weak'
            },
            {
                w: '75%',
                bg: '#eab308',
                t: 'Medium'
            },
            {
                w: '100%',
                bg: '#22c55e',
                t: 'Strong 💪'
            },
        ];
        const l = levels[Math.min(score, 4)];
        fill.style.width = val.length === 0 ? '0%' : l.w;
        fill.style.background = l.bg;
        text.textContent = val.length === 0 ? '' : l.t;
        text.style.color = l.bg;
    }

    function checkMatch() {
        const np = document.getElementById('newPass').value;
        const cp = document.getElementById('confPass').value;
        const msg = document.getElementById('matchMsg');
        if (cp.length === 0) {
            msg.style.display = 'none';
            return;
        }
        msg.style.display = 'block';
        if (np === cp) {
            msg.textContent = '✅ Password is match ';
            msg.style.color = '#16a34a';
        } else {
            msg.textContent = '❌ Password does not match';
            msg.style.color = '#dc2626';
        }
    }

    // Sync localStorage
    <?php if($logged_in): ?>
    localStorage.setItem('kmh_session', JSON.stringify({
        name: "<?= addslashes(htmlspecialchars($user_name)) ?>",
        id: "<?= $user_id ?>"
    }));
    <?php endif; ?>
    </script>
</body>

</html>