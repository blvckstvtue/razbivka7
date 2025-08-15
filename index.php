<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="<?= getCurrentLang() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $site_config['company_name'] ?> - <?= $site_config['tagline'] ?></title>
    <meta name="description" content="<?= $site_config['description'] ?>">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;800;900&family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
</head>
<body>
    <!-- Loading Screen -->
    <div id="loading-screen">
        <div class="loading-content">
            <div class="lion-logo">
                <i class="fas fa-code"></i>
            </div>
            <div class="loading-text">LIONDEVS</div>
            <div class="loading-bar">
                <div class="loading-progress"></div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <a href="index.php">
                    <span class="logo-icon"><i class="fas fa-code"></i></span>
                    <span class="logo-text">LIONDEVS</span>
                </a>
            </div>
            
            <div class="nav-menu" id="nav-menu">
                <ul class="nav-list">
                    <li><a href="#home" class="nav-link active"><?= t('nav.home') ?></a></li>
                    <li><a href="#about" class="nav-link"><?= t('nav.about') ?></a></li>
                    <li><a href="#services" class="nav-link"><?= t('nav.services') ?></a></li>
                    <li><a href="projects.php" class="nav-link"><?= t('nav.projects') ?></a></li>
                    <li><a href="#contact" class="nav-link"><?= t('nav.contact') ?></a></li>
                    <li class="language-switcher">
                        <div class="language-dropdown">
                            <button class="language-btn" id="language-btn">
                                <span class="language-flag"><?= getLanguages()[getCurrentLang()]['flag'] ?></span>
                                <span class="language-name"><?= getLanguages()[getCurrentLang()]['name'] ?></span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="language-options" id="language-options">
                                <?php foreach (getLanguages() as $lang_code => $lang_info): ?>
                                    <?php if ($lang_code !== getCurrentLang()): ?>
                                        <a href="?lang=<?= $lang_code ?>" class="language-option">
                                            <span class="language-flag"><?= $lang_info['flag'] ?></span>
                                            <span class="language-name"><?= $lang_info['name'] ?></span>
                                        </a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            
            <div class="nav-toggle" id="nav-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="hero-bg">
            <div class="hero-particles"></div>
            <div class="hero-grid"></div>
        </div>
        
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-text">
                    <div class="hero-subtitle" data-aos="fade-up" data-aos-delay="200">
                        <span class="glitch-text"><?= $homepage_sections['hero']['subtitle'] ?></span>
                    </div>
                    
                    <h1 class="hero-title" data-aos="fade-up" data-aos-delay="400">
                        <span class="title-line">LION</span>
                        <span class="title-line title-accent">DEVS</span>
                    </h1>
                    
                    <p class="hero-description" data-aos="fade-up" data-aos-delay="600">
                        <?= $homepage_sections['hero']['description'] ?>
                    </p>
                    
                    <div class="hero-buttons" data-aos="fade-up" data-aos-delay="800">
                        <a href="<?= $homepage_sections['hero']['cta_primary']['link'] ?>" class="btn btn-primary btn-glow">
                            <span><?= $homepage_sections['hero']['cta_primary']['text'] ?></span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="<?= $homepage_sections['hero']['cta_secondary']['link'] ?>" class="btn btn-outline">
                            <span><?= $homepage_sections['hero']['cta_secondary']['text'] ?></span>
                            <i class="fas fa-envelope"></i>
                        </a>
                    </div>
                </div>
                
                <div class="hero-visual" data-aos="fade-left" data-aos-delay="1000">
                    <div class="code-terminal">
                        <div class="terminal-header">
                            <div class="terminal-buttons">
                                <span class="btn-close"></span>
                                <span class="btn-minimize"></span>
                                <span class="btn-maximize"></span>
                            </div>
                            <div class="terminal-title">liondevs@terminal</div>
                        </div>
                        <div class="terminal-body">
                            <div class="terminal-line">
                                <span class="prompt">$</span> 
                                <span class="command">launch --project "liondevs"</span>
                            </div>
                            <div class="terminal-line">
                                <span class="output">🎨 Loading design modules...</span>
                            </div>
                            <div class="terminal-line">
                                <span class="output">🚀 Initializing creative engine...</span>
                            </div>
                            <div class="terminal-line">
                                <span class="output success">✓ Your ideas are now live.</span>
                            </div>
                            <div class="terminal-line">
                                <span class="prompt">$</span> 
                                <span class="command typing">create --dream --into reality</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="hero-scroll">
            <div class="scroll-indicator">
                <span>Scroll Down</span>
                <div class="scroll-arrow">
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2 class="section-title">
                    <span class="title-number">01</span>
                    <?= $homepage_sections['about']['title'] ?>
                </h2>
                <p class="section-subtitle"><?= $homepage_sections['about']['subtitle'] ?></p>
            </div>
            
            <div class="about-content">
                <div class="about-text" data-aos="fade-right">
                    <p class="about-description">
                        <?= $homepage_sections['about']['description'] ?>
                    </p>
                    
                    <div class="about-features">
                        <div class="feature-item">
                            <i class="fas fa-rocket"></i>
                            <span><?= t('about.features.innovative') ?></span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-shield-alt"></i>
                            <span><?= t('about.features.quality') ?></span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-clock"></i>
                            <span><?= t('about.features.delivery') ?></span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-headset"></i>
                            <span><?= t('about.features.support') ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="about-stats" data-aos="fade-left">
                    <div class="stats-grid">
                        <?php foreach($homepage_sections['about']['stats'] as $stat): ?>
                        <div class="stat-item">
                            <div class="stat-number" data-count="<?= intval($stat['number']) ?>">0</div>
                            <div class="stat-label"><?= $stat['label'] ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2 class="section-title">
                    <span class="title-number">02</span>
                    <?= $homepage_sections['services']['title'] ?>
                </h2>
                <p class="section-subtitle"><?= $homepage_sections['services']['subtitle'] ?></p>
            </div>
            
            <div class="services-grid">
                <?php foreach($homepage_sections['services']['items'] as $index => $service): ?>
                <div class="service-card" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                    <div class="service-icon" style="color: <?= $service['color'] ?>">
                        <i class="<?= $service['icon'] ?>"></i>
                    </div>
                    <h3 class="service-title"><?= $service['title'] ?></h3>
                    <p class="service-description"><?= $service['description'] ?></p>
                    <div class="service-hover" style="background: linear-gradient(135deg, <?= $service['color'] ?>20, <?= $service['color'] ?>05)"></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Featured Project Section -->
    <?php 
    // Get the featured project
    $featured_project = null;
    foreach($projects as $project) {
        if($project['id'] === $homepage_sections['featured_project']['project_id']) {
            $featured_project = $project;
            break;
        }
    }
    ?>
    <?php if($featured_project): ?>
    <section class="featured-project-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2 class="section-title">
                    <span class="title-number">03</span>
                    <?= $homepage_sections['featured_project']['title'] ?>
                </h2>
                <p class="section-subtitle"><?= $homepage_sections['featured_project']['subtitle'] ?></p>
            </div>
            
            <div class="featured-project-content">
                <div class="featured-project-image" data-aos="fade-right">
                    <img src="<?= $featured_project['image'] ?>" alt="<?= $featured_project['title'] ?>">
                    <div class="project-overlay">
                        <div class="project-category"><?= $featured_project['category'] ?></div>
                        <div class="project-status"><?= ucfirst($featured_project['status']) ?></div>
                    </div>
                </div>
                
                <div class="featured-project-info" data-aos="fade-left">
                    <h3 class="project-title"><?= $featured_project['title'] ?></h3>
                    <p class="project-description"><?= $featured_project['long_description'] ?></p>
                    
                    <div class="project-technologies">
                        <h4>Използвани технологии:</h4>
                        <div class="tech-tags">
                            <?php foreach($featured_project['technologies'] as $tech): ?>
                            <span class="tech-tag"><?= $tech ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="project-features">
                        <h4>Ключови функции:</h4>
                        <ul class="features-list">
                            <?php foreach(array_slice($featured_project['features'], 0, 4) as $feature): ?>
                            <li><i class="fas fa-check"></i> <?= $feature ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
                    <div class="project-actions">
                        <a href="projects.php?project=<?= $featured_project['id'] ?>" class="btn btn-primary">
                            <span>Виж повече</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="projects.php" class="btn btn-outline">
                            <span>Всички проекти</span>
                            <i class="fas fa-folder-open"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-bg">
            <div class="cta-particles"></div>
        </div>
        
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2 class="cta-title"><?= t('cta.title') ?></h2>
                <p class="cta-description">
                    <?= t('cta.subtitle') ?>
                </p>
                <div class="cta-buttons">
                    <a href="projects.php" class="btn btn-primary btn-glow">
                        <span><?= t('cta.view_projects') ?></span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="#contact" class="btn btn-outline">
                        <span><?= t('cta.contact_us') ?></span>
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2 class="section-title">
                    <span class="title-number">04</span>
                    <?= t('contact.title') ?>
                </h2>
                <p class="section-subtitle"><?= t('contact.subtitle') ?></p>
            </div>
            
            <div class="contact-content">
                <div class="contact-info" data-aos="fade-right">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Email</h4>
                            <p><?= $site_config['email'] ?></p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-details">
                            <h4><?= t('contact.phone_label') ?></h4>
                            <p><?= $site_config['phone'] ?></p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-details">
                            <h4><?= t('contact.address_label') ?></h4>
                            <p><?= $site_config['address'] ?></p>
                        </div>
                    </div>
                    
                    <div class="social-links">
                        <?php foreach($site_config['social'] as $platform => $url): ?>
                            <?php if($url !== '#'): ?>
                            <a href="<?= $url ?>" target="_blank" class="social-link">
                                <i class="fab fa-<?= $platform ?>"></i>
                            </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="contact-form" data-aos="fade-left">
                    <form id="contact-form">
                        <div class="form-group">
                            <input type="text" id="name" name="name" required>
                            <label for="name"><?= t('contact.name') ?></label>
                        </div>
                        
                        <div class="form-group">
                            <input type="email" id="email" name="email" required>
                            <label for="email"><?= t('contact.email') ?></label>
                        </div>
                        
                        <div class="form-group">
                            <input type="text" id="subject" name="subject" required>
                            <label for="subject"><?= t('contact.subject') ?></label>
                        </div>
                        
                        <div class="form-group">
                            <textarea id="message" name="message" required></textarea>
                            <label for="message"><?= t('contact.message') ?></label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-glow">
                            <span><?= t('contact.send') ?></span>
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <div class="footer-logo">
                        <span class="logo-icon"><i class="fas fa-code"></i></span>
                        <span class="logo-text">LIONDEVS</span>
                    </div>
                    <p class="footer-description">
                        <?= $site_config['tagline'] ?>
                    </p>
                </div>
                
                <div class="footer-links">
                    <div class="footer-column">
                        <h4><?= t('footer.services_title') ?></h4>
                        <ul>
                            <li><a href="#"><?= t('footer.programming') ?></a></li>
                            <li><a href="#"><?= t('footer.design') ?></a></li>
                            <li><a href="#"><?= t('footer.game_servers') ?></a></li>
                            <li><a href="#"><?= t('footer.scripts') ?></a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-column">
                        <h4><?= t('footer.company_title') ?></h4>
                        <ul>
                            <li><a href="#about"><?= t('footer.about_us') ?></a></li>
                            <li><a href="projects.php"><?= t('footer.projects') ?></a></li>
                            <li><a href="#contact"><?= t('footer.contact') ?></a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-column">
                        <h4><?= t('footer.follow_us') ?></h4>
                        <div class="footer-social">
                            <?php foreach($site_config['social'] as $platform => $url): ?>
                                <?php if($url !== '#'): ?>
                                <a href="<?= $url ?>" target="_blank">
                                    <i class="fab fa-<?= $platform ?>"></i>
                                </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> <?= $site_config['company_name'] ?>. <?= t('footer.rights_reserved') ?></p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>