<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!file_exists('db.php')) {
    die('Ошибка: файл db.php не найден!');
}

require 'db.php';

if (!isset($pdo)) {
    die('Ошибка: переменная $pdo не инициализирована! Проверь db.php');
}

if (isset($_POST['register'])) {
    try {
        $login = trim($_POST['login']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $full_name = trim($_POST['full_name']);
        $phone = trim($_POST['phone']);
        $email = trim($_POST['email']);

        $errors = [];

        if (!preg_match('/^[a-zA-Z0-9]{6,}$/', $login)) {
            $errors['login'] = 'Логин: латиница и цифры, мин. 6 символов';
        }
        
        if (strlen($password) < 8) {
            $errors['password'] = 'Пароль: мин. 8 символов';
        }
        
        if ($password !== $confirm_password) {
            $errors['confirm_password'] = 'Пароли не совпадают';
        }
        
        if (!preg_match('/^[а-яА-ЯёЁ\s]{2,}$/u', $full_name)) {
            $errors['full_name'] = 'ФИО: только кириллица';
        }
        
        if (!preg_match('/^8\(\d{3}\)\d{3}-\d{2}-\d{2}$/', $phone)) {
            $errors['phone'] = 'Телефон: формат 8(XXX)XXX-XX-XX';
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email: некорректный формат';
        }

        $stmt = $pdo->prepare("SELECT id FROM user WHERE username = ?");
        $stmt->execute([$login]);
        if ($stmt->fetch()) {
            $errors['login'] = 'Логин уже занят';
        }

        if (empty($errors)) {

            $hash = password_hash($password, PASSWORD_DEFAULT);
            

            $stmt = $pdo->prepare("INSERT INTO user (username, password, full_name, phone, email) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$login, $hash, $full_name, $phone, $email]);
            

            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['username'] = $login;
            

            header('Location: index.php');
            exit;
        } else {

            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            header('Location: register.php');
            exit;
        }
    } catch (Exception $e) {
        die('Ошибка при регистрации: ' . $e->getMessage());
    }
}

if (isset($_POST['login'])) {
    try {
        $login = trim($_POST['login']);
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->execute([$login]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role']; // <-- ДОБАВИТЬ ЭТУ СТРОКУ
            header('Location: index.php');
            exit;
        } else {
            $_SESSION['errors'] = ['login' => 'Неверный логин или пароль'];
            header('Location: login.php');
            exit;
        }
    } catch (Exception $e) {
        die('Ошибка при входе: ' . $e->getMessage());
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

?>