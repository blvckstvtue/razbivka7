<?php
session_start();
require_once '../database/config.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$projectManager = new ProjectManager();
$settingsManager = new SettingsManager();
$projects = $projectManager->getAllProjects();

$success = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Update featured project
        if (isset($_POST['featured_project_id'])) {
            $settingsManager->setSetting('featured_project_id', $_POST['featured_project_id']);
        }
        
        $success = true;
        
    } catch (Exception $e) {
        $errors[] = 'Грешка при запазване на настройките: ' . $e->getMessage();
    }
}

// Load current settings
$current_featured = $settingsManager->getSetting('featured_project_id');
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Настройки - Админ панел</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700&family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Rajdhani', sans-serif;
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
            color: #ffffff;
            min-height: 100vh;
        }

        .admin-header {
            background: rgba(26, 26, 26, 0.95);
            padding: 1rem 2rem;
            border-bottom: 2px solid #ff6b35;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-logo {
            font-family: 'Orbitron', monospace;
            font-size: 1.5rem;
            font-weight: 700;
            color: #ff6b35;
        }

        .admin-nav {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .admin-nav a {
            color: #ffffff;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .admin-nav a:hover, .admin-nav a.active {
            background: #ff6b35;
            color: #000;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }

        .page-title {
            font-size: 2.5rem;
            margin-bottom: 2rem;
            text-align: center;
            color: #ff6b35;
            font-family: 'Orbitron', monospace;
        }

        .settings-container {
            background: rgba(26, 26, 26, 0.8);
            padding: 2rem;
            border-radius: 10px;
            border: 1px solid #333;
        }

        .setting-group {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid #333;
        }

        .setting-group:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .setting-title {
            font-size: 1.5rem;
            color: #ff6b35;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .setting-description {
            color: #cccccc;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #cccccc;
            font-weight: 500;
            font-size: 1.1rem;
        }

        .form-select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #333;
            border-radius: 5px;
            background: rgba(0, 0, 0, 0.3);
            color: #ffffff;
            font-size: 1rem;
            font-family: 'Rajdhani', sans-serif;
            transition: all 0.3s ease;
        }

        .form-select:focus {
            outline: none;
            border-color: #ff6b35;
            background: rgba(0, 0, 0, 0.5);
            box-shadow: 0 0 0 2px rgba(255, 107, 53, 0.2);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: 'Rajdhani', sans-serif;
            font-weight: 500;
        }

        .btn-primary {
            background: #ff6b35;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #e55a2b;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #333;
            color: #ffffff;
        }

        .btn-secondary:hover {
            background: #444;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #333;
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 5px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .alert-success {
            border-left: 4px solid #00d4aa;
            background: rgba(0, 212, 170, 0.1);
            color: #00d4aa;
        }

        .alert-error {
            border-left: 4px solid #ff4757;
            background: rgba(255, 71, 87, 0.1);
            color: #ff4757;
        }

        .project-preview {
            background: rgba(0, 0, 0, 0.2);
            padding: 1rem;
            border-radius: 5px;
            border-left: 3px solid #ff6b35;
            margin-top: 1rem;
        }

        .project-preview h4 {
            color: #ff6b35;
            margin-bottom: 0.5rem;
        }

        .project-preview p {
            color: #cccccc;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .form-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="admin-logo">
            <i class="fas fa-cog"></i> LIONDEVS ADMIN
        </div>
        <nav class="admin-nav">
            <a href="index.php"><i class="fas fa-home"></i> Начало</a>
            <a href="add_project.php"><i class="fas fa-plus"></i> Добави проект</a>
            <a href="settings.php" class="active"><i class="fas fa-cog"></i> Настройки</a>
            <a href="../index.php" target="_blank"><i class="fas fa-external-link-alt"></i> Виж сайта</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Изход</a>
        </nav>
    </header>

    <div class="container">
        <h1 class="page-title">Настройки на сайта</h1>

        <?php if ($success): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                Настройките са запазени успешно!
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <div>
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Грешки:</strong>
                    <ul style="margin: 0.5rem 0 0 1.5rem;">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <div class="settings-container">
            <form method="post">
                <div class="setting-group">
                    <h3 class="setting-title">
                        <i class="fas fa-star"></i> Featured Project
                    </h3>
                    <p class="setting-description">
                        Изберете кой проект да се показва като "Featured Project" на началната страница.
                    </p>

                    <div class="form-group">
                        <label for="featured_project_id" class="form-label">Featured Project</label>
                        <select id="featured_project_id" name="featured_project_id" class="form-select">
                            <option value="">-- Няма избран featured project --</option>
                            <?php foreach ($projects as $project): ?>
                                <option value="<?= htmlspecialchars($project['project_id']) ?>"
                                        <?= $current_featured === $project['project_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($project['title']) ?> (<?= htmlspecialchars($project['category']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <?php if ($current_featured): ?>
                        <?php 
                        $featured_project = null;
                        foreach ($projects as $project) {
                            if ($project['project_id'] === $current_featured) {
                                $featured_project = $project;
                                break;
                            }
                        }
                        ?>
                        <?php if ($featured_project): ?>
                            <div class="project-preview">
                                <h4>Текущ Featured Project:</h4>
                                <p><strong><?= htmlspecialchars($featured_project['title']) ?></strong></p>
                                <p><?= htmlspecialchars($featured_project['description']) ?></p>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Запази настройките
                    </button>
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Обратно
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Auto-update project preview when selection changes
        document.getElementById('featured_project_id').addEventListener('change', function() {
            // You can add AJAX here to preview the project without page reload
        });
    </script>
</body>
</html>