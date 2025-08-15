<?php
// config.php - Конфигурация за портфолио на LionDevs
require_once __DIR__ . '/database/config.php';
require_once __DIR__ . '/languages.php';

// Основни настройки на сайта
$site_config = [
    'company_name' => t('site.company_name'),
    'full_name' => t('site.full_name'),
    'tagline' => t('site.tagline'),
    'description' => t('site.description'),
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
        'subtitle' => t('hero.subtitle'),
        'description' => t('hero.description'),
        'background_image' => 'assets/images/hero-bg.jpg',
        'cta_primary' => [
            'text' => t('hero.cta_primary'),
            'link' => 'projects.php'
        ],
        'cta_secondary' => [
            'text' => t('hero.cta_secondary'),
            'link' => '#contact'
        ]
    ],
    'about' => [
        'title' => t('about.title'),
        'subtitle' => t('about.subtitle'),
        'description' => t('about.description'),
        'stats' => [
            ['number' => '50+', 'label' => t('about.stats.projects')],
            ['number' => '25+', 'label' => t('about.stats.clients')],
            ['number' => '3+', 'label' => t('about.stats.experience')],
            ['number' => '100%', 'label' => t('about.stats.quality')]
        ]
    ],
    'services' => [
        'title' => t('services.title'),
        'subtitle' => t('services.subtitle'),
        'items' => [
            [
                'icon' => 'fas fa-code',
                'title' => t('services.items.0.title'),
                'description' => t('services.items.0.description'),
                'color' => '#ff6b35'
            ],
            [
                'icon' => 'fas fa-paint-brush',
                'title' => t('services.items.1.title'),
                'description' => t('services.items.1.description'),
                'color' => '#f7931e'
            ],
            [
                'icon' => 'fas fa-server',
                'title' => t('services.items.2.title'),
                'description' => t('services.items.2.description'),
                'color' => '#00d4aa'
            ],
            [
                'icon' => 'fas fa-puzzle-piece',
                'title' => t('services.items.3.title'),
                'description' => t('services.items.3.description'),
                'color' => '#c44569'
            ],
            [
                'icon' => 'fas fa-cogs',
                'title' => t('services.items.4.title'),
                'description' => t('services.items.4.description'),
                'color' => '#6c5ce7'
            ],
            [
                'icon' => 'fas fa-rocket',
                'title' => t('services.items.5.title'),
                'description' => t('services.items.5.description'),
                'color' => '#fd79a8'
            ]
        ]
    ],
    'featured_project' => [
        'title' => t('featured.title'),
        'subtitle' => t('featured.subtitle'),
        'project_id' => '' // Ще се зареди от базата данни по-долу
    ]
];

// Проектите вече се управляват чрез админ панела и се зареждат от базата данни
// Този масив е запазен само като backup/fallback
$projects = [];

// Категории на проектите - вече се управляват от базата данни
$project_categories = [
    'all' => t('projects_page.all_categories')
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