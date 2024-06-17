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
    <section class="about-section">
        <h1 class="c1">Об отряде</h1>
    <div class="about-block">
        <div class="about-block-text">
            <h2 class="about-block-title1">Основные сведения</h2>
            <p class="about-block-info1">Общественное объединение правоохранительной направленности отряд содействия полиции Тигр</p>
        </div>
        <img src="img/o1.png" alt="Image">
    </div>
    <div class="about-block">
        <div class="about-block-text">
            <h2 class="about-block-title">Дата создания</h2>
            <p class="about-block-info">Днём рождения отряда считается 9 декабря 2022 года за своё столь продолжительное время работы отряд «Тигр» может похвалиться немалыми достижениями а также немалым вкладом бойцов в решение проблемы связанной с профилактикой  правонарушений  в регионе.</p>
        </div>
        <img src="img/o2.png" alt="Image">
    </div>
    <div class="about-block">
        <div class="about-block-text">
            <h2 class="about-block-title1">Основные сведения</h2>
            <p class="about-block-info1">Общественное объединение правоохранительной направленности отряд содействия полиции Тигр</p>
        </div>
        <img src="img/03.png" alt="Image">
    </div>
    <div class="about-block">
        <div class="about-block-text">
            <h2 class="about-block-title">Дата создания</h2>
            <p class="about-block-info">Днём рождения отряда считается 9 декабря 2022 года за своё столь продолжительное время работы отряд «Тигр» может похвалиться немалыми достижениями а также немалым вкладом бойцов в решение проблемы связанной с профилактикой  правонарушений  в регионе.</p>
        </div>
        <img src="img/o4.png" alt="Image">
    </div>
    <div class="about-block">
        <div class="about-block-text">
            <h2 class="about-block-title1">Основные сведения</h2>
            <p class="about-block-info1">Общественное объединение правоохранительной направленности отряд содействия полиции Тигр</p>
        </div>
        <img src="img/o5.png" alt="Image">
    </div>
</section>


<div class="proposal-section">
    <div class="proposal-content">
        <h1 class="proposal-text">Есть предложение по организации деятельности отряда?<br>
        Или вы знаете как сделать отряд лучше?</h1>
        <button class="proposal-button">Написать о проблеме</button>
    </div>
    <div class="proposal-image">
        <img src="img/st.png" alt="Proposal Image">
    </div>
</div>
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
