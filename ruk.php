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

// Проверяем, была ли установлена сессия для пользователя
if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) {
    $isAdmin = true;
} else {
    $isAdmin = false;
}

// Проверяем, установлена ли сессия loggedIn и получаем роль пользователя
if (isset($_SESSION['loggedIn'])) {
    $user_role = $_SESSION['role']; // Получаем роль пользователя из сессии
} else {
    $user_role = ''; // Пользователь не администратор
}

$sql = "SELECT id, title, img FROM news";
$result = $conn->query($sql);

$newsData = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $newsData[] = $row;
    }
} else {
    echo json_encode([]);
    exit;
}
$sql_applicants = "SELECT id, first_name, last_name, email, university, created_at FROM applicants";
    $result_applicants = $conn->query($sql_applicants);

    $applicants_data = array();
    if ($result_applicants->num_rows > 0) {
        while ($row = $result_applicants->fetch_assoc()) {
            $applicants_data[] = $row;
        }
    }
$conn->close();
?>

<!-- Кнопка для открытия модального окна с заявками -->
<?php if ($user_role === 'admin'): ?>
    <button id="openApplicantsModal">Просмотреть заявки</button>
<?php endif; ?>

<!-- Модальное окно для отображения заявок на вступление -->
<div id="view-applicants-modal" class="modal-users">
    <div class="modal-content-users">
        <span class="close" onclick="closeModal('view-applicants-modal')">&times;</span>
        <h2>Заявки на вступление</h2>
        <div class="applicants-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Email</th>
                    <th>Университет</th>
                    <th>Дата подачи</th>
                </tr>
                <?php foreach ($applicants_data as $applicant): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($applicant['id']); ?></td>
                        <td><?php echo htmlspecialchars($applicant['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($applicant['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($applicant['email']); ?></td>
                        <td><?php echo htmlspecialchars($applicant['university']); ?></td>
                        <td><?php echo htmlspecialchars($applicant['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>

<script>
    // Функция для открытия модального окна
    function openModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.style.display = "block";
    }

    // Функция для закрытия модального окна
    function closeModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.style.display = "none";
    }

    // Обработчик клика на кнопку открытия модального окна
    document.getElementById("openApplicantsModal").addEventListener("click", function() {
        openModal("view-applicants-modal");
    });
</script>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Тигр</title>
</head>
<body>
    
    <header>
        <div class="head">
          <a href="index.php">  <img class="logo" src="img/logo.png" alt=""></a>
            <h1 class="text-one">Общественное объединение правоохранительной направлености</h1>
            <h1 class="text-two">ОТРЯД СОДЕЙСТВИЯ ПОЛИЦИИ «ТИГР»</h1>
            <img class="logo1" src="img/logo1.png" alt="">
        </div>
        <div class="menu">
            <nav>
                <ul>
                    <li><a href="otr.php">Об отряде</a></li>
                    <li><a href="cand.php">Кадидату</a></li>
                    <li><a href="news.php">Новости</a></li>
                    <li><a href="ruk.php">Руководство отряда</a></li>
                    ...
                    <?php
              session_start();
              
              // Проверяем, установлена ли сессия loggedIn
              if (isset($_SESSION['loggedIn'])) {
                  $button_text = 'Выход';
                  $button_action = 'logout.php'; // Здесь должен быть URL для выхода пользователя
              } else {
                  $button_text = 'Вход';
                  $button_action = 'login.php'; // Здесь должен быть URL для страницы входа
              }
              ?>
              
              <!-- HTML-код кнопки -->
              <button class="nav-link button" id="loginButton"><?php echo $button_text; ?></button>

              <script>
                  document.getElementById("loginButton").addEventListener("click", function() {
                      window.location.href = "<?php echo $button_action; ?>";
                  });
              </script>
                    </li>
                </ul>
              
                </ul>
            </nav>
        </div>
    </header>
    <h1 class="c1">Руководство отряда</h1>
   <section class="ruk1">
<div>
    <img src="img/ruk1.png" alt="">
    <h1>Картушин Алексей Николаевич</h1>
    <p>Командир отряда содействия полиции Тигр</p>
</div>
<div class="ruk2">
<img src="img/ruk2.png" alt="">
    <h1>Белоусов Богдан Александрович</h1>
    <p>Начальник штаба </p>
</div>
   </section>

   <section class="ruk3">
    <img src="img/ruk3.png" alt="">
    <h1>Артболевская Роза Александровна</h1>
    <p>Помощник начальника штаба</p>
   </section>


<footer class="footer">
    <div class="footer-content">
        <div class="footer-headings">
            <h1>Г.Пенза, ул.Куйбышева 3а</h1>
            <h1>Командир отряда: Картушин Алексей Николаевич</h1>
            <h1>Телефон +7 (970) 120-43-69</h1>
            
        </div>
        <div class="footer-image">
            <img src="img/logo.png" alt="Footer Image">
        </div>
    </div>
    <h1>Пенза 2024</h1>
    <button class="back-to-top" onclick="scrollToTop()">Назад</button>
</footer>