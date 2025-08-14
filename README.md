# 🦁 LionDevs Portfolio

Уникално портфолио за компанията **LionDevs (Lion Developments)** с брутален и модерен дизайн.

## 🚀 Особености

- **Брутален дизайн** с неон ефекти и анимации
- **Responsive дизайн** за всички устройства
- **PHP конфигурация** за лесно управление на проекти
- **Интерактивни анимации** и ефекти
- **Модални прозорци** за детайли на проектите
- **Филтриране** на проекти по категории
- **Loading screen** с анимации
- **Smooth scroll** и parallax ефекти

## 📁 Структура на файловете

```
liondevs-portfolio/
├── index.php              # Главна страница
├── projects.php            # Страница с проекти
├── config.php              # Конфигурация и проекти
├── README.md              # Този файл
├── assets/
│   ├── css/
│   │   ├── style.css      # Основни стилове
│   │   └── projects.css   # Стилове за проекти
│   ├── js/
│   │   ├── script.js      # Основен JavaScript
│   │   └── projects.js    # JavaScript за проекти
│   └── images/
│       ├── placeholder-project.jpg
│       └── projects/      # Изображения на проекти
└── example/               # Примерен дизайн
```

## 🛠️ Инсталация

1. **Клонирай репото:**
   ```bash
   git clone <repository-url>
   cd liondevs-portfolio
   ```

2. **Настройка на web сървър:**
   - Постави файловете в директорията на твоя web сървър (htdocs, www, public_html)
   - Уверете се че PHP е активирано

3. **Добави изображения:**
   - Замени placeholder изображенията в `assets/images/projects/`
   - Добави favicon и hero background изображения

## 📝 Как да добавяш/редактираш проекти

Всички проекти се управляват от файла `config.php`. Ето как:

### Добавяне на нов проект

Отвори `config.php` и добави нов проект в масива `$projects`:

```php
$projects[] = [
    'id' => 'my-new-project',                    // Уникален ID
    'title' => 'Моят нов проект',               // Заглавие
    'category' => 'Web Development',             // Категория
    'description' => 'Кратко описание...',      // Кратко описание
    'long_description' => 'Пълно описание...',  // Пълно описание
    'image' => 'assets/images/projects/my-project.jpg', // Изображение
    'gallery' => [                              // Галерия (опционално)
        'assets/images/projects/my-project-1.jpg',
        'assets/images/projects/my-project-2.jpg'
    ],
    'technologies' => ['PHP', 'JavaScript', 'CSS3'], // Технологии
    'features' => [                             // Функционалности
        'Responsive дизайн',
        'Admin панел',
        'API интеграция'
    ],
    'status' => 'completed',                    // completed или in_progress
    'date' => '2024-12-20',                     // Дата (YYYY-MM-DD)
    'client' => 'Име на клиента',               // Клиент
    'url' => 'https://example.com',             // URL на проекта (или '#')
    'github' => 'https://github.com/user/repo'  // GitHub (или '#')
];
```

### Редактиране на съществуващ проект

Намери проекта в масива `$projects` и промени желаните полета.

### Изтриване на проект

Премахни целия масив на проекта от `$projects`.

### Добавяне на нова категория

Добави новата категория в масива `$project_categories`:

```php
$project_categories = [
    'all' => 'Всички',
    'Web Development' => 'Уеб разработка',
    'My New Category' => 'Моята нова категория', // Нова категория
    // ...
];
```

## 🎨 Персонализиране на дизайна

### Цветове

Промени цветовете в `assets/css/style.css`:

```css
:root {
    --primary-color: #ff6b35;      /* Основен цвят */
    --secondary-color: #1a1a1a;    /* Вторичен цвят */
    --accent-color: #f7931e;       /* Акцентен цвят */
    --background-dark: #0a0a0a;    /* Тъмен фон */
    --background-light: #1a1a1a;   /* Светъл фон */
    /* ... */
}
```

### Шрифтове

Промени шрифтовете в `<head>` секцията на HTML файловете или в CSS:

```css
:root {
    --font-primary: 'Orbitron', monospace;    /* За заглавия */
    --font-secondary: 'Rajdhani', sans-serif; /* За текст */
}
```

### Анимации

Промени скоростта на анимациите:

```css
:root {
    --transition-fast: 0.2s ease;
    --transition-normal: 0.3s ease;
    --transition-slow: 0.5s ease;
}
```

## 🔧 Настройки на сайта

В `config.php` промени основните настройки:

```php
$site_config = [
    'company_name' => 'LionDevs',
    'full_name' => 'Lion Developments',
    'tagline' => 'Unleashing Digital Excellence',
    'description' => 'Твоето описание...',
    'email' => 'contact@liondevs.com',
    'phone' => '+359 XXX XXX XXX',
    'address' => 'София, България',
    'social' => [
        'github' => 'https://github.com/liondevs',
        'discord' => 'https://discord.gg/liondevs',
        // ...
    ]
];
```

## 📱 Responsive дизайн

Сайтът е напълно responsive и работи отлично на:
- 💻 Desktop (1200px+)
- 📱 Tablet (768px - 1199px)
- 📱 Mobile (до 767px)

## 🎯 SEO оптимизация

- Meta tags за всяка страница
- Semantic HTML структура
- Alt текстове за изображения
- Open Graph meta tags (може да се добави)

## 🚀 Performance оптимизации

- Lazy loading за изображения
- CSS и JavaScript минификация (препоръчва се)
- Image optimization (препоръчва се)
- CDN за библиотеки

## 🔒 Сигурност

- XSS защита в PHP
- CSRF защита (може да се добави)
- Input validation (може да се добави)

## 📞 Контакт форма

Контакт формата в момента е само за демонстрация. За да работи:

1. Създай PHP файл за обработка на формата
2. Добави SMTP настройки
3. Промени JavaScript-а в `assets/js/script.js`

Пример:

```php
// contact-handler.php
<?php
if ($_POST) {
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);
    
    // Изпрати email...
    
    echo json_encode(['success' => true]);
}
?>
```

## 🎨 Допълнителни ефекти

### Particles ефект

Particles ефектът се генерира автоматично с JavaScript. Можеш да промениш броя частици:

```javascript
// В assets/js/script.js
function createParticles(container) {
    const particleCount = 50; // Промени тук
    // ...
}
```

### Glitch ефект

Glitch ефектът за заглавията може да се настрои:

```javascript
// В assets/js/script.js
setInterval(() => {
    // Glitch логика...
}, 3000 + Math.random() * 2000); // Промени интервала
```

## 🐛 Отстраняване на проблеми

### Проблеми с изображенията

1. Провери дали файловете съществуват
2. Провери правилните пътища в `config.php`
3. Увери се че имаш права за четене на файловете

### JavaScript не работи

1. Провери конзолата за грешки (F12)
2. Увери се че всички скриптове се зареждат
3. Провери дали AOS библиотеката се зарежда

### CSS стилове не се прилагат

1. Провери дали CSS файловете се зареждат
2. Провери за синтактични грешки в CSS
3. Изчисти кеша на браузъра

## 🔄 Актуализации

За актуализации на портфолиото:

1. Backup на текущите файлове
2. Обнови файловете
3. Провери дали конфигурацията работи
4. Тествай на различни устройства

## 📄 Лиценз

Този проект е създаден за **LionDevs**. Всички права запазени.

## 👨‍💻 Разработчик

Създадено от **Claude (Anthropic)** за **LionDevs**.

---

**Забележка:** Не забравяй да замениш placeholder изображенията с реални снимки на твоите проекти за най-добър резултат! 🚀