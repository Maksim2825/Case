<?php
session_start();
require 'database.php'; // файл для подключения к базе данных

if (!isset($_SESSION['user_id'])) {
    die('Вы должны быть залогинены для подписки');
}

$follower_id = $_SESSION['user_id']; // ID текущего пользователя
$followed_id = $_GET['followed_id']; // ID пользователя, на которого подписываемся

// Проверяем, что пользователь не подписан на этого пользователя
$query = $pdo->prepare("SELECT * FROM subscriptions WHERE follower_id = ? AND followed_id = ?");
$query->execute([$follower_id, $followed_id]);

if ($query->rowCount() > 0) {
    echo "Вы уже подписаны на этого пользователя.";
} else {
    // Выполняем подписку
    $stmt = $pdo->prepare("INSERT INTO subscriptions (follower_id, followed_id) VALUES (?, ?)");
    if ($stmt->execute([$follower_id, $followed_id])) {
        echo "Вы успешно подписались на пользователя.";
    } else {
        echo "Ошибка при подписке.";
    }
}
?>