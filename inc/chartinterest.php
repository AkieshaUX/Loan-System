<?php
$conn = new mysqli('localhost', 'root', '', 'plms');


// Get the current year
$currentYear = date('Y');

// Query for both the current and previous year's data
$query = mysqli_query($conn, "
  SELECT YEAR(date) AS year, 
         SUM(interestearned) AS total_interest, 
         SUM(generalfunds) AS total_general_funds, 
         SUM(capital) AS total_capital, 
         SUM(profit) AS total_profit 
  FROM savings 
  GROUP BY YEAR(date) 
  ORDER BY year DESC
");

$chartData = [];
while ($row = mysqli_fetch_assoc($query)) {
    $chartData[] = [
        'year' => $row['year'],
        'total_interest' => $row['total_interest'],
        'total_general_funds' => $row['total_general_funds'],
        'total_capital' => $row['total_capital'],
        'total_profit' => $row['total_profit']
    ];
}

// Reverse the array to show the years in ascending order
$chartData = array_reverse($chartData);

// Encode data to JSON for JavaScript
$chartDataJson = json_encode($chartData);
?>


