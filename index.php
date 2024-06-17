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
            <li><a href="cand.php">Кандидату</a></li>
            <li><a href="news.php">Новости</a></li>
            <li><a href="ruk.php">Руководство отряда</a></li>
            <!-- Ваш PHP код -->
            <?php
            session_start();
            if (isset($_SESSION['loggedIn'])) {
                $button_text = 'Выход';
                $button_action = 'logout.php'; // Здесь должен быть URL для выхода пользователя
            } else {
                $button_text = 'Вход';
                $button_action = 'login.php'; // Здесь должен быть URL для страницы входа
            }
            ?>
            <!-- HTML-код кнопки -->
            <li><button class="nav-link button" id="loginButton"><?php echo $button_text; ?></button></li>
            <script>
                document.getElementById("loginButton").addEventListener("click", function() {
                    window.location.href = "<?php echo $button_action; ?>";
                });
            </script>
        </ul>
    </nav>
</div>

    </header>
    <main class="container-one">
        <div class="title">БУДУЩЕЕ - ЭТО СЕЙЧАС!</div>
        <div class="container">
            <div class="slider-container">
                <div class="slider" id="slider1">
                    <div class="slides">
                        <div class="slide"><img src="img/img1.png" alt="Image 1"></div>
                        <div class="slide"><img src="img/img2.png" alt="Image 2"></div>
                        <div class="slide"><img src="img/img3.png" alt="Image 3"></div>
                        <div class="slide"><img src="img/img4.png" alt="Image 4"></div>
                        <div class="slide"><img src="img/img5.png" alt="Image 5"></div>
                    </div>
                </div>
                <button class="arrow" id="prev1">&#10094;</button>
                <button class="arrow" id="next1">&#10095;</button>
            </div>
            <div class="commander-info">
                <img src="img/leha.png" alt="">
                <h3 class="text1">Командир отряда:</h3>
                <p class="text2">Картушин Алексей Николаевич</p>
            </div>
        </div>
        <div class="line">
            <div class="yellow"></div>
            <div class="black"></div>
            <div class="white"></div>
        </div>
    </main>

    <main class="container-two">
        <img class="img" src="img/img6.png" alt="">
        <div class="pos1">
            <h1 class="r1">ДЕНЬ ОТКРЫТЫХ ДВЕРЕЙ</h1>
            <h2 class="r2">По адресу : Г.Пенза, ул.Куйбышева 3</h2>
            <h3 class="r3">Обращаться в региональный штаб ОСП ”Тигр”</h3>
            <h3 class="r4">Мы познакомим тебя с отрядом, с особенностями несения службы с правоохранительными органами а также с песпективами личностной реализации </h3>
        </div>
        <div class="line1">
            <div class="yellow"></div>
            <div class="black"></div>
            <div class="white"></div>
        </div>
    </main>

    <main class="container-three">
        <div class="slider2">
            <div class="slides2">
                <div class="slide2"><img src="img/img7.png" alt="Image 1"></div>
                <div class="slide2"><img src="img/img8.png" alt="Image 2"></div>
                <div class="slide2"><img src="img/img9.png" alt="Image 3"></div>
            </div>
            <button class="arrow2 prev">&#10094;</button>
            <button class="arrow2 next">&#10095;</button>
        </div>
        <div class="line2">
            <div class="yellow"></div>
            <div class="black"></div>
            <div class="white"></div>
        </div>
    </main>
    <main class="news-section">
        <div class="news-container" id="news-container">
        </div>
        <a href="#" class="more-news-btn">Другие новости</a>
        <div class="line3">
            <div class="yellow"></div>
            <div class="black"></div>
            <div class="white"></div>
        </div>
    </main>
    <section class="video-section">
    <h2>ТИГР - СИЛА И ЧЕСТЬ</h2>
    <video width="560" height="315" autoplay muted loop>
        <source src="img/rolik.mp4" type="video/mp4">
    </video>
</section>

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
</div>

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
<script>
    function scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>

<script>
    // Функция для загрузки записей из таблицы applicants
    function loadRecords() {
        fetch('get_applicants.php') // Путь к PHP скрипту для загрузки данных
            .then(response => response.json())
            .then(data => {
                // Обработка полученных данных
                // Например, вывод на страницу или в модальное окно
            })
            .catch(error => console.error('Error:', error));
    }

    // Обработчик события для кнопки просмотра записей
    document.getElementById('viewRecordsBtn').addEventListener('click', () => {
        loadRecords(); // Загрузка записей при нажатии на кнопку
        // Добавьте здесь код для открытия модального окна
    });
</script>

<script>
    const newsData = [
        { title: 'Новость 1', img: 'img/news1.png' },
        { title: 'Новость 2', img: 'img/news2.png' },
        { title: 'Новость 3', img: 'img/news3.png' },
        { title: 'Новость 4', img: 'img/news4.png' },
        { title: 'Новость 5', img: 'img/news5.png' },
        { title: 'Новость 6', img: 'img/news6.png' }
    ];

    function loadNews(news) {
        const container = document.getElementById('news-container');
        news.forEach(item => {
            const newsItem = document.createElement('div');
            newsItem.className = 'news-item';
            newsItem.innerHTML = `
                <img src="${item.img}" alt="${item.title}">
                <div class="news-title">${item.title}</div>
            `;
            container.appendChild(newsItem);
        });
    }

    // Загрузка новостей при загрузке страницы
    document.addEventListener('DOMContentLoaded', () => {
        loadNews(newsData);
    });
</script>

<script>
    // Общая функция для управления слайдером
    function initSlider(containerSelector, slideSelector, prevSelector, nextSelector) {
        const container = document.querySelector(containerSelector);
        const slides = container.querySelectorAll(slideSelector);
        const prev = container.querySelector(prevSelector);
        const next = container.querySelector(nextSelector);
        let currentIndex = 0;

        function showSlide(index) {
            slides.forEach(slide => {
                slide.style.display = 'none';
            });
            slides[index].style.display = 'block';
        }

        showSlide(currentIndex);

        next.addEventListener('click', () => {
            currentIndex++;
            if (currentIndex >= slides.length) {
                currentIndex = 0;
            }
            showSlide(currentIndex);
        });

        prev.addEventListener('click', () => {
            currentIndex--;
            if (currentIndex < 0) {
                currentIndex = slides.length - 1;
            }
            showSlide(currentIndex);
        });
    }

    // Инициализация первого слайдера
    initSlider('.container-one', '.slide', '#prev1', '#next1');

    // Инициализация второго слайдера
    initSlider('.container-three', '.slide2', '.arrow2.prev', '.arrow2.next');
</script>
</body>
</html>
