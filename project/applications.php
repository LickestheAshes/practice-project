<?php 
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM course WHERE user_id = ? ORDER BY id DESC");
$stmt->execute([$user_id]);
$applications = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои заявки - Корочки.есть</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body class="d-flex flex-column min-vh-100 m-0 bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="logo2.png" alt="Logo" height="32" class="d-inline-block align-text-top me-2">
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Просмотр заявок</h2>
            <a href="course-form.php" class="btn btn-success">Записаться на курс</a>
        </div>

        <div class="card shadow">
            <div class="card-body">
                <p class="text-muted">Показаны записи 1-<?= count($applications) ?> из <?= count($applications) ?>.</p>
                
                <?php if (empty($applications)): ?>
                    <div class="text-center py-5">
                        <h5 class="text-muted">У вас пока нет заявок</h5>
                        <p class="text-muted">Запишитесь на первый курс!</p>
                        <a href="course-form.php" class="btn btn-primary">Записаться на курс</a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Наименование курса</th>
                                    <th>Желаемая дата начала обучения</th>
                                    <th>Способ оплаты</th>
                                    <th>Статус</th>
                                    <th>Отзыв на курс</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($applications as $app): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($app['id']) ?></td>
                                        <td>
                                            <?php
                                            $courses = [
                                                'course 1' => 'Основы алгоритмизации и программирования',
                                                'course 2' => 'Основы веб-дизайна',
                                                'course 3' => 'Основы проектирования баз данных'
                                            ];
                                            echo htmlspecialchars($courses[$app['course_name']] ?? $app['course_name']);
                                            ?>
                                        </td>
                                        <td><?= htmlspecialchars($app['start_date']) ?></td>
                                        <td><?= htmlspecialchars($app['payment_method']) ?></td>
                                        <td><span class="badge bg-info text-dark"><?= htmlspecialchars($app['status']) ?></span></td>
                                        <td>
                                            <?php if ($app['status'] === 'завершен'): ?>
                                                <button class="btn btn-sm btn-primary">Оставить отзыв</button>
                                            <?php else: ?>
                                                <span class="text-muted">Нельзя оставить отзыв</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <div class="container">
            <p class="mb-0">&copy; Корочки.есть - 2026</p>
        </div>
    </footer>

    <script src="bootstrap.bundle.min.js"></script>
</body>
</html>