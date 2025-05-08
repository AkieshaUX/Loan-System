<?php
$conn = new mysqli('localhost', 'root', '', 'plms');

// Ensure all months (January to December) are included in the labels
$months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

// Initialize arrays for sales data
$sales_data = [];

// Query to fetch sales data grouped by year and month
$sql_sales = "SELECT SUM(totalincome) AS total_sales, MONTH(date) AS sale_month, YEAR(date) AS sale_year
              FROM `orderproduct`
              WHERE status = 'Buy'
              GROUP BY YEAR(date), MONTH(date)
              ORDER BY YEAR(date) DESC, MONTH(date)";
              
$result_sales = $conn->query($sql_sales);

// Process the sales data
while ($row = $result_sales->fetch_assoc()) {
    $year = $row['sale_year'];
    $month = $row['sale_month'] - 1;  // Adjust for zero-based index

    if (!isset($sales_data[$year])) {
        $sales_data[$year] = array_fill(0, 12, 0);  // Initialize an array for each year
    }
    $sales_data[$year][$month] = $row['total_sales'];  // Fill the respective month's sales
}

// Prepare data for JavaScript
$final_months = $months;  // Static list of months
$years = array_keys($sales_data);  // Get all available years

// Prepare sales data for each year dynamically
$final_sales_data = [];
foreach ($years as $year) {
    $final_sales_data[$year] = $sales_data[$year];
}

// Prepare the JavaScript variables
$final_sales_data_json = json_encode($final_sales_data);
?>
