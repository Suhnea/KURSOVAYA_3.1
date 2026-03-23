async function apiRequest(url, method = 'POST', body = null) {
  const options = { method };
  if (body) {
    options.headers = { 'Content-Type': 'application/json' };
    options.body = JSON.stringify(body);
  }
  const res = await fetch(url, options);
  return await res.json();
}

// регистрация и вход (как раньше)
document.addEventListener('DOMContentLoaded', () => {
  // ... (код регистрации и логина остаётся прежним)

  // новая функция отклика в кабинете
  window.otkliknutisya = async function(need) {
    const data = {
      name: "<?php echo $_SESSION['name'] ?? 'Волонтёр'; ?>", // если нужно
      email: "отклик@dobrozhelyubno.ru",
      phone: "—",
      vacancy: need,
      message: "Хочу помочь по этой нужде",
      status: "new"
    };
    const result = await apiRequest('php/api/save_application.php', 'POST', data);
    alert(result.success ? `Спасибо! Ты откликнулся на «${need}» ❤️` : 'Ошибка');
  };
});