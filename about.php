<?php
require_once __DIR__ . '/config/cn.php';

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
  <title>Gift Shop</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      margin: 0;
      font-family: 'Fredoka', 'Comic Sans MS', cursive, sans-serif;
      background: #fffafc;
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
      margin: 8px;
      position: absolute;
      top: 0;
      left: 0;
      z-index: 200;
      animation: chickWatch 1.2s infinite alternate cubic-bezier(.68,-0.55,.27,1.55);
    }

    @keyframes chickWatch {
      0%   { transform: scale(1) rotate(-6deg); }
      50%  { transform: scale(1.1) rotate(6deg); }
      100% { transform: scale(1) rotate(0); }
    }

    header {
      background: linear-gradient(90deg, #ffe4ec 0%, #e0f7fa 100%);
      padding-bottom: 0.5rem;
      border-radius: 0 0 32px 32px;
      box-shadow: 0 4px 18px #f8bbd0;
      position: relative;
      z-index: 2;
    }

    .main-nav {
      display: flex;
      justify-content: center;
      gap: 24px;
      padding: 1rem 0;
    }

    .main-nav a {
      text-decoration: none;
      color: #e91e63;
      font-weight: bold;
      font-size: 1.1rem;
    }

    .grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
      padding: 2rem;
    }

    .card {
      width: 22%;
      background: #fff0f6;
      border-radius: 16px;
      box-shadow: 0 6px 14px rgba(231, 84, 128, 0.15);
      overflow: hidden;
      transition: transform 0.25s ease;
    }

    .card:hover {
      transform: scale(1.05);
    }

    .card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-bottom: 4px solid #ffe6f0;
    }

    .info {
      padding: 12px;
      text-align: center;
    }

    .info h4 {
      font-size: 1.3rem;
      color: #e91e63;
      margin: 8px 0;
    }

    .price {
      font-size: 1.1rem;
      color: #ff4081;
      font-weight: bold;
      display: block;
      margin: 10px 0 4px;
    }

    .icons span {
      font-size: 1.3rem;
      margin: 0 4px;
      color: #f06292;
    }

    footer {
      text-align: center;
      margin-top: 30px;
      padding: 18px 0;
      background: #fffbe7;
      border-top: 2px solid #ffe6a7;
    }

    footer img {
      height: 60px;
      border-radius: 50%;
      box-shadow: 0 2px 8px rgba(231,84,128,0.10);
    }

    /* CUTE MEDIA QUERIES */
    @media (max-width: 1024px) {
      .card { width: 45%; }
    }

    @media (max-width: 768px) {
      .main-nav {
        flex-direction: column;
        background: #fffbe7;
        border-radius: 0 0 24px 24px;
        box-shadow: 0 2px 18px #f8bbd0;
        display: none;
        padding-bottom: 1rem;
      }

      .main-nav.open {
        display: flex !important;
      }

      .header-collapse-btn {
        display: flex;
      }

      .card {
        width: 80%;
      }
    }

    @media (max-width: 480px) {
      .card { width: 95%; }
    }
  </style>
</head>
<body>

<header>
  <button class="header-collapse-btn" id="headerCollapseBtn" aria-label="Toggle nav">🐣</button>
  <nav class="main-nav" id="mainNavMenu">
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="./menu/login.php">Login</a>
    <a href="./menu/result.php">Result</a>
  </nav>
</header>

<div class="grid">
  <?php foreach ($products as $p): ?>
    <?php 
      $title = isset($p['title']) ? htmlspecialchars($p['title']) : 'Untitled';
      $price = isset($p['price']) ? htmlspecialchars($p['price']) : 'N/A';
      $image = isset($p['image']) && !empty($p['image']) 
        ? 'uploads/' . basename($p['image']) 
        : 'https://via.placeholder.com/200x200.png?text=No+Image';
    ?>
    <div class="card">
      <img src="<?= $image ?>" alt="<?= $title ?>" onclick="window.location.href='../admin.php'">
      <div class="info">
        <h4><?= $title ?></h4>
        <div class="icons">
          <span>🔒</span><span>♡</span>
        </div>
        <span class="price">$<?= $price ?></span>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<footer>
  <div style="display: flex; justify-content: center; gap: 12px; flex-wrap: wrap;">
    <?php for ($i = 1; $i <= 5; $i++): ?>
      <img src="imag/<?= $i ?>.jpg" alt="Flower <?= $i ?>">
    <?php endfor; ?>
  </div>
  <div style="color:#e57399; font-weight:bold; font-size:1.2rem; margin-top:10px;">🌸 Thank you for visiting our flower shop! 🌸</div>
  <a href="about.php" style="display:inline-block; margin-top:10px; padding:8px 20px; background:#f8bbd0; color:#880e4f; border-radius:10px; text-decoration:none;">See All Flowers</a>
</footer>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('headerCollapseBtn');
    const menu = document.getElementById('mainNavMenu');

    btn.addEventListener('click', function (e) {
      e.stopPropagation();
      menu.classList.toggle('open');
    });

    document.addEventListener('click', function (e) {
      if (!btn.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.remove('open');
      }
    });
  });
</script>

</body>
</html>
