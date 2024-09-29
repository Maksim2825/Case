<?php
session_start();
require 'database.php'; // подключение к базе данных

if (!isset($_GET['id'])) {
    die('Отсутствует идентификатор поста.');
}

$post_id = $_GET['id'];

$query = $pdo->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
$query->execute([$post_id, $_SESSION['user_id']]);

header('Location: posts.php'); // Перенаправление после удаления
exit;
?>