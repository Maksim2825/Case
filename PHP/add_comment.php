<?php
session_start();
require 'database.php';

$content = $_POST['content'];
$post_id = $_POST['post_id'];
$user_id = $_SESSION['user_id'];

$query = $pdo->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)");
$query->execute([$post_id, $user_id, $content]);

header('Location: posts.php');
?>