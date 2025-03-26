<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case "GET":
        $sql = "SELECT * FROM users";
        $path = explode('/', $_SERVER['REQUEST_URI']);
        if (isset($path[3]) && is_numeric($path[3])) {
            $sql .= " WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $path[3]);
            $stmt->execute();
            $users = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        echo json_encode($users);
        break;
    
    case "POST":
        $user = json_decode(file_get_contents('php://input'));
        $sql = "INSERT INTO users (name, email, mobile, created_at) VALUES (:name, :email, :mobile, :created_at)";
        $stmt = $conn->prepare($sql);
        $created_at = date('Y-m-d');
        $stmt->bindParam(':name', $user->name);
        $stmt->bindParam(':email', $user->email);
        $stmt->bindParam(':mobile', $user->mobile);
        $stmt->bindParam(':created_at', $created_at);

        $response = $stmt->execute()
            ? ['status' => 1, 'message' => 'Record created successfully.']
            : ['status' => 0, 'message' => 'Failed to create record.'];
        
        echo json_encode($response);
        break;

    case "PUT":
        $user = json_decode(file_get_contents('php://input'));
        $sql = "UPDATE users SET name = :name, email = :email, mobile = :mobile, updated_at = :updated_at WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $updated_at = date('Y-m-d');
        $stmt->bindParam(':id', $user->id);
        $stmt->bindParam(':name', $user->name);
        $stmt->bindParam(':email', $user->email);
        $stmt->bindParam(':mobile', $user->mobile);
        $stmt->bindParam(':updated_at', $updated_at);

        $response = $stmt->execute()
            ? ['status' => 1, 'message' => 'Record updated successfully.']
            : ['status' => 0, 'message' => 'Failed to update record.'];

        echo json_encode($response);
        break;

    case "DELETE":
        $sql = "DELETE FROM users WHERE id = :id";
        $path = explode('/', $_SERVER['REQUEST_URI']);
    
        // Ensure ID is numeric before binding
        if (!isset($path[3]) || !is_numeric($path[3])) {
            echo json_encode(['status' => 0, 'message' => 'Invalid ID provided for deletion.']);
            http_response_code(400); // Bad Request
            exit();
        }
    
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $path[3], PDO::PARAM_INT); // Explicitly set as an integer
    
        $response = $stmt->execute()
            ? ['status' => 1, 'message' => 'Record deleted successfully.']
            : ['status' => 0, 'message' => 'Failed to delete record.'];
    
        echo json_encode($response);
        break;
        
        
}
