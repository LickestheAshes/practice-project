<?php 
session_start(); 

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old_input'] ?? [];
unset($_SESSION['errors'], $_SESSION['old_input']);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Запись на курс - Корочки.есть</title>
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="course-form.php">Записаться на курс</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="applications.php">Мои заявки</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="auth.php?logout">Выйти (<?= htmlspecialchars($_SESSION['username']) ?>)</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-5 flex-grow-1">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Запись на курс</h4>
                    </div>
                    <div class="card-body">
                        <form action="course-submit.php" method="POST" class="needs-validation" novalidate>
                            <!-- Course Name -->
                            <div class="mb-3">
                                <label for="courseName" class="form-label">Наименование курса</label>
                                <select class="form-select" id="courseName" name="course_name" required>
                                    <option value="">Выберите курс</option>
                                    <option value="course 1" <?= (isset($old['course_name']) && $old['course_name'] == 'course 1') ? 'selected' : '' ?>>Основы алгоритмизации и программирования</option>
                                    <option value="course 2" <?= (isset($old['course_name']) && $old['course_name'] == 'course 2') ? 'selected' : '' ?>>Основы веб-дизайна</option>
                                    <option value="course 3" <?= (isset($old['course_name']) && $old['course_name'] == 'course 3') ? 'selected' : '' ?>>Основы проектирования баз данных</option>
                                </select>
                                <div class="invalid-feedback">Выберите курс</div>
                                <?php if(isset($errors['course_name'])): ?>
                                    <div class="invalid-feedback d-block" style="color: red;"><?= htmlspecialchars($errors['course_name']) ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="startDate" class="form-label">Желаемая дата начала обучения</label>
                                <input type="date" class="form-control" id="startDate" name="start_date" 
                                       value="<?= htmlspecialchars($old['start_date'] ?? '') ?>"
                                       required>
                                <div class="invalid-feedback">Выберите дату начала обучения</div>
                                <div class="form-text">Дата не может быть в прошлом</div>
                                <?php if(isset($errors['start_date'])): ?>
                                    <div class="invalid-feedback d-block" style="color: red;"><?= htmlspecialchars($errors['start_date']) ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="paymentMethod" class="form-label">Способ оплаты</label>
                                <select class="form-select" id="paymentMethod" name="payment_method" required>
                                    <option value="">Выберите способ оплаты</option>
                                    <option value="нал" <?= (isset($old['payment_method']) && $old['payment_method'] == 'нал') ? 'selected' : '' ?>>Наличными</option>
                                    <option value="перевод" <?= (isset($old['payment_method']) && $old['payment_method'] == 'перевод') ? 'selected' : '' ?>>Переводом по номеру телефона</option>
                                </select>
                                <div class="invalid-feedback">Выберите способ оплаты</div>
                                <?php if(isset($errors['payment_method'])): ?>
                                    <div class="invalid-feedback d-block" style="color: red;"><?= htmlspecialchars($errors['payment_method']) ?></div>
                                <?php endif; ?>
                            </div>

                            <?php if(isset($_SESSION['success'])): ?>
                                <div class="alert alert-success" role="alert">
                                    <?= htmlspecialchars($_SESSION['success']) ?>
                                </div>
                                <?php unset($_SESSION['success']); ?>
                            <?php endif; ?>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success">Записаться</button>
                                <a href="applications.php" class="btn btn-secondary">К моим заявкам</a>
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

        const today = new Date().toISOString().split('T')[0];
        document.getElementById('startDate').setAttribute('min', today);

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

        document.querySelectorAll('.form-control, .form-select').forEach(input => {
            input.addEventListener('change', function() {
                if (this.checkValidity()) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                }
            });
        });
    </script>
</body>
</html>