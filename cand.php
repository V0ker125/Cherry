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
    <section class="candidate-section">
    <h1 class="c1">Кандидату</h1>
    <div class="criteria-list">
        <h1>Для того чтобы вступить в отряд необходимо :</h1>
        <p>1.Возраст 18 лет        </p>
        <p>2.Быть студентом ВУЗа
        </p>
        <p>3.Иметь желание развиваться и учится</p>
        <p>4.Отсутсвие судимости</p>
        <p>5.Физически развит ,психологически устойчив к стрессовым ситуациям</p>
    </div>
    <div class="form-section">
    <div class="form-container">
        <h1>Подать заявку на вступление в отряд</h1>
        <form action="submit_form.php" method="post">
            <div class="form-group">
                <label for="first_name">Имя</label>
                <input type="text" id="first_name" name="first_name" placeholder="Введите имя" required>
            </div>
            <div class="form-group">
                <label for="last_name">Фамилия</label>
                <input type="text" id="last_name" name="last_name" placeholder="Введите фамилию" required>
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" id="email" name="email" placeholder="email@janesfakedomain.net" required>
            </div>
            <div class="form-group">
                <label for="university">Название ВУЗа</label>
                <textarea id="university" name="university" placeholder="Введите название" required></textarea>
            </div>
            <div class="form-group">
                <input type="submit" value="Отправить">
            </div>
        </form>
    </div>

        <div class="map-container">
            <!-- Вставьте карту Google Maps сюда -->
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835434509387!2d144.95565131531568!3d-37.81732797975193!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65d43f2b65f2b%3A0xef0c48885df44f03!2sFlinders%20Street%20Station!5e0!3m2!1sen!2sau!4v1645684750570!5m2!1sen!2sau" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
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