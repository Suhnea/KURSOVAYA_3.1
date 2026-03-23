<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Админ-панель — Я помогаю детям</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
  <nav>
    <ul>
      <li><a href="../index.html">На сайт</a></li>
      <li><a href="../php/auth/logout.php">Выход</a></li>
    </ul>
  </nav>
</header>
<div class="container">
  <h2 style="text-align:center; margin:2rem 0;">Заявки волонтёров</h2>
  <table id="app-table">
    <thead><tr><th>ID</th><th>ФИО</th><th>Email</th><th>Телефон</th><th>Направление</th><th>Дата</th><th>Статус</th><th>Действия</th></tr></thead>
    <tbody></tbody>
  </table>
</div>

<script>
async function loadApps() {
  const data = await (await fetch('php/api/get_applications.php')).json();
  const tbody = document.querySelector('#app-table tbody');
  tbody.innerHTML = data.map(app => `
    <tr>
      <td>${app.id}</td>
      <td>${app.name}</td>
      <td>${app.email}</td>
      <td>${app.phone}</td>
      <td>${app.vacancy}</td>
      <td>${app.date}</td>
      <td>${app.status}</td>
      <td>
        <button onclick="update(${app.id})">Обработано</button>
        <button onclick="del(${app.id})">Удалить</button>
      </td>
    </tr>
  `).join('');
}
async function del(id) { if(confirm('Удалить?')) { await fetch('php/api/delete_application.php', {method:'POST', body:JSON.stringify({id})}); loadApps(); }}
async function update(id) { await fetch('php/api/update_application.php', {method:'POST', body:JSON.stringify({id, status:'processed'})}); loadApps(); }
loadApps();
</script>
<script src="js/script.js"></script>
</body>
</html>