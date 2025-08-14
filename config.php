<?php
// config.php - Конфигурация за портфолио на LionDevs
require_once __DIR__ . '/database/config.php';

// Language system
session_start();

// Set default language to English
$current_language = isset($_SESSION['language']) ? $_SESSION['language'] : 'en';

// Handle language switching
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'bg'])) {
    $_SESSION['language'] = $_GET['lang'];
    $current_language = $_GET['lang'];
    
    // Redirect to remove lang parameter from URL
    $redirect_url = strtok($_SERVER["REQUEST_URI"], '?');
    if (!empty($_GET)) {
        $params = $_GET;
        unset($params['lang']);
        if (!empty($params)) {
            $redirect_url .= '?' . http_build_query($params);
        }
    }
    header("Location: $redirect_url");
    exit;
}

// Load language file
$lang = [];
$lang_file = __DIR__ . "/languages/{$current_language}.php";
if (file_exists($lang_file)) {
    $lang = require $lang_file;
}

// Translation function
function t($key, $default = '') {
    global $lang;
    return isset($lang[$key]) ? $lang[$key] : ($default ?: $key);
}

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
        'subtitle' => t('hero_subtitle'),
        'description' => t('hero_description'),
        'background_image' => 'assets/images/hero-bg.jpg',
        'cta_primary' => [
            'text' => t('hero_cta_primary'),
            'link' => 'projects.php'
        ],
        'cta_secondary' => [
            'text' => t('hero_cta_secondary'),
            'link' => '#contact'
        ]
    ],
    'about' => [
        'title' => t('about_title'),
        'subtitle' => t('about_subtitle'),
        'description' => t('about_description'),
        'stats' => [
            ['number' => '50+', 'label' => t('about_stat_projects')],
            ['number' => '25+', 'label' => t('about_stat_clients')],
            ['number' => '3+', 'label' => t('about_stat_experience')],
            ['number' => '100%', 'label' => t('about_stat_quality')]
        ]
    ],
    'services' => [
        'title' => t('services_title'),
        'subtitle' => t('services_subtitle'),
        'items' => [
            [
                'icon' => 'fas fa-code',
                'title' => t('service_programming'),
                'description' => t('service_programming_desc'),
                'color' => '#ff6b35'
            ],
            [
                'icon' => 'fas fa-paint-brush',
                'title' => t('service_design'),
                'description' => t('service_design_desc'),
                'color' => '#f7931e'
            ],
            [
                'icon' => 'fas fa-server',
                'title' => t('service_servers'),
                'description' => t('service_servers_desc'),
                'color' => '#00d4aa'
            ],
            [
                'icon' => 'fas fa-puzzle-piece',
                'title' => t('service_scripts'),
                'description' => t('service_scripts_desc'),
                'color' => '#c44569'
            ],
            [
                'icon' => 'fas fa-cogs',
                'title' => t('service_custom'),
                'description' => t('service_custom_desc'),
                'color' => '#6c5ce7'
            ],
            [
                'icon' => 'fas fa-rocket',
                'title' => t('service_consulting'),
                'description' => t('service_consulting_desc'),
                'color' => '#fd79a8'
            ]
        ]
    ],
    'featured_project' => [
        'title' => t('featured_title'),
        'subtitle' => t('featured_subtitle'),
        'project_id' => '' // Ще се зареди от базата данни по-долу
    ]
];

// Проектите вече се управляват чрез админ панела и се зареждат от базата данни
// Този масив е запазен само като backup/fallback
$projects = [];

// Категории на проектите - вече се управляват от базата данни
$project_categories = [
    'all' => t('projects_category_all')
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