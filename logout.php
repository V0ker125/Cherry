
<?php
session_start();

// Уничтожаем сессию
session_destroy();

// Перенаправляем пользователя на другую страницу
header("Location: index.php");
exit();
?>

<?php
// Инициализация сессии
session_start();

// Уничтожение всех переменных сессии
$_SESSION = array();

// Если требуется уничтожить сессию, также удаляем сессионные куки.
// Обратите внимание, что это уничтожит сессию и не только данные сессии!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Уничтожение сессии
session_destroy();

// Перенаправление пользователя на страницу входа или на другую страницу
header("Location: index.php"); // Замените 'index.php' на путь к странице, куда вы хотите перенаправить пользователя после выхода
exit();
?>
