<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body class="d-flex flex-column min-vh-100 m-0 bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php"> <img src="logo2.png" alt="Логотип" height="32" class="d-inline-block align-text-top me-2">
    Корочки.есть
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="login.php">Войти</a>
            </div>
        </div>
    </nav>

    <?php
    $errors = $_SESSION['errors'] ?? [];
    $old = $_SESSION['old_input'] ?? [];
    unset($_SESSION['errors'], $_SESSION['old_input']);
    ?>

    <main class="container mt-5 flex-grow-1">
<div class="row justify-content-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6">
        <div class="card shadow mx-2">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Регистрация</h4>
                    </div>
                    <div class="card-body">

<form action="auth.php" method="POST" class="needs-validation" id="regForm" novalidate autocomplete="off">
                            
                            <div class="mb-3">
                                <label class="form-label">Логин *</label>
                                <input type="text" name="login" class="form-control" 
                                       value="<?= htmlspecialchars($old['login'] ?? '') ?>" 
                                       pattern="[a-zA-Z0-9]{6,}" title="Минимум 6 символов, латиница и цифры"
                                       required>
                                <div class="invalid-feedback">Латиница и цифры, не менее 6 символов</div>
                                <?php if(isset($errors['login'])) echo '<div class="invalid-feedback d-block" style="color: red;">' . $errors['login'] . '</div>'; ?>
                            </div>

<div class="mb-3">
    <label class="form-label">Пароль *</label>
    <div class="input-group">
        <input type="password" name="password" id="password" class="form-control" minlength="8" required>
        <button class="btn btn-outline-secondary" type="button" id="togglePassword" onclick="togglePasswordVisibility('password', 'togglePassword')">
            👁️ Показать
        </button>
    </div>
    <div class="invalid-feedback">Минимум 8 символов</div>
    <?php if(isset($errors['password'])) echo '<div class="invalid-feedback d-block" style="color: red;">' . $errors['password'] . '</div>'; ?>
</div>

<div class="mb-3">
    <label class="form-label">Подтвердите пароль *</label>
    <div class="input-group">
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword" onclick="togglePasswordVisibility('confirm_password', 'toggleConfirmPassword')">
            👁️ Показать
        </button>
    </div>
    <div class="invalid-feedback">Пароли не совпадают</div>
    <?php if(isset($errors['confirm_password'])) echo '<div class="invalid-feedback d-block" style="color: red;">' . $errors['confirm_password'] . '</div>'; ?>
</div>
                            <div class="mb-3">
                                <label class="form-label">ФИО *</label>
                                <input type="text" name="full_name" class="form-control" 
                                       value="<?= htmlspecialchars($old['full_name'] ?? '') ?>" 
                                       pattern="[а-яА-ЯёЁ\s]{2,}" title="Только кириллица"
                                       required>
                                <div class="invalid-feedback">Только кириллица и пробелы</div>
                                <?php if(isset($errors['full_name'])) echo '<div class="invalid-feedback d-block" style="color: red;">' . $errors['full_name'] . '</div>'; ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Телефон *</label>
                                <input type="tel" name="phone" class="form-control" id="phone" 
                                       value="<?= htmlspecialchars($old['phone'] ?? '') ?>" 
                                       placeholder="8(XXX)XXX-XX-XX" required>
                                <div class="invalid-feedback">Формат: 8(XXX)XXX-XX-XX</div>
                                <?php if(isset($errors['phone'])) echo '<div class="invalid-feedback d-block" style="color: red;">' . $errors['phone'] . '</div>'; ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" name="email" class="form-control" 
                                       value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
                                <div class="invalid-feedback">Введите корректный email</div>
                                <?php if(isset($errors['email'])) echo '<div class="invalid-feedback d-block" style="color: red;">' . $errors['email'] . '</div>'; ?>
                            </div>

                            <button type="submit" name="register" class="btn btn-primary w-100">Создать пользователя</button>
                        </form>
                        
                        <div class="text-center mt-3">
                            <p>Уже зарегистрированы? <a href="login.php">Войти</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <p class="mb-0">© Корочки.есть - 2026</p>
    </footer>

    <script src="bootstrap.bundle.min.js"></script>
<script>
function togglePasswordVisibility(inputId, buttonId) {
    const input = document.getElementById(inputId);
    const button = document.getElementById(buttonId);
    
    if (input.type === 'password') {
        input.type = 'text';
        button.textContent = '🙈 Скрыть';
    } else {
        input.type = 'password';
        button.textContent = '👁️ Показать';
    }
}

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

const phoneInput = document.getElementById('phone');
if(phoneInput) {
    phoneInput.addEventListener('input', function(e) {
        let x = e.target.value.replace(/\D/g, '').match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
        if (!x[2] && x[1] !== '') {
            e.target.value = '8(' + x[1];
        } else {
            e.target.value = !x[2] ? x[1] : '8(' + x[2] + (x[3] ? ')' + x[3] : '') + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '');
        }
    });
}

const pass = document.querySelector('input[name="password"]');
const passConf = document.getElementById('confirm_password');

if(pass && passConf) {
    passConf.addEventListener('input', function() {
        if (this.value !== pass.value) {
            this.setCustomValidity('Пароли не совпадают');
        } else {
            this.setCustomValidity('');
        }
    });
}
</script>
</body>
</html>