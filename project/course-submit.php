<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $course_name = trim($_POST['course_name']);
    $start_date = trim($_POST['start_date']);
    $payment_method = trim($_POST['payment_method']);

    $errors = [];

    if (!in_array($course_name, ['course 1', 'course 2', 'course 3'])) {
        $errors['course_name'] = 'Выберите корректный курс';
    }

    if (empty($start_date)) {
        $errors['start_date'] = 'Выберите дату';
    } else {
        // Проверяем, что дата не в прошлом
        $input_date = DateTime::createFromFormat('Y-m-d', $start_date);
        $today = new DateTime();
        if ($input_date < $today) {
            $errors['start_date'] = 'Дата не может быть в прошлом';
        }
    }

    if (!in_array($payment_method, ['нал', 'перевод'])) {
        $errors['payment_method'] = 'Выберите способ оплаты';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO course (user_id, course_name, start_date, payment_method, status) VALUES (?, ?, ?, ?, 'новый')");
        $stmt->execute([$user_id, $course_name, $start_date, $payment_method]);
        
        $_SESSION['success'] = 'Заявка успешно создана!';
        header('Location: applications.php');
        exit;
    } else {
        $_SESSION['errors'] = $errors;
        $_SESSION['old_input'] = $_POST;
        header('Location: course-form.php');
        exit;
    }
} else {
    header('Location: course-form.php');
    exit;
}
?>