<?php
$conn = new mysqli('localhost', 'username', 'password', 'blog');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM posts WHERE is_private = 0";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<div class='post'>";
    echo "<h2>" . $row['title'] . "</h2>";
    echo "<p>" . $row['content'] . "</p>";
    echo "<p>Теги: " . $row['tags'] . "</p>";
    echo "</div>";
}

$conn->close();

require 'database.php'; // подключение к базе данных

// Получение всех постов для текущего пользователя
$user_id = $_SESSION['user_id'];
$query = $pdo->prepare("SELECT * FROM posts WHERE user_id = ?");
$query->execute([$user_id]);
$posts = $query->fetchAll();

foreach ($posts as $post) {
    echo "<div>";
    echo "<p>" . htmlspecialchars($post['content']) . "</p>";
    echo "<a href='edit_post.php?id=" . $post['id'] . "'>Редактировать</a> | ";
    echo "<a href='delete_post.php?id=" . $post['id'] . "' onclick='return confirm(\"Вы уверены, что хотите удалить этот пост?\");'>Удалить</a>";
    echo "</div>";
}
?>

<form method="GET" action="posts.php">
    <select name="tag">
        <option value="">Все теги</option>
        <?php
        $tags = $pdo->query("SELECT * FROM tags")->fetchAll();
        foreach ($tags as $tag) {
            echo "<option value='" . $tag['id'] . "'>" . htmlspecialchars($tag['name']) . "</option>";
        }
        ?>
    </select>
    <button type="submit">Фильтровать</button>
</form>