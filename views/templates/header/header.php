<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!-- From Uiverse.io by akshat-patel28 --> 
<link rel="stylesheet" href="/projet_php/public/style.css">
<div style="height: 80px; position: relative; background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
    <div class="logo-container" style="position: absolute; top: 50%; left: 20px; transform: translateY(-50%); width: 70px; height: 70px;">
        <img src="/projet_php/assets/logo.png" alt="Logo" style="height: 100%; width: 100%; object-fit: contain;">
    </div>

    <div class="button-container" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); display: flex; justify-content: center; align-items: center;">
        <button class="button" title="Home" onclick="window.location.href='/projet_php/public/user/user_product.php'">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor" class="icon">
            <path d="M3 12L12 3l9 9"></path>
            <path d="M9 21V9h6v12"></path>
            </svg>
        </button>
        
        <button class="button" onclick="window.location.href='/projet_php/public/user/cart.php'" style="position:relative;">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor" class="icon">
                <circle r="1" cy="21" cx="9"></circle>
                <circle r="1" cy="21" cx="20"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <?php
            $cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
            if ($cartCount > 0): ?>
                <span style="position:absolute; left:50%; top:100%; transform:translate(-50%, 10px); background:#f44336; color:white; border-radius:50%; padding:2px 7px; font-size:12px; min-width:22px; text-align:center; font-weight:bold; z-index:2;">
                    <?= $cartCount ?>
                </span>
            <?php endif; ?>
        </button>
    </div>

    <div class="btn-container" style="position: absolute; top: 50%; right: 20px; transform: translateY(-50%);">
        <?php if (isset($_SESSION['user_id'])): ?>
            <span style="margin-right: 10px;">Welcome, <?php echo htmlspecialchars($_SESSION['user_login']); ?></span>
            <button class="btn_sign" style="margin-right: 10px;" onclick="window.location.href='/projet_php/public/signout.php'">
                Sign Out
            </button>
        <?php else: ?>
            <button class="btn_sign" style="margin-right: 10px;" onclick="window.location.href='/projet_php/public/signin/signin.php'">
                Sign In
            </button>
        <?php endif; ?>
    </div>
</div>