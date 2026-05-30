<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корочки.есть - Образовательный центр</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <style>
        .carousel-item img {
            height: 500px;
            object-fit: cover;
        }
        .logo-container img {
            max-height: 80px;
            margin: 5px;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100 m-0">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="logo2.png" alt="Логотип" height="32" class="d-inline-block align-text-top me-2">
            Корочки.есть
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user_id'])): ?>

                    <li class="nav-item">
                        <a class="nav-link" href="course-form.php">Записаться на курс</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="applications.php">Мои заявки</a>
                    </li>
                    
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link fw-bold text-warning" href="admin.php">Панель администратора</a>
                        </li>
                    <?php endif; ?>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="auth.php?logout">Выход (<?= htmlspecialchars($_SESSION['username']) ?>)</a>
                    </li>
                <?php else: ?>

                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Войти</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Регистрация</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container text-center my-4">
    <img src="logo4.png" alt="Логотип" height="80">
</div>

<div class="container mt-4">
    <div id="educationSlider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#educationSlider" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#educationSlider" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#educationSlider" data-bs-slide-to="2"></button>
            <button type="button" data-bs-target="#educationSlider" data-bs-slide-to="3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="slide1.webp" class="d-block w-100" alt="Education 1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Профессиональное обучение</h5>
                    <p>Получите востребованную профессию</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="slide2.webp" class="d-block w-100" alt="Education 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Опытные преподаватели</h5>
                    <p>Учитесь у лучших специалистов</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="slide3.webp" class="d-block w-100" alt="Education 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Современные программы</h5>
                    <p>Актуальные знания для карьеры</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="slide4.webp" class="d-block w-100" alt="Education 4">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Государственный диплом</h5>
                    <p>Официальное подтверждение квалификации</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#educationSlider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#educationSlider" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>

<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card text-center mb-3 shadow">
                <div class="card-body">
                    <h5 class="card-title">Качественное образование</h5>
                    <p class="card-text">Современные учебные программы и методики</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center mb-3 shadow">
                <div class="card-body">
                    <h5 class="card-title">Практические навыки</h5>
                    <p class="card-text">Обучение с применением реальных кейсов</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center mb-3 shadow">
                <div class="card-body">
                    <h5 class="card-title">Признание работодателей</h5>
                    <p class="card-text">Наши сертификаты ценятся на рынке труда</p>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="bg-dark text-white text-center py-3 mt-auto">
    <div class="container">
        <p class="mb-0">© 2026 Корочки.есть - Образовательный центр</p>
        <p class="mb-0">8(800)555-35-35 | MalaiseMesuredAndSteady@mail.ru</p>
    </div>
</footer>

    <script src="bootstrap.bundle.min.js"></script>
</body>
</html>