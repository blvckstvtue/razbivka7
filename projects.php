<?php
require_once 'config.php';

// Get filter category
$filter_category = isset($_GET['category']) ? $_GET['category'] : 'all';

// Load projects from database with category filter
$filtered_projects = getProjectsFromDatabase($filter_category);
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Проекти - <?= $site_config['company_name'] ?></title>
    <meta name="description" content="Разгледайте нашите завършени проекти в програмиране, дизайн, сървъри и скриптове.">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;800;900&family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    
    <!-- CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/projects.css" rel="stylesheet">
</head>
<body>
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
                    <li><a href="index.php" class="nav-link">Начало</a></li>
                    <li><a href="index.php#about" class="nav-link">За нас</a></li>
                    <li><a href="index.php#services" class="nav-link">Услуги</a></li>
                    <li><a href="projects.php" class="nav-link active">Проекти</a></li>
                    <li><a href="index.php#contact" class="nav-link">Контакт</a></li>
                </ul>
            </div>
            
            <div class="nav-toggle" id="nav-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Projects Hero -->
    <section class="projects-hero">
        <div class="hero-bg">
            <div class="hero-particles"></div>
            <div class="hero-grid"></div>
        </div>
        
        <div class="container">
            <div class="projects-hero-content" data-aos="fade-up">
                <h1 class="projects-title">
                    <span class="title-accent">НАШИТЕ</span>
                    <span class="glitch-text">ПРОЕКТИ</span>
                </h1>
                <p class="projects-subtitle">
                    Разгледайте колекцията ни от иновативни проекти и решения
                </p>
                
                <div class="projects-stats">
                    <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
                        <div class="stat-number" data-count="<?= count($projects) ?>">0</div>
                        <div class="stat-label">Общо проекти</div>
                    </div>
                    <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
                        <div class="stat-number" data-count="<?= count(array_filter($projects, function($p) { return $p['status'] === 'completed'; })) ?>">0</div>
                        <div class="stat-label">Завършени</div>
                    </div>
                    <div class="stat-item" data-aos="fade-up" data-aos-delay="400">
                        <div class="stat-number" data-count="<?= count(array_unique(array_column($projects, 'category'))) ?>">0</div>
                        <div class="stat-label">Категории</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Filter -->
    <section class="projects-filter">
        <div class="container">
            <div class="filter-container" data-aos="fade-up">
                <h3 class="filter-title">Филтрирай по категория</h3>
                <div class="filter-buttons">
                    <?php foreach($project_categories as $key => $name): ?>
                    <a href="projects.php<?= $key !== 'all' ? '?category=' . urlencode($key) : '' ?>" 
                       class="filter-btn <?= $filter_category === $key ? 'active' : '' ?>">
                        <?= $name ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Grid -->
    <section class="projects-section">
        <div class="container">
            <div class="projects-grid">
                <?php foreach($filtered_projects as $index => $project): ?>
                <div class="project-card" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                    <div class="project-image">
                        <img src="<?= $project['image'] ?>" alt="<?= $project['title'] ?>" loading="lazy" onerror="this.src='assets/images/placeholder-project.jpg'">
                        <div class="project-overlay">
                            <div class="project-actions">
                                <button class="action-btn" onclick="openProjectModal('<?= $project['id'] ?>')">
                                    <i class="fas fa-eye"></i>
                                    <span>Детайли</span>
                                </button>
                                <?php if($project['url'] !== '#'): ?>
                                <a href="<?= $project['url'] ?>" target="_blank" class="action-btn">
                                    <i class="fas fa-external-link-alt"></i>
                                    <span>Виж проекта</span>
                                </a>
                                <?php endif; ?>
                                <?php if($project['github'] !== '#'): ?>
                                <a href="<?= $project['github'] ?>" target="_blank" class="action-btn">
                                    <i class="fab fa-github"></i>
                                    <span>GitHub</span>
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="project-status status-<?= $project['status'] ?>">
                            <?= $project['status'] === 'completed' ? 'Завършен' : 'В процес' ?>
                        </div>
                    </div>
                    
                    <div class="project-content">
                        <div class="project-category"><?= $project_categories[$project['category']] ?? $project['category'] ?></div>
                        <h3 class="project-title"><?= $project['title'] ?></h3>
                        <p class="project-description"><?= $project['description'] ?></p>
                        
                        <div class="project-tech">
                            <?php foreach(array_slice($project['technologies'], 0, 3) as $tech): ?>
                            <span class="tech-tag"><?= $tech ?></span>
                            <?php endforeach; ?>
                            <?php if(count($project['technologies']) > 3): ?>
                            <span class="tech-more">+<?= count($project['technologies']) - 3 ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="project-meta">
                            <div class="project-date">
                                <i class="fas fa-calendar"></i>
                                <?= date('M Y', strtotime($project['date'])) ?>
                            </div>
                            <div class="project-client">
                                <i class="fas fa-user"></i>
                                <?= $project['client'] ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <?php if(empty($filtered_projects)): ?>
            <div class="no-projects" data-aos="fade-up">
                <div class="no-projects-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3>Няма намерени проекти</h3>
                <p>Не са намерени проекти в тази категория.</p>
                <a href="projects.php" class="btn btn-primary">Виж всички проекти</a>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Project Modals -->
    <?php foreach($projects as $project): ?>
    <div id="modal-<?= $project['id'] ?>" class="project-modal">
        <div class="modal-overlay" onclick="closeProjectModal('<?= $project['id'] ?>')"></div>
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title"><?= $project['title'] ?></h2>
                <button class="modal-close" onclick="closeProjectModal('<?= $project['id'] ?>')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="modal-body">
                <div class="modal-image-gallery">
                    <?php 
                    $gallery = $project['gallery'];
                    $allImages = [];
                    
                    // Add main image first if it exists
                    if (!empty($project['image'])) {
                        $allImages[] = $project['image'];
                    }
                    
                    // Add gallery images
                    if (!empty($gallery)) {
                        $allImages = array_merge($allImages, $gallery);
                    }
                    
                    // Remove duplicates
                    $allImages = array_unique($allImages);
                    ?>
                    
                    <?php if (!empty($allImages)): ?>
                        <div class="main-image">
                            <img id="mainImage_<?= $project['id'] ?>" 
                                 src="<?= $allImages[0] ?>" 
                                 alt="<?= $project['title'] ?>" 
                                 onerror="this.src='assets/images/placeholder-project.jpg'">
                            
                            <?php if (count($allImages) > 1): ?>
                                <div class="image-nav">
                                    <button class="nav-btn prev-btn" onclick="changeImage('<?= $project['id'] ?>', -1)">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button class="nav-btn next-btn" onclick="changeImage('<?= $project['id'] ?>', 1)">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                                <div class="image-counter">
                                    <span id="imageCounter_<?= $project['id'] ?>">1</span> / <?= count($allImages) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <?php if (count($allImages) > 1): ?>
                            <div class="image-thumbnails">
                                <?php foreach ($allImages as $index => $image): ?>
                                    <div class="thumbnail <?= $index === 0 ? 'active' : '' ?>" 
                                         onclick="setMainImage('<?= $project['id'] ?>', <?= $index ?>)">
                                        <img src="<?= $image ?>" alt="Thumbnail <?= $index + 1 ?>" 
                                             onerror="this.src='assets/images/placeholder-project.jpg'">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <script>
                            window.projectImages = window.projectImages || {};
                            window.projectImages['<?= $project['id'] ?>'] = <?= json_encode($allImages) ?>;
                        </script>
                    <?php else: ?>
                        <div class="main-image">
                            <img src="assets/images/placeholder-project.jpg" alt="<?= $project['title'] ?>">
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="modal-info">
                    <div class="project-details">
                        <div class="detail-item">
                            <strong>Категория:</strong>
                            <span><?= $project_categories[$project['category']] ?? $project['category'] ?></span>
                        </div>
                        <div class="detail-item">
                            <strong>Статус:</strong>
                            <span class="status-<?= $project['status'] ?>">
                                <?= $project['status'] === 'completed' ? 'Завършен' : 'В процес' ?>
                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Дата:</strong>
                            <span><?= date('F Y', strtotime($project['date'])) ?></span>
                        </div>
                        <div class="detail-item">
                            <strong>Клиент:</strong>
                            <span><?= $project['client'] ?></span>
                        </div>
                    </div>
                    
                    <div class="project-description-full">
                        <h4>Описание</h4>
                        <p><?= $project['long_description'] ?></p>
                    </div>
                    
                    <div class="project-features">
                        <h4>Функционалности</h4>
                        <ul>
                            <?php foreach($project['features'] as $feature): ?>
                            <li><i class="fas fa-check"></i> <?= $feature ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
                    <div class="project-technologies">
                        <h4>Технологии</h4>
                        <div class="tech-tags">
                            <?php foreach($project['technologies'] as $tech): ?>
                            <span class="tech-tag"><?= $tech ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="project-actions">
                        <?php if(!empty($project['url']) && $project['url'] !== '#'): ?>
                        <a href="<?= $project['url'] ?>" target="_blank" class="btn btn-primary">
                            <i class="fas fa-external-link-alt"></i>
                            Виж проекта
                        </a>
                        <?php endif; ?>
                        <?php if(!empty($project['github']) && $project['github'] !== '#'): ?>
                        <a href="<?= $project['github'] ?>" target="_blank" class="btn btn-outline">
                            <i class="fab fa-github"></i>
                            GitHub
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-bg">
            <div class="cta-particles"></div>
        </div>
        
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2 class="cta-title">Харесва ви това което виждате?</h2>
                <p class="cta-description">
                    Нека работим заедно върху вашия следващ проект
                </p>
                <div class="cta-buttons">
                    <a href="index.php#contact" class="btn btn-primary btn-glow">
                        <span>Свържи се с нас</span>
                        <i class="fas fa-envelope"></i>
                    </a>
                    <a href="index.php" class="btn btn-outline">
                        <span>Обратно към началото</span>
                        <i class="fas fa-home"></i>
                    </a>
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
                        <h4>Услуги</h4>
                        <ul>
                            <li><a href="index.php#services">Програмиране</a></li>
                            <li><a href="index.php#services">Дизайн</a></li>
                            <li><a href="index.php#services">Game сървъри</a></li>
                            <li><a href="index.php#services">Скриптове</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-column">
                        <h4>Компания</h4>
                        <ul>
                            <li><a href="index.php#about">За нас</a></li>
                            <li><a href="projects.php">Проекти</a></li>
                            <li><a href="index.php#contact">Контакт</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-column">
                        <h4>Следвай ни</h4>
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
                <p>&copy; <?= date('Y') ?> <?= $site_config['company_name'] ?>. Всички права запазени.</p>
            </div>
        </div>
    </footer>

    <!-- Image Gallery Styles -->
    <style>
        .modal-image-gallery {
            position: relative;
            margin-bottom: 2rem;
        }

        .main-image {
            position: relative;
            width: 100%;
            max-height: 400px;
            overflow: hidden;
            border-radius: 10px;
            background: #000;
        }

        .main-image img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .image-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 1rem;
            pointer-events: none;
        }

        .nav-btn {
            background: rgba(0, 0, 0, 0.7);
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            pointer-events: all;
            opacity: 0;
        }

        .main-image:hover .nav-btn {
            opacity: 1;
        }

        .nav-btn:hover {
            background: rgba(255, 107, 53, 0.9);
            transform: scale(1.1);
        }

        .image-counter {
            position: absolute;
            bottom: 1rem;
            right: 1rem;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
        }

        .image-thumbnails {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
            overflow-x: auto;
            padding: 0.5rem 0;
        }

        .thumbnail {
            flex-shrink: 0;
            width: 80px;
            height: 60px;
            border-radius: 5px;
            overflow: hidden;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .thumbnail:hover {
            border-color: #ff6b35;
            transform: translateY(-2px);
        }

        .thumbnail.active {
            border-color: #ff6b35;
            box-shadow: 0 0 10px rgba(255, 107, 53, 0.5);
        }

        .thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        @media (max-width: 768px) {
            .main-image {
                max-height: 250px;
            }

            .main-image img {
                height: 250px;
            }

            .nav-btn {
                width: 40px;
                height: 40px;
                opacity: 1;
            }

            .thumbnail {
                width: 60px;
                height: 45px;
            }
        }
    </style>

    <!-- Image Gallery JavaScript -->
    <script>
        window.currentImageIndex = window.currentImageIndex || {};

        function initializeImageGallery(projectId) {
            window.currentImageIndex[projectId] = 0;
        }

        function changeImage(projectId, direction) {
            const images = window.projectImages[projectId];
            if (!images || images.length <= 1) return;

            let currentIndex = window.currentImageIndex[projectId] || 0;
            currentIndex += direction;

            if (currentIndex >= images.length) {
                currentIndex = 0;
            } else if (currentIndex < 0) {
                currentIndex = images.length - 1;
            }

            setMainImage(projectId, currentIndex);
        }

        function setMainImage(projectId, index) {
            const images = window.projectImages[projectId];
            if (!images || index >= images.length) return;

            window.currentImageIndex[projectId] = index;

            // Update main image
            const mainImg = document.getElementById('mainImage_' + projectId);
            if (mainImg) {
                mainImg.src = images[index];
            }

            // Update counter
            const counter = document.getElementById('imageCounter_' + projectId);
            if (counter) {
                counter.textContent = index + 1;
            }

            // Update thumbnails
            const thumbnails = document.querySelectorAll('#project-modal-' + projectId + ' .thumbnail');
            thumbnails.forEach((thumb, i) => {
                thumb.classList.toggle('active', i === index);
            });
        }

        // Initialize galleries when modals are opened
        function openProjectModal(projectId) {
            const modal = document.getElementById('project-modal-' + projectId);
            if (modal) {
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
                initializeImageGallery(projectId);
            }
        }

        function closeProjectModal(projectId) {
            const modal = document.getElementById('project-modal-' + projectId);
            if (modal) {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            const openModal = document.querySelector('.project-modal[style*="flex"]');
            if (openModal) {
                const projectId = openModal.id.replace('project-modal-', '');
                
                if (e.key === 'ArrowLeft') {
                    changeImage(projectId, -1);
                } else if (e.key === 'ArrowRight') {
                    changeImage(projectId, 1);
                } else if (e.key === 'Escape') {
                    closeProjectModal(projectId);
                }
            }
        });
    </script>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/projects.js"></script>
</body>
</html>