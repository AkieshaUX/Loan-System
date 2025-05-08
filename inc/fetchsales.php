<?php
$conn = new mysqli('localhost', 'root', '', 'plms');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

header('Content-Type: application/json'); // Set the content type to JSON
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['action']) && $_GET['action'] == 'getSalesData') {
    $query = "SELECT ps.productname, SUM(op.totalincome) AS total_sales 
              FROM orderproduct AS op 
              INNER JOIN productsupply AS ps ON op.productsupply_id = ps.productsupply_id 
              WHERE op.status = 'Buy'
              GROUP BY ps.productname 
              ORDER BY total_sales DESC";

    $result = $conn->query($query);

    $labels = [];
    $data = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $labels[] = $row['productname'];
            $data[] = (float)$row['total_sales']; // Cast to float to ensure data type consistency
        }
    } else {
        // Log error if query fails
        error_log("Query Error: " . $conn->error);
    }

    // Return JSON response
    echo json_encode(['labels' => $labels, 'data' => $data]);
    exit; // Ensure no further output
}

$conn->close();
