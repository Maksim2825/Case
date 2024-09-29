<?php
session_start();
require 'database.php'; // подключение к базе данных

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['id'];
    $new_content = $_POST['content'];

    $query = $pdo->prepare("UPDATE posts SET content = ? WHERE id = ? AND user_id = ?");
    $query->execute([$new_content, $post_id, $_SESSION['user_id']]);
    
    header('Location: posts.php'); // Перенаправление после редактирования
    exit;
}

if (!isset($_GET['id'])) {
    die('Отсутствует идентификатор поста.');
}

$post_id = $_GET['id'];
$query = $pdo->prepare("SELECT * FROM posts WHERE id = ? AND user_id = ?");
$query->execute([$post_id, $_SESSION['user_id']]);
$post = $query->fetch();

if (!$post) {
    die('Пост не найден или вы не имеете доступа к нему.');
}

foreach ($posts as $post) {
    echo "<div>";
    echo "<p>" . htmlspecialchars($post['content']) . "</p>";
    
    // Форма для добавления комментария
    echo "<form action='add_comment.php' method='POST'>";
    echo "<textarea name='content' placeholder='Ваш комментарий...'></textarea>";
    echo "<input type='hidden' name='post_id' value='" . $post['id'] . "'>";
    echo "<button type='submit'>Добавить комментарий</button>";
    echo "</form>";

    // Вывод комментариев
    $query = $pdo->prepare("SELECT * FROM comments WHERE post_id = ?");
    $query->execute([$post['id']]);
    $comments = $query->fetchAll();
    
    foreach ($comments as $comment) {
        echo "<p>" . htmlspecialchars($comment['content']) . "</p>";
    }

    echo "</div>";
}
?>

<form method="post">
    <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
    <textarea name="content"><?php echo htmlspecialchars($post['content']); ?></textarea>
    <button type="submit">Сохранить изменения</button>
</form>