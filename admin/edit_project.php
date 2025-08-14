<?php
session_start();
require_once '../database/config.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$projectManager = new ProjectManager();
$categories = $projectManager->getCategories();
$technologies = $projectManager->getTechnologies();

$errors = [];
$success = false;
$project = null;

// Get project ID
$project_id = $_GET['id'] ?? null;
if (!$project_id) {
    header('Location: index.php');
    exit;
}

// Load project data
$project = $projectManager->getProjectById($project_id);
if (!$project) {
    header('Location: index.php?error=not_found');
    exit;
}

// Decode JSON fields
$project['technologies'] = json_decode($project['technologies'], true) ?: [];
$project['features'] = json_decode($project['features'], true) ?: [];
$project['gallery'] = json_decode($project['gallery'], true) ?: [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and process form data
    $project_id_field = trim($_POST['project_id'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $long_description = trim($_POST['long_description'] ?? '');
    $image = trim($_POST['image'] ?? '');
    $status = $_POST['status'] ?? 'planned';
    $date = $_POST['date'] ?? date('Y-m-d');
    $client = trim($_POST['client'] ?? '');
    $url = trim($_POST['url'] ?? '');
    $github = trim($_POST['github'] ?? '');
    
    // Process technologies and features
    $selected_technologies = $_POST['technologies'] ?? [];
    $features = array_filter(array_map('trim', explode("\n", $_POST['features'] ?? '')));
    $gallery = array_filter(array_map('trim', explode("\n", $_POST['gallery'] ?? '')));
    
    // Validation
    if (empty($project_id_field)) $errors[] = 'Project ID е задължително поле';
    if (empty($title)) $errors[] = 'Заглавието е задължително поле';
    if (empty($category)) $errors[] = 'Категорията е задължително поле';
    if (empty($description)) $errors[] = 'Описанието е задължително поле';
    
    // Check if project_id already exists (but not for current project)
    if (!empty($project_id_field) && $project_id_field !== $project['project_id']) {
        $existing = $projectManager->getProjectByProjectId($project_id_field);
        if ($existing) {
            $errors[] = 'Project ID вече съществува';
        }
    }
    
    if (empty($errors)) {
        try {
            $projectData = [
                'project_id' => $project_id_field,
                'title' => $title,
                'category' => $category,
                'description' => $description,
                'long_description' => $long_description,
                'image' => $image,
                'technologies' => $selected_technologies,
                'features' => $features,
                'gallery' => $gallery,
                'status' => $status,
                'date' => $date,
                'client' => $client,
                'url' => $url,
                'github' => $github
            ];
            
            $projectManager->updateProject($project['id'], $projectData);
            
            // Redirect to admin panel with success message
            header('Location: index.php?msg=updated');
            exit;
            
        } catch (Exception $e) {
            $errors[] = 'Грешка при обновяване на проекта: ' . $e->getMessage();
        }
    }
} else {
    // Pre-fill form with current project data
    $_POST = [
        'project_id' => $project['project_id'],
        'title' => $project['title'],
        'category' => $project['category'],
        'description' => $project['description'],
        'long_description' => $project['long_description'],
        'image' => $project['image'],
        'status' => $project['status'],
        'date' => $project['date'],
        'client' => $project['client'],
        'url' => $project['url'],
        'github' => $project['github'],
        'technologies' => $project['technologies'],
        'features' => implode("\n", $project['features']),
        'gallery' => implode("\n", $project['gallery'])
    ];
}
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирай проект - Админ панел</title>
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

        .admin-nav a:hover {
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

        .form-container {
            background: rgba(26, 26, 26, 0.8);
            padding: 2rem;
            border-radius: 10px;
            border: 1px solid #333;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #cccccc;
            font-weight: 500;
            font-size: 1.1rem;
        }

        .form-input,
        .form-select,
        .form-textarea {
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

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #ff6b35;
            background: rgba(0, 0, 0, 0.5);
            box-shadow: 0 0 0 2px rgba(255, 107, 53, 0.2);
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-textarea.large {
            min-height: 150px;
        }

        .technologies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .tech-checkbox {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .tech-checkbox:hover {
            background: rgba(255, 107, 53, 0.1);
        }

        .tech-checkbox input[type="checkbox"] {
            accent-color: #ff6b35;
        }

        .tech-checkbox label {
            cursor: pointer;
            font-size: 0.9rem;
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

        .error-message {
            background: rgba(255, 71, 87, 0.1);
            color: #ff4757;
            padding: 1rem;
            border-radius: 5px;
            border-left: 4px solid #ff4757;
            margin-bottom: 1.5rem;
        }

        .error-list {
            list-style: none;
            margin: 0;
        }

        .error-list li {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .help-text {
            font-size: 0.9rem;
            color: #999;
            margin-top: 0.25rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
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
            <a href="settings.php"><i class="fas fa-cog"></i> Настройки</a>
            <a href="../index.php" target="_blank"><i class="fas fa-external-link-alt"></i> Виж сайта</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Изход</a>
        </nav>
    </header>

    <div class="container">
        <h1 class="page-title">Редактирай проект</h1>

        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <ul class="error-list">
                    <?php foreach ($errors as $error): ?>
                        <li><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <form method="post">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="project_id" class="form-label">Project ID *</label>
                        <input type="text" 
                               id="project_id" 
                               name="project_id" 
                               class="form-input"
                               placeholder="unique-project-id"
                               value="<?= htmlspecialchars($_POST['project_id'] ?? '') ?>"
                               required>
                        <div class="help-text">Уникален идентификатор (само букви, цифри и тирета)</div>
                    </div>

                    <div class="form-group">
                        <label for="title" class="form-label">Заглавие *</label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               class="form-input"
                               placeholder="Име на проекта"
                               value="<?= htmlspecialchars($_POST['title'] ?? '') ?>"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="category" class="form-label">Категория *</label>
                        <select id="category" name="category" class="form-select" required>
                            <option value="">Изберете категория</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= htmlspecialchars($cat['category_key']) ?>"
                                        <?= ($_POST['category'] ?? '') === $cat['category_key'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['category_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status" class="form-label">Статус</label>
                        <select id="status" name="status" class="form-select">
                            <option value="planned" <?= ($_POST['status'] ?? 'planned') === 'planned' ? 'selected' : '' ?>>Планиран</option>
                            <option value="in_progress" <?= ($_POST['status'] ?? '') === 'in_progress' ? 'selected' : '' ?>>В процес</option>
                            <option value="completed" <?= ($_POST['status'] ?? '') === 'completed' ? 'selected' : '' ?>>Завършен</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="date" class="form-label">Дата</label>
                        <input type="date" 
                               id="date" 
                               name="date" 
                               class="form-input"
                               value="<?= htmlspecialchars($_POST['date'] ?? date('Y-m-d')) ?>">
                    </div>

                    <div class="form-group">
                        <label for="client" class="form-label">Клиент</label>
                        <input type="text" 
                               id="client" 
                               name="client" 
                               class="form-input"
                               placeholder="Име на клиента"
                               value="<?= htmlspecialchars($_POST['client'] ?? '') ?>">
                    </div>

                    <div class="form-group full-width">
                        <label for="description" class="form-label">Кратко описание *</label>
                        <textarea id="description" 
                                  name="description" 
                                  class="form-textarea"
                                  placeholder="Кратко описание на проекта..."
                                  required><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                    </div>

                    <div class="form-group full-width">
                        <label for="long_description" class="form-label">Подробно описание</label>
                        <textarea id="long_description" 
                                  name="long_description" 
                                  class="form-textarea large"
                                  placeholder="Подробно описание на проекта..."><?= htmlspecialchars($_POST['long_description'] ?? '') ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="image" class="form-label">Главно изображение</label>
                        <input type="text" 
                               id="image" 
                               name="image" 
                               class="form-input"
                               placeholder="assets/images/projects/project.jpg"
                               value="<?= htmlspecialchars($_POST['image'] ?? '') ?>">
                        <div class="help-text">Път към главното изображение</div>
                    </div>

                    <div class="form-group">
                        <label for="url" class="form-label">URL адрес</label>
                        <input type="url" 
                               id="url" 
                               name="url" 
                               class="form-input"
                               placeholder="https://example.com (незадължително)"
                               value="<?= htmlspecialchars($_POST['url'] ?? '') ?>">
                        <div class="help-text">Линк към живия проект (ако има такъв)</div>
                    </div>

                    <div class="form-group">
                        <label for="github" class="form-label">GitHub линк</label>
                        <input type="url" 
                               id="github" 
                               name="github" 
                               class="form-input"
                               placeholder="https://github.com/user/repo (незадължително)"
                               value="<?= htmlspecialchars($_POST['github'] ?? '') ?>">
                        <div class="help-text">Линк към GitHub repository (ако е публичен)</div>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">Технологии</label>
                        <div class="technologies-grid">
                            <?php foreach ($technologies as $tech): ?>
                                <div class="tech-checkbox">
                                    <input type="checkbox" 
                                           id="tech_<?= $tech['id'] ?>" 
                                           name="technologies[]" 
                                           value="<?= htmlspecialchars($tech['name']) ?>"
                                           <?= in_array($tech['name'], $_POST['technologies'] ?? []) ? 'checked' : '' ?>>
                                    <label for="tech_<?= $tech['id'] ?>"><?= htmlspecialchars($tech['name']) ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label for="features" class="form-label">Функционалности</label>
                        <textarea id="features" 
                                  name="features" 
                                  class="form-textarea"
                                  placeholder="Една функционалност на ред..."><?= htmlspecialchars($_POST['features'] ?? '') ?></textarea>
                        <div class="help-text">Всяка функционалност на нов ред</div>
                    </div>

                    <div class="form-group full-width">
                        <label for="gallery" class="form-label">Галерия (допълнителни снимки)</label>
                        <textarea id="gallery" 
                                  name="gallery" 
                                  class="form-textarea"
                                  placeholder="assets/images/projects/project-1.jpg&#10;assets/images/projects/project-2.jpg&#10;assets/images/projects/project-3.jpg"><?= htmlspecialchars($_POST['gallery'] ?? '') ?></textarea>
                        <div class="help-text">
                            Път към всяко допълнително изображение на нов ред. 
                            Тези снимки ще се показват като галерия в детайлите на проекта, 
                            заедно с главното изображение. Потребителите ще могат да превключват между тях.
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Обнови проект
                    </button>
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Отказ
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>