<?php
$conn = new mysqli('localhost', 'root', '', 'plms');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

$loan_data = [];

// Fetch all distinct years available in the loan table
$sql_years = "SELECT DISTINCT YEAR(date) AS loan_year FROM `loan` WHERE status = 'Accept' ORDER BY loan_year DESC";
$result_years = $conn->query($sql_years);

// Loop through each year to fetch loan data
while ($row_year = $result_years->fetch_assoc()) {
    $year = $row_year['loan_year'];

    // Initialize arrays for each year
    $monthly_loans = array_fill(0, 12, 0);
    $monthly_amounts = array_fill(0, 12, 0);

    // Fetch loan data for the current year
    $sql = "SELECT COUNT(loan_id) AS total_loans, SUM(amount) AS total_amount, MONTH(date) AS loan_month 
            FROM `loan`
            WHERE status = 'Accept' AND YEAR(date) = $year
            GROUP BY MONTH(date)";
    
    $result = $conn->query($sql);
    
    // Map the loan data and amounts to their respective months
    while ($row = $result->fetch_assoc()) {
        $monthly_loans[$row['loan_month'] - 1] = $row['total_loans'];
        $monthly_amounts[$row['loan_month'] - 1] = $row['total_amount'];
    }

    // Store the loan data for the current year in the $loan_data array
    $loan_data[$year] = [
        'counts' => $monthly_loans,
        'amounts' => $monthly_amounts
    ];
}

// Encode the loan data into JSON format for use in JavaScript
echo "<script>
    var loanData = " . json_encode($loan_data) . ";
    console.log('Loan Data:', loanData);
</script>";
?>
