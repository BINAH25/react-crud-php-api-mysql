<?php
require 'vendor/autoload.php';

use Aws\SecretsManager\SecretsManagerClient;
use Aws\Exception\AwsException;

class DbConnect {
    private $server;
    private $dbname;
    private $user;
    private $pass;

    public function __construct() {
        $secretName = "lamp-stack-database-secret"; 
        $region = "eu-west-1"; 

        try {
            $client = new SecretsManagerClient([
                'region' => $region,
                'version' => 'latest',
            ]);

            $result = $client->getSecretValue([
                'SecretId' => $secretName,
            ]);

            if (isset($result['SecretString'])) {
                
                $secrets = json_decode($result['SecretString'], true);

                $this->server = $secrets['host'] ?? 'mysql';
                $this->dbname = $secrets['dbname'] ?? 'react_crud';
                $this->user = $secrets['username'] ?? 'root';
                $this->pass = $secrets['password'] ?? 'rootpassword';
            }
        } catch (AwsException $e) {
            echo "Secrets Manager Error: " . $e->getMessage();
        }
    }

    public function connect() {
        try {
            $dsn = 'mysql:host=' . $this->server . ';dbname=' . $this->dbname;
            $conn = new PDO($dsn, $this->user, $this->pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (\Exception $e) {
            echo "Database Error: " . $e->getMessage();
        }
    }
}
?>
