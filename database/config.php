<?php
// Database configuration
$db_config = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'liondevs_portfolio',
    'charset' => 'utf8mb4'
];

// Create database connection
function getDbConnection() {
    global $db_config;
    
    try {
        $dsn = "mysql:host={$db_config['host']};dbname={$db_config['database']};charset={$db_config['charset']}";
        $pdo = new PDO($dsn, $db_config['username'], $db_config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        die('Database connection failed: ' . $e->getMessage());
    }
}

// Database helper class
class Database {
    private $pdo;
    
    public function __construct() {
        $this->pdo = getDbConnection();
    }
    
    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
    
    public function fetch($sql, $params = []) {
        return $this->query($sql, $params)->fetch();
    }
    
    public function fetchAll($sql, $params = []) {
        return $this->query($sql, $params)->fetchAll();
    }
    
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
    
    public function beginTransaction() {
        return $this->pdo->beginTransaction();
    }
    
    public function commit() {
        return $this->pdo->commit();
    }
    
    public function rollback() {
        return $this->pdo->rollback();
    }
}

// Project management functions
class ProjectManager {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function getAllProjects($category = null) {
        $sql = "SELECT * FROM projects";
        $params = [];
        
        if ($category && $category !== 'all') {
            $sql .= " WHERE category = ?";
            $params[] = $category;
        }
        
        $sql .= " ORDER BY date DESC";
        return $this->db->fetchAll($sql, $params);
    }
    
    public function getProjectById($id) {
        return $this->db->fetch("SELECT * FROM projects WHERE id = ?", [$id]);
    }
    
    public function getProjectByProjectId($project_id) {
        return $this->db->fetch("SELECT * FROM projects WHERE project_id = ?", [$project_id]);
    }
    
    public function createProject($data) {
        $sql = "INSERT INTO projects (project_id, title, category, description, long_description, 
                image, technologies, features, gallery, status, date, client, url, github) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $params = [
            $data['project_id'],
            $data['title'],
            $data['category'],
            $data['description'],
            $data['long_description'],
            $data['image'],
            json_encode($data['technologies']),
            json_encode($data['features']),
            json_encode($data['gallery']),
            $data['status'],
            $data['date'],
            $data['client'],
            $data['url'],
            $data['github']
        ];
        
        $this->db->query($sql, $params);
        return $this->db->lastInsertId();
    }
    
    public function updateProject($id, $data) {
        $sql = "UPDATE projects SET project_id = ?, title = ?, category = ?, description = ?, 
                long_description = ?, image = ?, technologies = ?, features = ?, gallery = ?, 
                status = ?, date = ?, client = ?, url = ?, github = ? WHERE id = ?";
        
        $params = [
            $data['project_id'],
            $data['title'],
            $data['category'],
            $data['description'],
            $data['long_description'],
            $data['image'],
            json_encode($data['technologies']),
            json_encode($data['features']),
            json_encode($data['gallery']),
            $data['status'],
            $data['date'],
            $data['client'],
            $data['url'],
            $data['github'],
            $id
        ];
        
        return $this->db->query($sql, $params);
    }
    
    public function deleteProject($id) {
        return $this->db->query("DELETE FROM projects WHERE id = ?", [$id]);
    }
    
    public function getCategories() {
        return $this->db->fetchAll("SELECT * FROM project_categories ORDER BY category_name");
    }
    
    public function getTechnologies() {
        return $this->db->fetchAll("SELECT * FROM technologies ORDER BY name");
    }
}

// Settings management class
class SettingsManager {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function getSetting($key, $default = '') {
        $result = $this->db->fetch("SELECT setting_value FROM site_settings WHERE setting_key = ?", [$key]);
        return $result ? $result['setting_value'] : $default;
    }
    
    public function setSetting($key, $value) {
        return $this->db->query(
            "INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?) 
             ON DUPLICATE KEY UPDATE setting_value = ?, updated_at = NOW()",
            [$key, $value, $value]
        );
    }
    
    public function getAllSettings() {
        return $this->db->fetchAll("SELECT * FROM site_settings");
    }
}

?>