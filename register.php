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
    $login = $_POST["reg_login"];
    $password = $_POST["reg_password"]; 
    $check_sql = "SELECT * FROM users WHERE login='$login'";
    $check_result = $conn->query($check_sql);
    if ($check_result->num_rows > 0) {
        $regErrorMessage = "Пользователь с таким логином уже есть.";
    } else { 
        $sql_insert_user = "INSERT INTO users (login, password, role) VALUES ('$login', '$password', 'user')";
        if ($conn->query($sql_insert_user) === TRUE) {
            header("Location: index.php"); 
            exit();
        } else {
            echo "Error: " . $sql_insert_user . "<br>" . $conn->error;
        }
    }
}
$conn->close();
?>
