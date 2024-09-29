<?php
session_start();
require 'database.php';

if (!isset($_SESSION['user_id'])) {
    die('Вы должны быть залогинены для отписки');
}

$follower_id = $_SESSION['user_id'];
$followed_id = $_GET['followed_id'];

$stmt = $pdo->prepare("DELETE FROM subscriptions WHERE follower_id = ? AND followed_id = ?");
if ($stmt->execute([$follower_id, $followed_id])) {
    echo "Вы успешно отписались от пользователя.";
} else {
    echo "Ошибка при отписке.";
}
?>