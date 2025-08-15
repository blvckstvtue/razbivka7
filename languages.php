<?php
// languages.php - Система за многоезичност

// Session start for language preference
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Determine current language
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

$current_lang = $_SESSION['lang'] ?? 'en';

// Language definitions
$languages = [
    'en' => [
        'name' => 'English',
        'flag' => '🇺🇸',
        'code' => 'en'
    ],
    'bg' => [
        'name' => 'Български',
        'flag' => '🇧🇬', 
        'code' => 'bg'
    ]
];

// Translations
$translations = [
    'en' => [
        // Site config
        'site' => [
            'company_name' => 'LionDevs',
            'full_name' => 'Lion Developments',
            'tagline' => 'Unleashing Digital Excellence',
            'description' => 'We are a company that specializes in programming, design, game servers, scripts and all kinds of projects according to client requirements.',
        ],
        
        // Navigation
        'nav' => [
            'home' => 'Home',
            'about' => 'About',
            'services' => 'Services',
            'projects' => 'Projects',
            'contact' => 'Contact'
        ],
        
        // Hero section
        'hero' => [
            'subtitle' => 'UNLEASHING DIGITAL EXCELLENCE',
            'description' => 'We create unique programs, designs, servers and scripts. Every project is made with perfection and attention to detail.',
            'cta_primary' => 'View Projects',
            'cta_secondary' => 'Contact Us'
        ],
        
        // About section
        'about' => [
            'title' => 'WHO WE ARE',
            'subtitle' => 'Professionals in programming',
            'description' => 'LionDevs is a company that specializes in creating innovative solutions. From programs to designs, from game servers to complex scripts - we do everything with the highest quality.',
            'stats' => [
                'projects' => 'Completed projects',
                'clients' => 'Happy clients',
                'experience' => 'Years of experience',
                'quality' => 'Quality'
            ],
            'features' => [
                'innovative' => 'Innovative Solutions',
                'quality' => 'High Quality',
                'delivery' => 'On-time Delivery',
                'support' => '24/7 Support'
            ]
        ],
        
        // Services section
        'services' => [
            'title' => 'OUR SERVICES',
            'subtitle' => 'Everything you need in one place',
            'items' => [
                [
                    'title' => 'Programming',
                    'description' => 'We create unique programs and applications with the latest technologies'
                ],
                [
                    'title' => 'Design',
                    'description' => 'Designs of all kinds - logos, web design, graphic design'
                ],
                [
                    'title' => 'Game Servers',
                    'description' => 'Setup and maintenance of servers for various games'
                ],
                [
                    'title' => 'Scripts & Plugins',
                    'description' => 'Unique scripts and plugins for games and applications'
                ],
                [
                    'title' => 'Custom Projects',
                    'description' => 'Specialized solutions according to your needs'
                ],
                [
                    'title' => 'Consultations',
                    'description' => 'Professional advice and technical support'
                ]
            ]
        ],
        
        // Featured project
        'featured' => [
            'title' => 'FEATURED PROJECT',
            'subtitle' => 'Check out our latest project'
        ],
        
        // CTA section
        'cta' => [
            'title' => 'Ready for the next project?',
            'subtitle' => 'Contact us today and let\'s create something amazing together',
            'view_projects' => 'View Our Projects',
            'contact_us' => 'Contact Us'
        ],
        
        // Projects page
        'projects_page' => [
            'all_categories' => 'All',
            'title' => 'OUR PROJECTS',
            'subtitle' => 'Check out our collection of innovative projects and solutions',
            'total_projects' => 'Total Projects',
            'completed' => 'Completed',
            'categories' => 'Categories',
            'filter_title' => 'Filter by category',
            'view_project' => 'View Project',
            'no_projects' => 'No projects found in this category.',
            'back_home' => 'Back to Home'
        ],
        
        // Contact
        'contact' => [
            'title' => 'CONTACT US',
            'subtitle' => 'Let\'s discuss your project',
            'name' => 'Name',
            'email' => 'Email',
            'subject' => 'Subject',
            'message' => 'Message',
            'send' => 'Send Message',
            'phone_label' => 'Phone',
            'address_label' => 'Address'
        ],
        
        // Footer
        'footer' => [
            'services_title' => 'Services',
            'programming' => 'Programming',
            'design' => 'Design',
            'game_servers' => 'Game Servers',
            'scripts' => 'Scripts',
            'company_title' => 'Company',
            'about_us' => 'About Us',
            'projects' => 'Projects',
            'contact' => 'Contact',
            'follow_us' => 'Follow Us',
            'rights_reserved' => 'All rights reserved.'
        ]
    ],
    
    'bg' => [
        // Site config
        'site' => [
            'company_name' => 'LionDevs',
            'full_name' => 'Lion Developments',
            'tagline' => 'Unleashing Digital Excellence',
            'description' => 'Ние сме компания която се занимава с програмиране, дизайн, сървъри на игри, скриптове и всякакви проекти по изискване на клиенти.',
        ],
        
        // Navigation
        'nav' => [
            'home' => 'Начало',
            'about' => 'За нас',
            'services' => 'Услуги',
            'projects' => 'Проекти',
            'contact' => 'Контакт'
        ],
        
        // Hero section
        'hero' => [
            'subtitle' => 'UNLEASHING DIGITAL EXCELLENCE',
            'description' => 'Ние създаваме уникални програми, дизайни, сървъри и скриптове. Всеки проект е направен с перфекция и внимание към детайлите.',
            'cta_primary' => 'Виж Проектите',
            'cta_secondary' => 'Свържи се с нас'
        ],
        
        // About section
        'about' => [
            'title' => 'КОИ СМЕ НИЕ',
            'subtitle' => 'Професионалисти в програмирането',
            'description' => 'LionDevs е компания която се специализира в създаване на иновативни решения. От програми до дизайни, от сървъри на игри до сложни скриптове - ние правим всичко с най-високо качество.',
            'stats' => [
                'projects' => 'Завършени проекти',
                'clients' => 'Доволни клиенти',
                'experience' => 'Години опит',
                'quality' => 'Качество'
            ],
            'features' => [
                'innovative' => 'Иновативни решения',
                'quality' => 'Високо качество',
                'delivery' => 'Навременна доставка',
                'support' => '24/7 Поддръжка'
            ]
        ],
        
        // Services section
        'services' => [
            'title' => 'НАШИТЕ УСЛУГИ',
            'subtitle' => 'Всичко което ви трябва на едно място',
            'items' => [
                [
                    'title' => 'Програмиране',
                    'description' => 'Създаваме уникални програми и приложения с най-новите технологии'
                ],
                [
                    'title' => 'Дизайн',
                    'description' => 'Дизайни на всякакви неща - логота, уеб дизайн, графичен дизайн'
                ],
                [
                    'title' => 'Game Сървъри',
                    'description' => 'Настройка и поддръжка на сървъри за различни игри'
                ],
                [
                    'title' => 'Скриптове & Плугини',
                    'description' => 'Уникални скриптове и плугини за игри и приложения'
                ],
                [
                    'title' => 'Проекти по поръчка',
                    'description' => 'Специализирани решения според вашите нужди'
                ],
                [
                    'title' => 'Консултации',
                    'description' => 'Професионални съвети и техническа поддръжка'
                ]
            ]
        ],
        
        // Featured project
        'featured' => [
            'title' => 'FEATURED PROJECT',
            'subtitle' => 'Разгледайте нашия най-нов проект'
        ],
        
        // CTA section
        'cta' => [
            'title' => 'Готови за следващия проект?',
            'subtitle' => 'Свържете се с нас днес и нека създадем нещо невероятно заедно',
            'view_projects' => 'Виж нашите проекти',
            'contact_us' => 'Свържи се с нас'
        ],
        
        // Projects page
        'projects_page' => [
            'all_categories' => 'Всички',
            'title' => 'НАШИТЕ ПРОЕКТИ',
            'subtitle' => 'Разгледайте колекцията ни от иновативни проекти и решения',
            'total_projects' => 'Общо проекти',
            'completed' => 'Завършени',
            'categories' => 'Категории',
            'filter_title' => 'Филтрирай по категория',
            'view_project' => 'Виж проект',
            'no_projects' => 'Няма намерени проекти в тази категория.',
            'back_home' => 'Назад към началото'
        ],
        
        // Contact
        'contact' => [
            'title' => 'КОНТАКТ',
            'subtitle' => 'Свържете се с нас за вашия следващ проект',
            'name' => 'Име',
            'email' => 'Email',
            'subject' => 'Тема',
            'message' => 'Съобщение',
            'send' => 'Изпрати съобщение',
            'phone_label' => 'Телефон',
            'address_label' => 'Адрес'
        ],
        
        // Footer
        'footer' => [
            'services_title' => 'Услуги',
            'programming' => 'Програмиране',
            'design' => 'Дизайн',
            'game_servers' => 'Game сървъри',
            'scripts' => 'Скриптове',
            'company_title' => 'Компания',
            'about_us' => 'За нас',
            'projects' => 'Проекти',
            'contact' => 'Контакт',
            'follow_us' => 'Следвай ни',
            'rights_reserved' => 'Всички права запазени.'
        ]
    ]
];

// Helper function to get translation
function t($key, $lang = null) {
    global $translations, $current_lang;
    
    if ($lang === null) {
        $lang = $current_lang;
    }
    
    $keys = explode('.', $key);
    $value = $translations[$lang] ?? $translations['en'];
    
    foreach ($keys as $k) {
        if (isset($value[$k])) {
            $value = $value[$k];
        } else {
            // Fallback to English if key not found
            $fallback = $translations['en'];
            foreach ($keys as $fk) {
                if (isset($fallback[$fk])) {
                    $fallback = $fallback[$fk];
                } else {
                    return $key; // Return key if not found anywhere
                }
            }
            return $fallback;
        }
    }
    
    return $value;
}

// Helper function to get current language
function getCurrentLang() {
    global $current_lang;
    return $current_lang;
}

// Helper function to get all languages
function getLanguages() {
    global $languages;
    return $languages;
}

?>