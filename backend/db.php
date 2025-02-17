

<?php
require_once 'config.php';

// Usage example in another script
// $db = Database::getInstance()->getConnection();
class Database {
    private static $instance = null;
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, 
                DB_USER, 
                DB_PASS, 
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    // Singleton Pattern: Ensure only one instance of Database exists
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Get PDO object for executing queries
    public function getConnection() {
        return $this->pdo;
    }
}
?>
