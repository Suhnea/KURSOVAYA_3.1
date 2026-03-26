<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'volunteer') {
    header('Location: login.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Личный кабинет — Доброжелюбно</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
  <nav>
    <ul>
      <li><a href="index.html">Главная</a></li>
      <li><a href="tebe-nuzhna-pomosh.html">Тебе нужна помощь?</a></li>
      <li><a href="php/auth/logout.php">Выход</a></li>
    </ul>
  </nav>
</header>

<div class="container">
  <h1 style="text-align:center; margin:30px 0; color:#FF69B4;">
    Добро пожаловать, <?= htmlspecialchars($_SESSION['name']) ?> ❤️
  </h1>

  <section class="card">
    <h2>Текущие нужды</h2>
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px,1fr)); gap:20px; margin-top:20px;">
      <div class="card" style="text-align:center;">
        <h3>Сбор одежды и обуви</h3>
        <button onclick="otkliknutisya('Сбор одежды и обуви')" class="btn" style="width:100%;">Откликнуться</button>
      </div>
      <div class="card" style="text-align:center;">
        <h3>Помощь на празднике 5 апреля</h3>
        <button onclick="otkliknutisya('Помощь на празднике 5 апреля')" class="btn" style="width:100%;">Откликнуться</button>
      </div>
    </div>
  </section>
</div>

<script src="js/script.js"></script>
</body>
</html>