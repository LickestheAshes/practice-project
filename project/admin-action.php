<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die('Доступ запрещён');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = (int)($_POST['id'] ?? 0);

    if ($id <= 0) {
        header('Location: admin.php');
        exit;
    }

    try {
        if ($action === 'update_status') {
            $status = $_POST['status'] ?? 'новый';
            $stmt = $pdo->prepare("UPDATE course SET status = ? WHERE id = ?");
            $stmt->execute([$status, $id]);
        } 
        elseif ($action === 'update_role') {
            $role = $_POST['role'] ?? 'user';
            $stmt = $pdo->prepare("UPDATE user SET role = ? WHERE id = ?");
            $stmt->execute([$role, $id]);
        }
    } catch (PDOException $e) {
        die('Ошибка базы данных: ' . $e->getMessage());
    }
}

header('Location: admin.php');
exit;