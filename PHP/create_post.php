<?php
session_start();
$conn = new mysqli('localhost', 'username', 'password', 'blog');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $tags = $_POST['tags'];
    $is_private = isset($_POST['is_private']) ? 1 : 0;
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content, tags, is_private) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssi", $user_id, $title, $content, $tags, $is_private);
    $stmt->execute();
    $stmt->close();

    header("Location: posts.html");
}
$conn->close();
?>