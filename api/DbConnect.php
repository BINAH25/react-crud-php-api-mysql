<?php
/**
* Database Connection
*/
class DbConnect {
    private $server = '';
    private $dbname = '';
    private $user = '';
    private $pass = '';

    public function __construct() {
        // Fetching environment variables
        $this->server = getenv('DB_HOST') ?: 'lamp-stack-server-app-database.cxk0w42u04ve.eu-west-1.rds.amazonaws.com';  // Default to 'mysql' if not set
        $this->dbname = getenv('DB_NAME') ?: 'react_crud';
        $this->user = getenv('DB_USER') ?: 'admin';
        $this->pass = getenv('DB_PASSWORD') ?: 'Admin123';
    }

    public function connect() {
        try {
            $conn = new PDO('mysql:host=' .$this->server .';dbname=' . $this->dbname, $this->user, $this->pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (\Exception $e) {
            echo "Database Error: " . $e->getMessage();
        }
    }
}
?>
