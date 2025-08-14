<?php
session_start();
require_once '../database/config.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$projectManager = new ProjectManager();
$projects = $projectManager->getAllProjects();
$categories = $projectManager->getCategories();
$technologies = $projectManager->getTechnologies();

// Handle project actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'delete':
                if (isset($_POST['project_id'])) {
                    $projectManager->deleteProject($_POST['project_id']);
                    header('Location: index.php?msg=deleted');
                    exit;
                }
                break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ Панел - LionDevs</title>
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
            max-width: 1200px;
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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: rgba(26, 26, 26, 0.8);
            padding: 2rem;
            border-radius: 10px;
            border: 1px solid #333;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-color: #ff6b35;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #ff6b35;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #cccccc;
            font-size: 1.1rem;
        }

        .actions-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
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

        .btn-danger {
            background: #ff4757;
            color: #ffffff;
        }

        .btn-danger:hover {
            background: #ff3742;
        }

        .btn-edit {
            background: #00d4aa;
            color: #ffffff;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        .btn-edit:hover {
            background: #00c49a;
        }

        .projects-table {
            background: rgba(26, 26, 26, 0.8);
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #333;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #333;
        }

        .table th {
            background: rgba(255, 107, 53, 0.1);
            color: #ff6b35;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        .table td {
            color: #cccccc;
        }

        .table tr:hover {
            background: rgba(255, 107, 53, 0.05);
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-completed {
            background: #00d4aa;
            color: #000;
        }

        .status-in_progress {
            background: #f7931e;
            color: #000;
        }

        .status-planned {
            background: #6c5ce7;
            color: #fff;
        }

        .project-image {
            width: 60px;
            height: 40px;
            object-fit: cover;
            border-radius: 5px;
        }

        .tech-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.25rem;
        }

        .tech-tag {
            background: rgba(255, 107, 53, 0.2);
            color: #ff6b35;
            padding: 0.2rem 0.5rem;
            border-radius: 3px;
            font-size: 0.7rem;
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 5px;
            border-left: 4px solid #00d4aa;
            background: rgba(0, 212, 170, 0.1);
            color: #00d4aa;
        }

        .project-actions {
            display: flex;
            gap: 0.5rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .actions-bar {
                flex-direction: column;
                align-items: stretch;
            }
            
            .projects-table {
                overflow-x: auto;
            }
            
            .table {
                min-width: 800px;
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
        <h1 class="page-title">Управление на проекти</h1>

        <?php if (isset($_GET['msg'])): ?>
            <div class="alert">
                <i class="fas fa-check-circle"></i>
                <?php if ($_GET['msg'] === 'deleted'): ?>
                    Проектът е изтрит успешно!
                <?php elseif ($_GET['msg'] === 'added'): ?>
                    Проектът е добавен успешно!
                <?php elseif ($_GET['msg'] === 'updated'): ?>
                    Проектът е обновен успешно!
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?= count($projects) ?></div>
                <div class="stat-label">Общо проекти</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= count(array_filter($projects, function($p) { return $p['status'] === 'completed'; })) ?></div>
                <div class="stat-label">Завършени</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= count(array_filter($projects, function($p) { return $p['status'] === 'in_progress'; })) ?></div>
                <div class="stat-label">В процес</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= count($categories) ?></div>
                <div class="stat-label">Категории</div>
            </div>
        </div>

        <div class="actions-bar">
            <h2>Всички проекти</h2>
            <a href="add_project.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Добави нов проект
            </a>
        </div>

        <div class="projects-table">
            <table class="table">
                <thead>
                    <tr>
                        <th>Изображение</th>
                        <th>Заглавие</th>
                        <th>Категория</th>
                        <th>Статус</th>
                        <th>Дата</th>
                        <th>Технологии</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projects as $project): ?>
                        <tr>
                            <td>
                                <?php if ($project['image']): ?>
                                    <img src="../<?= htmlspecialchars($project['image']) ?>" alt="Project" class="project-image">
                                <?php else: ?>
                                    <div style="width:60px;height:40px;background:#333;border-radius:5px;display:flex;align-items:center;justify-content:center;">
                                        <i class="fas fa-image" style="color:#666;"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?= htmlspecialchars($project['title']) ?></strong><br>
                                <small style="color:#999;"><?= htmlspecialchars($project['project_id']) ?></small>
                            </td>
                            <td><?= htmlspecialchars($project['category']) ?></td>
                            <td>
                                <span class="status-badge status-<?= $project['status'] ?>">
                                    <?= $project['status'] === 'completed' ? 'Завършен' : 
                                        ($project['status'] === 'in_progress' ? 'В процес' : 'Планиран') ?>
                                </span>
                            </td>
                            <td><?= date('d.m.Y', strtotime($project['date'])) ?></td>
                            <td>
                                <div class="tech-tags">
                                    <?php 
                                    $techs = json_decode($project['technologies'], true) ?: [];
                                    foreach (array_slice($techs, 0, 3) as $tech): 
                                    ?>
                                        <span class="tech-tag"><?= htmlspecialchars($tech) ?></span>
                                    <?php endforeach; ?>
                                    <?php if (count($techs) > 3): ?>
                                        <span class="tech-tag">+<?= count($techs) - 3 ?></span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div class="project-actions">
                                    <a href="edit_project.php?id=<?= $project['id'] ?>" class="btn btn-edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="post" style="display:inline;" onsubmit="return confirm('Сигурни ли сте, че искате да изтриете този проект?')">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>