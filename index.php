<?php

require_once __DIR__ .'/config/cn.php';
$products = [];

try {
    // Use the correct DSN format for SQL Server
    $conn = new PDO("sqlsrv:Server=$server;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo '<div style="color:green;text-align:center;">✅ Connected to SQL Server successfully</div>';
} catch (PDOException $e) {
    echo '<div style="color:red;text-align:center;">❌ Connection failed: ' . htmlspecialchars($e->getMessage()) . '</div>';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Gift Flowers</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      margin: 0;
      font-family: 'Fredoka', sans-serif;
      background: #fffefc;
    }

    .header-collapse-btn {
      display: none;
      background: linear-gradient(90deg, #f8bbd0 0%, #ffe6a7 100%);
      border: 2.5px dashed #e57399;
      border-radius: 50%;
      width: 48px;
      height: 48px;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      color: #e57399;
      box-shadow: 0 2px 8px #f8bbd0;
      cursor: pointer;
      margin: 8px 8px 0 8px;
      transition: background 0.2s, box-shadow 0.2s, transform 0.2s;
      position: absolute;
      left: 0;
      top: 0;
      z-index: 200;
      animation: chickWatch 1.2s infinite alternate cubic-bezier(.68,-0.55,.27,1.55);
    }

    @keyframes chickWatch {
      0% { transform: scale(1) rotate(-8deg); }
      40% { transform: scale(1.08) rotate(8deg); }
      60% { transform: scale(1.12) rotate(-6deg); }
      100% { transform: scale(1) rotate(0deg); }
    }

    @media (max-width: 900px) {
      .header-collapse-btn {
        display: flex;
      }

      .main-nav {
        display: none;
        flex-direction: column;
        background: #fffbe7;
        border-radius: 0 0 24px 24px;
        box-shadow: 0 2px 18px #f8bbd0;
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        padding: 1rem 0 0.5rem 0;
        z-index: 150;
        margin-left: 0;
      }

      .main-nav.open {
        display: flex !important;
      }
    }

    .hero {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      min-height: 100vh;
      padding: 4% 6%;
      background: linear-gradient(120deg, #fff0f6, #e0f7fa);
    }

    .hero .text {
      flex: 1 1 50%;
      z-index: 2;
    }

    .hero .text h1 {
      font-size: 3.5rem;
      color: #e91e63;
      margin-bottom: 0.5rem;
    }

    .hero .text span {
      color: #f06292;
    }

    .hero .text p {
      font-size: 1.25rem;
      color: #ad1457;
      margin-bottom: 1.5rem;
    }

    .hero form {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
    }

    .hero form select,
    .hero form button {
      padding: 10px 18px;
      border: 2px dashed #e57399;
      border-radius: 12px;
      font-size: 1rem;
      background: #fffbe7;
      color: #ad1457;
      cursor: pointer;
    }

    .hero .image {
      flex: 1 1 45%;
      display: flex;
      justify-content: center;
      align-items: center;
      animation: floatCute 5s ease-in-out infinite;
    }

    .hero .image img {
      width: 100%;
      max-width: 500px;
      border-radius: 30px;
      box-shadow: 0 10px 30px rgba(248, 187, 208, 0.4);
    }

    @keyframes floatCute {
      0% { transform: translateY(0); }
      50% { transform: translateY(-15px); }
      100% { transform: translateY(0); }
    }

    .products {
      padding: 40px 20px;
      text-align: center;
    }

    .products h2 {
      color: #e91e63;
      font-size: 2rem;
      margin-bottom: 20px;
    }

    .grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 24px;
    }

    .product {
      background: #fff0f6;
      border-radius: 24px;
      box-shadow: 0 6px 14px rgba(231, 84, 128, 0.15);
      overflow: hidden;
      text-align: center;
      transition: transform 0.3s ease;
      width: 100%;
      max-width: 300px;
    }

    .product:hover {
      transform: translateY(-5px) scale(1.03);
    }

    .flower-img {
      width: 100%;
      height: 300px;
      object-fit: cover;
      border-bottom: 4px solid #ffd6ea;
      border-radius: 24px 24px 0 0;
    }

    .chick-move {
      animation: chickFloat 3s ease-in-out infinite;
      cursor: pointer;
    }

    @keyframes chickFloat {
      0%   { transform: translateY(0px) rotate(-2deg); }
      50%  { transform: translateY(-10px) rotate(2deg); }
      100% { transform: translateY(0px) rotate(-2deg); }
    }

    .product h3 {
      font-size: 1.4rem;
      color: #e91e63;
      margin: 12px 0 4px;
    }

    .product p {
      font-size: 1.2rem;
      color: #ff4081;
      font-weight: bold;
      margin-bottom: 12px;
    }

    footer {
      text-align:center;
      margin-top:40px;
      padding:22px 0;
      background:#fffbe7;
      border-top:2px solid #ffe6a7;
      border-radius: 0 0 32px 32px;
      box-shadow: 0 -2px 18px #f8bbd0;
    }

    footer img {
      height:60px;
      border-radius:50%;
      box-shadow:0 2px 8px #f8bbd0;
    }

    footer a {
      color:#fff;
      font-weight:bold;
      text-decoration:none;
      border:1px solid #e57399;
      border-radius:8px;
      padding:10px 28px;
      background:#e57399;
      transition:background 0.2s;
      font-size:1.1rem;
      box-shadow:0 2px 8px #f8bbd0;
    }
  </style>
</head>
<body>

<header style="background: linear-gradient(90deg, #ffe4ec 0%, #e0f7fa 100%); box-shadow: 0 4px 18px #f8bbd0; border-radius: 0 0 32px 32px; margin-bottom: 2.2rem; padding-bottom: 0.5rem; position: relative; z-index: 2;">
  <div class="topbar"><span>Call: 0888283179</span></div>
  <button class="header-collapse-btn" id="headerCollapseBtn" aria-label="Toggle navigation">🐣</button>
  <nav class="main-nav" id="mainNavMenu">
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="./menu/login.php">Login</a>
    <a href="./menu/result.php">Result</a>
    <form action="./menu/result.php" method="get" style="display:flex;align-items:center;gap:4px;background:#fffbe7;padding:4px 10px;border-radius:12px;box-shadow:0 2px 8px #f8bbd0;">
      <input type="text" name="q" placeholder="Search orders..." style="padding:6px 12px; border-radius:6px; border:1.5px dashed #e57399; font-size:1rem; background:#fff0f6; color:#ad1457;">
      <button type="submit" class="header-btn" style="padding:8px 18px; min-width:90px; border-radius:18px; border:2.5px dashed #e57399; background:linear-gradient(90deg,#f8bbd0 0%,#e57399 100%); font-size:1.08rem;">🔍 Search</button>
    </form>
  </nav>
</header>

<section class="hero">
  <div class="text">
    <h1><span>like you</span><br>mean it.</h1>
    <p>If you’re going to use a passage of Lorem Ipsum, you need to be sure...</p>
    <form method="POST" action="about.php">
      <select name="occasion">
        <option value="">Occasions</option>
        <option value="Birthday">Birthday</option>
      </select>
      <select name="recipient">
        <option value="">Recipient</option>
        <option value="Her">Her</option>
      </select>
      <button type="submit">Find</button>
    </form>
  </div>
  <div class="image">
    <img src="imag/13.jpg" alt="imag">
  </div>
</section>

<section class="products">
  <h2>Gifts for Every Occasion</h2>
  <div class="grid">
    <?php foreach ($products as $product): ?>
      <div class="product">
        <a href="about/admin.php?product=<?= urlencode($product['id']) ?>" class="flower-link" title="Manage flower">
          <img class="flower-img chick-move" src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
        </a>
      </div>
      <div class="info">
         
        <h3><?= htmlspecialchars($product['name']) ?></h3>
        <p>$<?= number_format($product['price'], 2) ?></p>
      </div>
    <?php endforeach; ?>
  </div>
  
</section>

<!-- Cute Flower Gallery Section (add before <footer>) -->
<section class="cute-footer-gallery" style="text-align:center; margin:38px 0 0 0;">
  <h2 style="color:#e57399; font-size:1.25rem; margin-bottom:16px;">Cute Flower Gallery</h2>
  <div style="
    display: flex;
    justify-content: center;
    align-items: flex-end;
    gap: 22px;
    flex-wrap: wrap;
    padding: 16px 0;
    background: linear-gradient(90deg, #fffbe7 0%, #ffe6a7 100%);
    border-radius: 24px;
    box-shadow: 0 4px 18px #f8bbd0;
    margin-bottom: 24px;
  ">
    <a href="about.php?page=1" title="Flower 1">
      <img src="imag/1.jpg" alt="Flower 1" style="height:300px; border-radius:50%; box-shadow:0 4px 16px #f8bbd0; border:4px solid #ffe6a7; margin-bottom:-10px; cursor:pointer; transition:transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
    </a>
    <a href="about.php?page=2" title="Flower 2">
      <img src="imag/2.jpg" alt="Flower 2" style="height:300px; border-radius:50%; box-shadow:0 4px 16px #f8bbd0; border:4px solid #ffe6a7; cursor:pointer; transition:transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
    </a>
    <a href="about.php?page=3" title="Flower 3">
      <img src="imag/3.jpg" alt="Flower 3" style="height:300px; border-radius:50%; box-shadow:0 4px 16px #f8bbd0; border:4px solid #ffe6a7; margin-bottom:-6px; cursor:pointer; transition:transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
    </a>
    <a href="about.php?page=4" title="Flower 4">
      <img src="imag/4.jpg" alt="Flower 4" style="height:300px; border-radius:50%; box-shadow:0 4px 16px #f8bbd0; border:4px solid #ffe6a7; cursor:pointer; transition:transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
    </a>
    <a href="about.php?page=5" title="Flower 5">
      <img src="imag/5.jpg" alt="Flower 5" style="height:300px; border-radius:50%; box-shadow:0 4px 16px #f8bbd0; border:4px solid #ffe6a7; margin-bottom:-10px; cursor:pointer; transition:transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
    </a>
  </div>
</section>

<footer>
  <div style="display: flex; justify-content: center; align-items: center; gap: 18px; flex-wrap: wrap; margin-bottom: 12px;">
    <img src="imag/1.jpg" alt="Flower 1">
    <img src="imag/2.jpg" alt="Flower 2">
    <img src="imag/3.jpg" alt="Flower 3">
    <img src="imag/4.jpg" alt="Flower 4">
    <img src="imag/5.jpg" alt="Flower 5">
  </div>
  <div style="color:#e57399; font-weight:bold; font-size:1.2rem; margin-bottom:8px;">🌸 Thank you for visiting our flower shop! 🌸</div>
  <div style="margin-top:10px;">
    <a href="about.php">See All Flowers</a>
  </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const collapseBtn = document.getElementById('headerCollapseBtn');
  const navMenu = document.getElementById('mainNavMenu');

  if (collapseBtn && navMenu) {
    collapseBtn.addEventListener('click', e => {
      e.stopPropagation();
      navMenu.classList.toggle('open');
    });

    document.addEventListener('click', e => {
      if (!collapseBtn.contains(e.target) && !navMenu.contains(e.target)) {
        navMenu.classList.remove('open');
      }
    });
  }
});
</script>

</body>
</html>
