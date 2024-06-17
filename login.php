<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tigr";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['username']; 
    $password = $_POST['password'];

    $login = mysqli_real_escape_string($conn, $login);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "SELECT * FROM users WHERE login='$login' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $role = $row['role'];
        
        switch ($role) {
            case 'admin':
                $_SESSION['loggedIn'] = true;
                $_SESSION['role'] = 'admin'; // Устанавливаем роль пользователя
                header("Location: index.php");
                exit;
            case 'user':
                $_SESSION['loggedIn'] = true;
                $_SESSION['role'] = 'user'; // Устанавливаем роль пользователя
                header("Location: index.php");
                exit;
            default:
                $errorMessage = "Unknown role";
        }
    }
}
    $conn->close();
    ?>
    

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма входа и регистрации</title>
    <style>
   body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 300px;
            position: relative; /* Добавляем позиционирование */
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"],
        .login-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .login-container input[type="submit"] {
            background-color: black; /* Цвет изменен на #00AF64 */
            color: #fff;
            cursor: pointer;
        }

        .login-container input[type="submit"]:hover {
            background-color: black; /* Цвет изменен на #007a3d */
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
            text-align: center;
        }

        /* Стили для кнопки Назад */
        .back-button {
            position: absolute;
            top: 10px;
            left: 10px;
            display: inline-block;
            padding: 10px 20px;
            background-color: black; /* Цвет изменен на #00AF64 */
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .back-button:hover {
            background-color: #007a3d; /* Цвет изменен на #007a3d */
        }
    </style>
</head>
<body>

<!-- Кнопка "Назад" -->
<a class="back-button" href="index.php">Назад</a>

<div class="login-container">
    <h2>Вход</h2>
    <form method="post" action="login.php">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($errorMessage)) {
            echo '<p class="error-message">' . $errorMessage . '</p>';
        }
        ?>
        <input type="text" name="username" placeholder="Имя пользователя" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <input type="submit" value="Войти">
    </form>
    <h2>Регистрация</h2>
    <form method="post" action="register.php">
        <!-- Аналогично, добавьте обработку ошибок регистрации -->
        <input type="text" name="reg_login" placeholder="Имя пользователя" required>
        <input type="password" name="reg_password" placeholder="Пароль" required>
        <input type="submit" value="Зарегистрироваться">
    </form>
</div>

</body>
</html>
