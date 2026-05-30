<?php 
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

$users = $pdo->query("SELECT id, username, full_name, email, role FROM user ORDER BY id DESC")->fetchAll();

$apps = $pdo->query("
    SELECT c.id, u.username, c.course_name, c.start_date, c.payment_method, c.status 
    FROM course c 
    JOIN user u ON c.user_id = u.id 
    ORDER BY c.id DESC
")->fetchAll();

$courseNames = [
    'course 1' => 'Основы алгоритмизации и программирования',
    'course 2' => 'Основы веб-дизайна',
    'course 3' => 'Основы проектирования баз данных'
];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель - Корочки.есть</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-danger mb-4">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Панель администратора</span>
            <a href="index.php" class="btn btn-sm btn-light">Вернуться на сайт</a>
        </div>
    </nav>

    <main class="container">

        <ul class="nav nav-tabs mb-3" id="adminTab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#users-tab">Пользователи (<?= count($users) ?>)</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#apps-tab">Заявки (<?= count($apps) ?>)</button>
            </li>
        </ul>

        <div class="tab-content">

            <div class="tab-pane fade show active" id="users-tab">
                <div class="card shadow">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Логин</th>
                                    <th>ФИО</th>
                                    <th>Email</th>
                                    <th>Роль</th>
                                    <th>Действие</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $u): ?>
                                <tr>
                                    <td><?= $u['id'] ?></td>
                                    <td><?= htmlspecialchars($u['username']) ?></td>
                                    <td><?= htmlspecialchars($u['full_name']) ?></td>
                                    <td><?= htmlspecialchars($u['email']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $u['role'] === 'admin' ? 'danger' : 'secondary' ?>">
                                            <?= $u['role'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <form action="admin-action.php" method="POST" class="d-flex gap-2">
                                            <input type="hidden" name="action" value="update_role">
                                            <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                            <select name="role" class="form-select form-select-sm">
                                                <option value="user" <?= $u['role']=='user'?'selected':'' ?>>user</option>
                                                <option value="admin" <?= $u['role']=='admin'?'selected':'' ?>>admin</option>
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-primary">Применить</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="apps-tab">
                <div class="card shadow">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Пользователь</th>
                                    <th>Курс</th>
                                    <th>Дата</th>
                                    <th>Оплата</th>
                                    <th>Статус</th>
                                    <th>Действие</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($apps as $a): ?>
                                <tr>
                                    <td><?= $a['id'] ?></td>
                                    <td><?= htmlspecialchars($a['username']) ?></td>
                                    <td><?= htmlspecialchars($courseNames[$a['course_name']] ?? $a['course_name']) ?></td>
                                    <td><?= htmlspecialchars($a['start_date']) ?></td>
                                    <td><?= htmlspecialchars($a['payment_method']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= match($a['status']) {
                                            'новый' => 'info',
                                            'в процессе' => 'warning',
                                            'завершен' => 'success',
                                            default => 'secondary'
                                        } ?>">
                                            <?= htmlspecialchars($a['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <form action="admin-action.php" method="POST" class="d-flex gap-2">
                                            <input type="hidden" name="action" value="update_status">
                                            <input type="hidden" name="id" value="<?= $a['id'] ?>">
                                            <select name="status" class="form-select form-select-sm">
                                                <option value="новый" <?= $a['status']=='новый'?'selected':'' ?>>Новый</option>
                                                <option value="в процессе" <?= $a['status']=='в процессе'?'selected':'' ?>>В процессе</option>
                                                <option value="завершен" <?= $a['status']=='завершен'?'selected':'' ?>>Завершен</option>
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-primary">Обновить</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="bootstrap.bundle.min.js"></script>
</body>
</html>