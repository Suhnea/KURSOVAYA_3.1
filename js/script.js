document.addEventListener('DOMContentLoaded', () => {
    console.log("✅ script.js загружен");

    // Регистрация
    const regForm = document.getElementById('register-form');
    if (regForm) {
        regForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const data = Object.fromEntries(new FormData(regForm));

            const res = await fetch('php/auth/register.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(data)
            });
            const result = await res.json();

            if (result.success) {
                alert(result.message);
                window.location.href = 'login.html';
            } else {
                alert(result.message);
            }
        });
    }

    // Вход
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const data = Object.fromEntries(new FormData(loginForm));

            const res = await fetch('php/auth/login.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(data)
            });
            const result = await res.json();

            if (result.success) {
                window.location.href = 'cabinet.php';
            } else {
                alert(result.message);
            }
        });
    }
});

// Отклик на нужду
async function otkliknutisya(need) {
    const data = {
        name: "Волонтёр",
        email: "volunteer@dobrozhelyubno.ru",
        phone: "—",
        vacancy: need,
        message: "Хочу помочь",
        status: "new"
    };

    const res = await fetch('php/api/save_application.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    });
    const result = await res.json();

    if (result.success) {
        alert(`Спасибо! Ты откликнулся на «${need}» ❤️`);
    } else {
        alert("Ошибка: " + (result.message || "Неизвестная ошибка"));
    }
}