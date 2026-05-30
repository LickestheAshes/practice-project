<?php 
session_start(); 
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo '<pre style="background: yellow; padding: 10px;">';
    echo 'ВСЕ ДАННЫЕ POST:' . "\n";
    print_r($_POST);
    echo "\n\n";
    echo 'Логин из POST: [' . ($_POST['login'] ?? 'НЕТ ТАКОГО ПОЛЯ') . ']' . "\n";
    echo 'Пароль из POST: [' . ($_POST['password'] ?? 'НЕТ ТАКОГО ПОЛЯ') . ']' . "\n";
    echo '</pre>';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход - Корочки.есть</title>
    <link rel="stylesheet" href="bootstrap.min.css">
        <style>
        .invalid-feedback { display: none; }
        .was-validated .invalid-feedback { display: block; }
    </style>
</head>
<body class="d-flex flex-column min-vh-100 m-0 bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php"> <img src="logo2.png" alt="Логотип" height="32" class="d-inline-block align-text-top me-2">
    Корочки.есть
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="register.php">Регистрация</a>
            </div>
        </div>
    </nav>

    <main class="container mt-5 flex-grow-1">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Авторизация</h4>
                    </div>
                    <div class="card-body">

<form action="auth.php" method="POST" class="needs-validation" novalidate>
    <div class="mb-3">
        <label for="login" class="form-label">Логин *</label>
        <input type="text" class="form-control" id="login" name="login" required>
        <div class="invalid-feedback">Введите логин</div>
        <?php if(isset($errors['login'])): ?>
            <div class="invalid-feedback d-block" style="color: red;"><?= htmlspecialchars($errors['login']) ?></div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Пароль *</label>
        <input type="password" class="form-control" id="password" name="password" required>
        <div class="invalid-feedback">Введите пароль</div>
    </div>

    <div class="d-grid gap-2">
<button type="submit" name="submit_login" class="btn btn-primary btn-lg">Войти</button>
    </div>

    <div class="text-center mt-3">
        <p>Еще не зарегистрированы? <a href="register.php">Регистрация</a></p>
    </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <div class="container">
            <p class="mb-0">&copy; Корочки.есть - 2026</p>
        </div>
    </footer>

    <script src="bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>
</html>