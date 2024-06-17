<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tigr";

// Установка соединения с базой данных
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка соединения с базой данных: " . $conn->connect_error);
}

// Функция для обработки добавления новости
if (isset($_POST['add_news'])) {
    $title = $_POST['title'];
    $img = $_POST['img'];

    $sql = "INSERT INTO news (title, img) VALUES ('$title', '$img')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Новость успешно добавлена";
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }
}

// Функция для обработки удаления новости
if (isset($_GET['delete_news'])) {
    $id = $_GET['delete_news'];

    $sql = "DELETE FROM news WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Новость успешно удалена";
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }
}

// Функция для обработки изменения новости
if (isset($_POST['edit_news'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $img = $_POST['img'];

    $sql = "UPDATE news SET title='$title', img='$img' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Новость успешно изменена";
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }
}

// Получение данных о новостях
$sql = "SELECT id, title, img FROM news";
$result = $conn->query($sql);

if (!$result) {
    die("Ошибка выполнения запроса: " . $conn->error);
}

$news = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $news[] = $row;
    }
}

// Проверка роли пользователя
$user_role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

// Проверяем, является ли пользователь администратором
$isAdmin = $user_role === 'admin';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Тигр</title>
</head>
<body>
    <header>
        <div class="head">
          <a href="index.php"><img class="logo" src="img/logo.png" alt="Логотип"></a>
            <h1 class="text-one">Общественное объединение правоохранительной направленности</h1>
            <h1 class="text-two">ОТРЯД СОДЕЙСТВИЯ ПОЛИЦИИ «ТИГР»</h1>
            <img class="logo1" src="img/logo1.png" alt="Логотип">
        </div>
        <div class="menu">
            <nav>
                <ul>
                    <li><a href="otr.php">Об отряде</a></li>
                    <li><a href="cand.php">Кандидату</a></li>
                    <li><a href="news.php">Новости</a></li>
                    <li><a href="ruk.php">Руководство отряда</a></li>
                    <!-- ... -->
                    <?php if (isset($_SESSION['loggedIn'])): ?>
                        <li><button class="nav-link button" onclick="window.location.href='logout.php'">Выход</button></li>
                    <?php else: ?>
                        <li><button class="nav-link button" onclick="window.location.href='login.php'">Вход</button></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <?php if ($isAdmin): ?>
            <button class="btn" onclick="openModal()">Добавить новость</button>
        <?php endif; ?>
        <div class="cards-wrapper">
            <?php foreach ($news as $article): ?>
                <div class="card">
                    <img src="<?= htmlspecialchars($article['img']) ?>" class="card-img" alt="<?= htmlspecialchars($article['title']) ?>">
                    <div class="card-text">
                        <div class="card-heading">
                            <h3 class="card-title"><?= htmlspecialchars($article['title']) ?></h3>
                        </div>
                        <?php if ($isAdmin): ?>
                            <form method="POST" action="">
                                <input type="hidden" name="id" value="<?= $article['id'] ?>">
                                <input type="text" name="title" value="<?= htmlspecialchars($article['title']) ?>">
                                <input type="text" name="img" value="<?= htmlspecialchars($article['img']) ?>">
                                <button type="submit" name="edit_news">Редактировать</button>
                            </form>
                            <a href="?delete_news=<?= $article['id'] ?>">Удалить</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Модальное окно -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Добавить новость</h2>
            <form method="POST" action="">
                <label for="title">Заголовок:</label>
                <input type="text" id="title" name="title" required>
                <label for="img">Ссылка на изображение:</label>
                <input type="text" id="img" name="img" required>
                <button type="submit" name="add_news">Добавить новость</button>
            </form>
        </div>
    </div>

    <script>
        // Функция для открытия модального окна
        function openModal() {
            document.getElementById("myModal").style.display = "block";
        }

        // Функция для закрытия модального окна
        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }

        // Закрытие модального окна при клике вне его области
        window.onclick = function(event) {
            var modal = document.getElementById("myModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
    <style>
      .container {
    width: 1500px;
    margin: 100px auto 0; /* Отступ сверху для меню */
    margin-bottom: 100px; /* Отступ снизу для футера */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.cards-wrapper {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
    width: 100%;
}

.card {
    border: 1px solid #ccc;
    border-radius: 10px;
    padding: 20px;
    width: 300px;
    margin: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: #f9f9f9;
}

.card-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 10px;
}

.card-text {
    margin-top: 10px;
}

.card-heading {
    font-size: 24px;
    color: #333;
}

.card-title {
    margin: 0;
}

.card-info {
    margin-top: 10px;
    color: #777;
}

.ingredients {
    font-size: 14px;
}

.card-buttons {
    margin-top: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    background-color: #CE4B3A;
    color: #fff;
}

.btn:hover {
    background-color: #431212;
}

.button-card-text {
    font-size: 14px;
}

.card-price-bold {
    font-size: 18px;
}

form {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

input[type="text"] {
    padding: 5px;
    font-size: 14px;
}

/* Стили для модального окна */
.modal {
    display: none; /* Скрываем модальное окно по умолчанию */
    position: fixed; /* Фиксированное положение */
    z-index: 1; /* Поверх других элементов */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto; /* Добавляем прокрутку, если содержимое окна больше размеров экрана */
    background-color: rgba(0,0,0,0.4); /* Черный полупрозрачный фон */
}

/* Стили для содержимого модального окна */
.modal-content {
    background-color: #fefefe;
    margin: 15% auto; /* 15% от верха экрана */
    padding: 20px;
    border: 1px solid #888;
    width: 80%; /* Ширина контента */
    border-radius: 10px;
}

/* Стили для кнопки закрытия модального окна */
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

    </style>
</body>
</html>
