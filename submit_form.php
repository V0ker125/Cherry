<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tigr";

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $university = $_POST['university'];

    // Prepared statement for security
    $stmt = $conn->prepare("INSERT INTO applicants (first_name, last_name, email, university) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $first_name, $last_name, $email, $university);

    if ($stmt->execute() === TRUE) {
        // Перенаправление на index.php после успешного сохранения данных
        header('Location: index.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
