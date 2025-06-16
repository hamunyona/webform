<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "sql200.ezyro.com";
$username = "ezyro_39217889";
$password = "@Rey2001";  
$dbname = "ezyro_39217889_user_info_db";

// Connect to MySQL
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    sex VARCHAR(10) NOT NULL,
    age INT NOT NULL,
    marital_status VARCHAR(20) NOT NULL,
    demographic TEXT,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($conn, $sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $sex = htmlspecialchars($_POST['sex']);
    $age = (int)$_POST['age'];
    $marital_status = htmlspecialchars($_POST['marital_status']);
    $demographic = htmlspecialchars($_POST['demographic']);

    $stmt = $conn->prepare("INSERT INTO users (name, sex, age, marital_status, demographic) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $name, $sex, $age, $marital_status, $demographic);

    if ($stmt->execute()) {
        echo "<h1>Thank You!</h1>";
        echo "<p>Your information has been successfully submitted.</p>";
        echo "<p><a href='index.html'>Submit another response</a></p>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
