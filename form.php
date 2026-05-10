<?php
// 1. DATABASE CONNECTION
$conn = mysqli_connect("localhost", "root", "", "shudh_puja");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(!session_id()) {
    session_start();
}

$error_msg   = "";
$success_msg = "";

// Redirect URL — form.php?redirect=... se aata hai, warna default
$redirect_url = isset($_GET['redirect'])  ? $_GET['redirect']  :
               (isset($_POST['redirect']) ? $_POST['redirect'] : 'index.php');

// Sirf safe internal redirects allow karo (external URLs block)
function safe_redirect($url) {
    // External URL hai to index pe bhejo
    if (preg_match('/^https?:\/\//i', $url)) return 'index.php';
    return $url;
}

// 2. PHP LOGIC (SIGNUP, LOGIN, LOGOUT)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['action']) && $_POST['action'] == 'signup') {
        $name  = mysqli_real_escape_string($conn, $_POST['name']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $pass  = password_hash($_POST['pass'], PASSWORD_DEFAULT);
        $addr  = mysqli_real_escape_string($conn, $_POST['addr']);

        $check = mysqli_query($conn, "SELECT * FROM users WHERE phone='$phone' OR email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $error_msg = "PHONE OR EMAIL ALREADY REGISTERED!";
        } else {
            $sql = "INSERT INTO users (name, phone, email, password, address) VALUES ('$name', '$phone', '$email', '$pass', '$addr')";
            if (mysqli_query($conn, $sql)) {
                $_SESSION['user_id']   = mysqli_insert_id($conn);
                $_SESSION['user_name'] = $name;
                $_SESSION['user_addr'] = $addr;
                // Signup ke baad hamesha welcome toast ke saath index pe
                header("Location: index.php?welcome=1");
                exit;
            } else {
                $error_msg = "DATABASE ERROR!";
            }
        }
    }

    if (isset($_POST['action']) && $_POST['action'] == 'login') {
        $user_input   = mysqli_real_escape_string($conn, $_POST['user_id']);
        $pass         = $_POST['pass'];
        $post_redirect = isset($_POST['redirect']) ? safe_redirect($_POST['redirect']) : 'index.php';

        $res = mysqli_query($conn, "SELECT * FROM users WHERE phone='$user_input' OR email='$user_input'");
        if ($row = mysqli_fetch_assoc($res)) {
            if (password_verify($pass, $row['password'])) {
                $_SESSION['user_id']   = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_addr'] = $row['address'];
                // Login ke baad wapas usi page pe jahan se aaye the
                header("Location: " . $post_redirect);
                exit;
            } else {
                $error_msg = "INVALID PASSWORD!";
            }
        } else {
            $error_msg = "USER NOT REGISTERED!";
        }
    }

    if (isset($_POST['action']) && $_POST['action'] == 'logout') {
        session_destroy();
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Now | Kaivalyamh</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Tiro+Devanagari+Hindi&family=Cormorant+Garamond:wght@300;400;600;700&display=swap"
        rel="stylesheet">
    <style>
    :root {
        --saffron: #FF6B00;
        --gold: #C9960C;
        --gold-light: #F2C94C;
        --deep-red: #c88d36;
        --cream: #FFF8EE;
        --brown: #3D1C00;
        --wa: #25D366;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        min-height: 100vh;
        background: linear-gradient(160deg, var(--deep-red) 0%, #3D1C00 100%);
        font-family: 'Cormorant Garamond', serif;
        display: flex;
        flex-direction: column;
        overflow-x: hidden;
    }

    /* INITIAL CARD LOAD ANIMATION */
    @keyframes cardEntry {
        from {
            opacity: 0;
            transform: scale(0.9) translateY(30px);
        }

        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    /* TAB SWITCH ANIMATION */
    @keyframes panelIn {
        from {
            opacity: 0;
            transform: translateX(20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .page-bg {
        position: fixed;
        inset: 0;
        pointer-events: none;
        z-index: 0;
    }

    .page-bg::before {
        content: 'ॐ';
        position: absolute;
        right: -6%;
        top: 8%;
        font-size: 60vw;
        color: rgba(255, 255, 255, 0.025);
        font-family: 'Tiro Devanagari Hindi', serif;
    }

    .page-bg::after {
        content: 'ॐ';
        position: absolute;
        left: -10%;
        top: -2%;
        font-size: 60vw;
        color: rgba(255, 255, 255, 0.025);
        font-family: 'Tiro Devanagari Hindi', serif;
    }

    nav {
        position: relative;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 5%;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .nav-logo {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 900;
        color: var(--gold-light);
        text-decoration: none;
    }

    .main {
        position: relative;
        z-index: 1;
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px 5%;
    }

    .card {
        background: rgba(255, 248, 238, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 32px 80px rgba(0, 0, 0, 0.4);
        overflow: hidden;
        animation: cardEntry 0.8s ease-out;
    }

    .tabs {
        display: flex;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .tab {
        flex: 1;
        padding: 18px;
        text-align: center;
        font-family: 'Playfair Display', sans-serif;
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.45);
        cursor: pointer;
        background: none;
        border: none;
        transition: 0.3s;
        font-weight: 700;
    }

    .tab.active {
        color: var(--gold-light);
        border-bottom: 2px solid var(--gold-light);
    }

    .panel {
        display: none;
        padding: 25px;
    }

    .panel.active {
        display: block;
        animation: panelIn 0.5s ease-out;
    }

    .panel-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 900;
        color: var(--gold-light);
        margin-bottom: 20px;
        text-align: center;
    }

    .fg {
        margin-bottom: 14px;
        position: relative;
    }

    .fg label {
        display: block;
        font-size: 0.7rem;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.55);
        margin-bottom: 6px;
        font-weight: 800;
    }

    .fg input,
    .fg textarea {
        width: 100%;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 8px;
        padding: 12px 16px;
        color: white;
        font-size: 0.85rem;
        outline: none;
        letter-spacing: 1px;
        transition: 0.3s;
    }

    .fg input:focus {
        border-color: var(--gold-light);
        background: rgba(255, 255, 255, 0.1);
    }

    .fg input::placeholder,
    .fg textarea::placeholder {
        color: rgba(200, 190, 190, 0.4) !important;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.7rem;
    }

    .field-err {
        color: #ff8a8a;
        font-size: 0.65rem;
        margin-top: 4px;
        display: none;
        text-transform: uppercase;
        font-weight: 700;
    }

    .toggle-pass {
        position: absolute;
        right: 12px;
        top: 32px;
        color: rgba(255, 255, 255, 0.4);
        cursor: pointer;
        font-size: 0.9rem;
    }

    .btn-submit,
    .btn-login {
        width: 100%;
        background: #5bee71;
        color: white;
        border: none;
        padding: 16px;
        font-weight: 800;
        border-radius: 10px;
        cursor: pointer;
        margin-top: 10px;
        transition: 0.3s;
    }

    .btn-login {
        background: linear-gradient(135deg, var(--saffron), #e05500);
    }

    .btn-submit:hover,
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .toast {
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        padding: 14px 28px;
        border-radius: 40px;
        z-index: 9999;
        display: none;
        font-weight: 700;
        font-size: 0.8rem;
    }

    @media (max-width: 480px) {
        .card {
            border-radius: 0;
            border: none;
            height: 100%;
            max-width: 100%;
        }

        .main {
            padding: 0;
        }

        .tab {
            padding: 15px;
            font-size: 0.8rem;
        }
    }
    </style>
</head>

<body>
    <div class="page-bg"></div>
    <nav>
        <a href="index.php" class="nav-logo">Kaivalyamh</a>
        <a href="index.php"
            style="color:white; text-decoration:none; font-size: 0.9rem; letter-spacing: 1px; font-weight: 700;">← BACK
            TO HOME</a>
    </nav>

    <div class="main">
        <div class="card">
            <?php if (!isset($_SESSION['user_id'])): ?>
            <div class="tabs">
                <button class="tab active" id="btn-signup" onclick="switchTab('signup')">NEW CUSTOMER</button>
                <button class="tab" id="btn-login" onclick="switchTab('login')">RETURN CUSTOMER</button>
            </div>

            <!-- SIGNUP PANEL -->
            <div id="signup-panel" class="panel active">
                <div class="panel-title">CREATE ACCOUNT</div>
                <form method="POST" onsubmit="return validateSignup()">
                    <input type="hidden" name="action" value="signup">
                    <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect_url) ?>">
                    <div class="fg">
                        <label>Full Name</label>
                        <input type="text" name="name" id="s-name" placeholder="Full Name"
                            oninput="this.value=this.value.replace(/[^a-zA-Z\s]/g,'')" required>
                        <div class="field-err" id="err-s-name">INVALID NAME</div>
                    </div>
                    <div class="fg">
                        <label>WhatsApp Number</label>
                        <input type="text" name="phone" id="s-phone" maxlength="10"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'')" placeholder="+91 xxxxx xxxxx"
                            required>
                        <div class="field-err" id="err-s-phone">INVALID PHONE</div>
                    </div>
                    <div class="fg">
                        <label>Email Address</label>
                        <input type="email" name="email" id="s-email" placeholder="example@gmail.com"
                            style="text-transform: none;" required>
                    </div>
                    <div class="fg">
                        <label>Password</label>
                        <input type="password" name="pass" id="s-pass" placeholder="MIN 6 CHAR"
                            style="text-transform: none;" required>
                        <span class="toggle-pass" onclick="togglePass('s-pass')">👁</span>
                    </div>
                    <div class="fg">
                        <label>Delivery Address</label>
                        <textarea name="addr" id="s-addr" placeholder="STREET, CITY, PINCODE" required></textarea>
                    </div>
                    <button type="submit" class="btn-submit">SIGN UP & CONTINUE</button>
                </form>
            </div>

            <!-- LOGIN PANEL -->
            <div id="login-panel" class="panel">
                <div class="panel-title">WELCOME BACK</div>
                <form method="POST" onsubmit="return validateLogin()">
                    <input type="hidden" name="action" value="login">
                    <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect_url) ?>">
                    <div class="fg">
                        <label>Phone or Email</label>
                        <input type="text" name="user_id" id="l-user" placeholder="+91 xxxxxxxxxx OR Email" required>
                    </div>
                    <div class="fg">
                        <label>Password</label>
                        <input type="password" name="pass" id="l-pass" placeholder="Enter Password"
                            style="text-transform: none;" required>
                        <span class="toggle-pass" onclick="togglePass('l-pass')">👁</span>
                    </div>
                    <button type="submit" class="btn-login">LOGIN TO ORDER</button>
                </form>
            </div>

            <?php else: ?>
            <!-- Already logged in hai — directly redirect karo ──────────── -->
            <script>
            window.location.href = "<?= htmlspecialchars(safe_redirect($redirect_url)) ?>";
            </script>
            <?php endif; ?>
        </div>
    </div>

    <div id="toast" class="toast"></div>

    <script>
    function switchTab(tab) {
        const signupPanel = document.getElementById('signup-panel');
        const loginPanel = document.getElementById('login-panel');
        const signupBtn = document.getElementById('btn-signup');
        const loginBtn = document.getElementById('btn-login');

        if (tab === 'signup') {
            signupPanel.classList.add('active');
            loginPanel.classList.remove('active');
            signupBtn.classList.add('active');
            loginBtn.classList.remove('active');
        } else {
            loginPanel.classList.add('active');
            signupPanel.classList.remove('active');
            loginBtn.classList.add('active');
            signupBtn.classList.remove('active');
        }
    }

    function togglePass(id) {
        const x = document.getElementById(id);
        x.type = x.type === "password" ? "text" : "password";
    }

    function validateSignup() {
        let valid = true;
        const phone = document.getElementById('s-phone').value;
        if (phone.length !== 10) {
            document.getElementById('err-s-phone').style.display = 'block';
            valid = false;
        }
        return valid;
    }

    function validateLogin() {
        return true;
    }

    <?php if ($error_msg || $success_msg): ?>
    const t = document.getElementById('toast');
    t.style.display = 'block';
    t.style.background = "<?= $error_msg ? 'rgba(255,0,0,0.8)' : 'rgba(0,128,0,0.8)' ?>";
    t.style.color = 'white';
    t.textContent = "<?= $error_msg ? $error_msg : $success_msg ?>";
    setTimeout(() => t.style.display = 'none', 4000);
    <?php endif; ?>

    <?php if ($error_msg && strpos($error_msg, 'PASSWORD') !== false): ?>
    // Password galat tha — login tab kholo
    switchTab('login');
    <?php elseif ($error_msg && strpos($error_msg, 'REGISTERED') !== false && strpos($error_msg, 'NOT') === false): ?>
    // Already registered — login tab suggest karo
    switchTab('login');
    <?php endif; ?>
    </script>
</body>

</html>