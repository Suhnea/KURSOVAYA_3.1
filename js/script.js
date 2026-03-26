// ==================== SCRIPT.JS ДЛЯ ДОБРОЖЕЛЮБНО ====================

document.addEventListener('DOMContentLoaded', function() {

    console.log("✅ script.js успешно загружен");

    // === РЕГИСТРАЦИЯ ===
    const regForm = document.getElementById('register-form');
    if (regForm) {
        console.log("✅ Форма регистрации найдена");

        regForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            console.log("📤 Попытка регистрации...");

            const formData = new FormData(this);
            const data = Object.fromEntries(formData);

            console.log("Отправляемые данные:", data);

            try {
                const response = await fetch('php/auth/register.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();
                console.log("Ответ от сервера:", result);

                if (result.success) {
                    alert(result.message || "Регистрация прошла успешно!");
                    setTimeout(() => {
                        window.location.href = 'login.html';
                    }, 1500);
                } else {
                    alert(result.message || "Ошибка регистрации");
                }
            } catch (error) {
                console.error("Ошибка при регистрации:", error);
                alert("Ошибка соединения с сервером. Проверьте, запущен ли XAMPP.");
            }
        });
    }

    // === ВХОД ===
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        console.log("✅ Форма входа найдена");

        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            console.log("📤 Попытка входа...");

            const formData = new FormData(this);
            const data = Object.fromEntries(formData);

            try {
                const response = await fetch('php/auth/login.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });

                const result = await response.json();
                console.log("Ответ от сервера:", result);

                if (result.success) {
                    window.location.href = 'cabinet.php';
                } else {
                    alert(result.message || "Ошибка входа");
                }
            } catch (error) {
                console.error("Ошибка при входе:", error);
                alert("Ошибка соединения с сервером");
            }
        });
    }
});