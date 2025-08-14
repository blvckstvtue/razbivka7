<?php
// config.php - Конфигурация за портфолио на LionDevs
require_once __DIR__ . '/database/config.php';

// Основни настройки на сайта
$site_config = [
    'company_name' => 'LionDevs',
    'full_name' => 'Lion Developments',
    'tagline' => 'Unleashing Digital Excellence',
    'description' => 'Ние сме компания която се занимава с програмиране, дизайн, сървъри на игри, скриптове и всякакви проекти по изискване на клиенти.',
    'email' => 'contact@liondevs.com',
    'phone' => '+359 XXX XXX XXX',
    'address' => 'София, България',
    'social' => [
        'github' => 'https://github.com/liondevs',
        'discord' => 'https://discord.gg/liondevs',
        'facebook' => '#',
        'instagram' => '#',
        'linkedin' => '#'
    ]
];

// Главни секции на началната страница
$homepage_sections = [
    'hero' => [
        'title' => 'LIONDEVS',
        'subtitle' => 'UNLEASHING DIGITAL EXCELLENCE',
        'description' => 'Ние създаваме уникални програми, дизайни, сървъри и скриптове. Всеки проект е направен с перфекция и внимание към детайлите.',
        'background_image' => 'assets/images/hero-bg.jpg',
        'cta_primary' => [
            'text' => 'Виж Проектите',
            'link' => 'projects.php'
        ],
        'cta_secondary' => [
            'text' => 'Свържи се с нас',
            'link' => '#contact'
        ]
    ],
    'about' => [
        'title' => 'КОИ СМЕ НИЕ',
        'subtitle' => 'Професионалисти в програмирането',
        'description' => 'LionDevs е компания която се специализира в създаване на иновативни решения. От програми до дизайни, от сървъри на игри до сложни скриптове - ние правим всичко с най-високо качество.',
        'stats' => [
            ['number' => '50+', 'label' => 'Завършени проекти'],
            ['number' => '25+', 'label' => 'Доволни клиенти'],
            ['number' => '3+', 'label' => 'Години опит'],
            ['number' => '100%', 'label' => 'Качество']
        ]
    ],
    'services' => [
        'title' => 'НАШИТЕ УСЛУГИ',
        'subtitle' => 'Всичко което ви трябва на едно място',
        'items' => [
            [
                'icon' => 'fas fa-code',
                'title' => 'Програмиране',
                'description' => 'Създаваме уникални програми и приложения с най-новите технологии',
                'color' => '#ff6b35'
            ],
            [
                'icon' => 'fas fa-paint-brush',
                'title' => 'Дизайн',
                'description' => 'Дизайни на всякакви неща - логота, уеб дизайн, графичен дизайн',
                'color' => '#f7931e'
            ],
            [
                'icon' => 'fas fa-server',
                'title' => 'Game Сървъри',
                'description' => 'Настройка и поддръжка на сървъри за различни игри',
                'color' => '#00d4aa'
            ],
            [
                'icon' => 'fas fa-puzzle-piece',
                'title' => 'Скриптове & Плугини',
                'description' => 'Уникални скриптове и плугини за игри и приложения',
                'color' => '#c44569'
            ],
            [
                'icon' => 'fas fa-cogs',
                'title' => 'Проекти по поръчка',
                'description' => 'Специализирани решения според вашите нужди',
                'color' => '#6c5ce7'
            ],
            [
                'icon' => 'fas fa-rocket',
                'title' => 'Консултации',
                'description' => 'Професионални съвети и техническа поддръжка',
                'color' => '#fd79a8'
            ]
        ]
    ],
    'featured_project' => [
        'title' => 'FEATURED PROJECT',
        'subtitle' => 'Разгледайте нашия най-нов проект',
        'project_id' => '' // Ще се зареди от базата данни по-долу
    ]
];

// Проектите вече се управляват чрез админ панела и се зареждат от базата данни
// Този масив е запазен само като backup/fallback
$projects = [];

// Категории на проектите - вече се управляват от базата данни
$project_categories = [
    'all' => 'Всички'
];

// Load categories from database
try {
    $projectManager = new ProjectManager();
    $dbCategories = $projectManager->getCategories();
    foreach ($dbCategories as $cat) {
        $project_categories[$cat['category_key']] = $cat['category_name'];
    }
} catch (Exception $e) {
    // Keep default categories if database fails
}

// Технологии които използваме - вече се управляват от базата данни
$technologies = [];

// Load technologies from database
try {
    $projectManager = new ProjectManager();
    $dbTechnologies = $projectManager->getTechnologies();
    foreach ($dbTechnologies as $tech) {
        $technologies[] = $tech['name'];
    }
} catch (Exception $e) {
    // Keep empty array if database fails
}

// Настройки на темата
$theme_config = [
    'primary_color' => '#ff6b35',
    'secondary_color' => '#1a1a1a', 
    'accent_color' => '#f7931e',
    'background_dark' => '#0a0a0a',
    'background_light' => '#1a1a1a',
    'text_primary' => '#ffffff',
    'text_secondary' => '#cccccc',
    'success_color' => '#00d4aa',
    'warning_color' => '#f7931e',
    'danger_color' => '#ff4757'
];

// Function to load projects from database
function getProjectsFromDatabase($category = null) {
    try {
        $projectManager = new ProjectManager();
        $dbProjects = $projectManager->getAllProjects($category);
        
        // Convert database format to original config format
        $projects = [];
        foreach ($dbProjects as $dbProject) {
            $projects[] = [
                'id' => $dbProject['project_id'],
                'title' => $dbProject['title'],
                'category' => $dbProject['category'],
                'description' => $dbProject['description'],
                'long_description' => $dbProject['long_description'],
                'image' => $dbProject['image'],
                'gallery' => json_decode($dbProject['gallery'], true) ?: [],
                'technologies' => json_decode($dbProject['technologies'], true) ?: [],
                'features' => json_decode($dbProject['features'], true) ?: [],
                'status' => $dbProject['status'],
                'date' => $dbProject['date'],
                'client' => $dbProject['client'],
                'url' => $dbProject['url'],
                'github' => $dbProject['github']
            ];
        }
        return $projects;
    } catch (Exception $e) {
        // Return empty array if database fails
        return [];
    }
}

// Function to find project by ID
function findProjectById($project_id) {
    $projects = getProjectsFromDatabase();
    foreach ($projects as $project) {
        if ($project['id'] === $project_id) {
            return $project;
        }
    }
    return null;
}

// Load projects from database
$projects = getProjectsFromDatabase();

// Load featured project from settings
try {
    $settingsManager = new SettingsManager();
    $featured_project_id = $settingsManager->getSetting('featured_project_id');
    if ($featured_project_id) {
        $homepage_sections['featured_project']['project_id'] = $featured_project_id;
    } else {
        // Fallback to first project if no featured project is set
        $homepage_sections['featured_project']['project_id'] = !empty($projects) ? $projects[0]['id'] : '';
    }
} catch (Exception $e) {
    // Fallback to first project if database fails
    $homepage_sections['featured_project']['project_id'] = !empty($projects) ? $projects[0]['id'] : '';
}

?>