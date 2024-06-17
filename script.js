document.addEventListener('DOMContentLoaded', () => {
    fetch('path_to_php_script.php')
        .then(response => response.json())
        .then(data => loadNews(data))
        .catch(error => console.error('Error:', error));
});
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
        container.innerHTML = ''; // Очищаем контейнер перед загрузкой
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
        fetch('path_to_php_script.php')
            .then(response => response.json())
            .then(data => loadNews(data))
            .catch(error => console.error('Error:', error));
    })
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
    function scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    