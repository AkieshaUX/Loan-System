<?php
$conn = new mysqli('localhost', 'root', '', 'plms');
$conn->set_charset("utf8");
extract($_POST);
extract($_GET);




function display_member($conn)
{
  $query = mysqli_query($conn, "SELECT member.*, beneficiary.* FROM `member` INNER JOIN beneficiary ON member.member_id = beneficiary.member_id WHERE member.mstatus NOT IN (3) ORDER BY member.member_id DESC ");
  return $query;
}
function display_memberdashboard($conn)
{
  $query = mysqli_query($conn, "SELECT member.*, beneficiary.* FROM `member` INNER JOIN beneficiary ON member.member_id = beneficiary.member_id WHERE member.mstatus NOT IN (3) ORDER BY member.member_id DESC LIMIT 4 ");
  return $query;
}

function display_member_funds($conn)
{
  $query = mysqli_query($conn, "SELECT member.*, beneficiary.* FROM `member` INNER JOIN beneficiary ON member.member_id = beneficiary.member_id WHERE member.member_id = $_GET[member_id]");
  return $query;
}
function display_member_funds_table($conn)
{
  $query = mysqli_query($conn, "SELECT * FROM `share` WHERE member_id = $_GET[member_id] ORDER BY share_id DESC");
  return $query;
}
function displayLoan($conn)
{
  $query = mysqli_query($conn, "SELECT monthly_payment.*, member.* FROM `member` INNER JOIN `monthly_payment` ON member.member_id = monthly_payment.member_id WHERE monthly_payment.monthly_payment_id IN (SELECT MAX(monthly_payment_id) FROM monthly_payment GROUP BY member_id ) ORDER BY monthly_payment.monthly_payment_id DESC ");
  return $query;
}


function viewLoanUnpaid($conn)
{
  $query = mysqli_query($conn, "SELECT monthly_payment.*, member.* FROM `member` INNER JOIN `monthly_payment` ON member.member_id = monthly_payment.member_id WHERE  member.member_id = $_GET[member_id] AND monthly_payment.status = 'Unpaid' AND `loan_id` = $_GET[loan_id]  ");
  return $query;
}
function viewLoanPaid($conn)
{
  $query = mysqli_query($conn, "SELECT payment_history.*, member.* FROM `member` INNER JOIN `payment_history` ON member.member_id = payment_history.member_id WHERE  member.member_id = $_GET[member_id] AND payment_history.status = 'Paid'  AND `loan_id` = $_GET[loan_id] ");
  return $query;
}

function displayPaidLoan($conn)
{
  $query = mysqli_query($conn, "SELECT payment_history.*, member.* FROM `member` INNER JOIN `payment_history` ON member.member_id = payment_history.member_id WHERE payment_history.payment_history_id IN (SELECT MAX(payment_history_id) FROM payment_history GROUP BY loan_id ) ORDER BY payment_history.payment_history_id DESC ");
  return $query;
}

function displayPaidLoanProfile($conn)
{
  $member_id = intval($_GET['member_id']);
  $query = mysqli_query($conn, "SELECT payment_history.loanstarted, member.* FROM `member` INNER JOIN `payment_history` ON member.member_id = payment_history.member_id  WHERE member.member_id = $member_id GROUP BY payment_history.loanstarted");
  return $query;
}



// function displayProduct($conn)
// {
//   $query = mysqli_query($conn, " SELECT productsupply.productsupply_id, productsupply.productname, product.productsupply_id,SUM(product.quantitytotal) as total_quantitytotal,  SUM(product.quantity) as total_quantity,  MAX(product.price) as max_price, MAX(product.coast) as max_coast, MAX(product.date) as latest_date FROM  product INNER JOIN  productsupply ON product.productsupply_id = productsupply.productsupply_id   WHERE  product.quantity > 0 GROUP BY  productsupply.productsupply_id ORDER BY latest_date DESC");
//   return $query;
// }


function displayProduct($conn)
{
  $query = mysqli_query($conn, "
        SELECT 
            ps.productsupply_id,
            ps.productname,
            p.price AS price,
            SUM(p.quantity) AS total_quantity,
            SUM(p.quantitytotal) AS total_quantity_total
        FROM `product` p
        LEFT JOIN `productsupply` ps 
        ON p.productsupply_id = ps.productsupply_id
        WHERE p.product_status IS NULL 
        AND p.quantity > 0
        GROUP BY ps.productsupply_id, ps.productname, p.price
        ORDER BY ps.productname, p.price;
    ");


  return $query;
}

// function displaydetails($conn, $productsupply_id)
// {
//   $query = mysqli_query($conn, "SELECT product.*, productsupply.* FROM `product` INNER JOIN productsupply ON  product.productsupply_id  = productsupply.productsupply_id WHERE  p.productsupply_id = $productsupply_id  ORDER BY  productdate DESC");
//   return $query;
// }



// function get_order($conn)
// {
//   $query = mysqli_query($conn, "SELECT productsupply.*, product.product_id FROM productsupply INNER JOIN (SELECT productsupply_id, MIN(product_id) AS product_id FROM product GROUP BY productsupply_id) AS product ON  product.productsupply_id = productsupply.productsupply_id");
//   return $query;
// }

function get_order($conn)
{
  $query = mysqli_query($conn, "SELECT productsupply.*, product.* FROM `product`INNER JOIN `productsupply` ON product.productsupply_id = productsupply.productsupply_id WHERE  product.quantity > 0 ORDER BY  productsupply.productsupply_id ");
  return $query;
}

function displayProductPending($conn)
{
  $query = mysqli_query($conn, "SELECT p.product_id,p.pID, ps.productname, op.order_id, op.orderquantity, op.orderamount, op.minuscoast, op.totalincome, op.date, op.status, op.ordername, p.price  FROM product AS p  INNER JOIN productsupply AS ps ON p.productsupply_id = ps.productsupply_id   INNER JOIN orderproduct AS op ON p.product_id = op.product_id   WHERE op.status = 'Pending'");
  return $query;
}




function displayProductBuy($conn)
{
  // Check if the 'datetime' parameter exists in the URL
  $datetime = isset($_GET['datetime']) ? $_GET['datetime'] : '';

  // If a datetime is selected, filter by the year and month
  if (!empty($datetime)) {
    $year = substr($datetime, 0, 4);  // Get the year from datetime
    $month = substr($datetime, 5, 2);  // Get the month from datetime

    // Modify the query to filter by the selected month and year
    $query = mysqli_query($conn, "SELECT p.product_id, p.price, p.pID, ps.productname, op.order_id, op.orderquantity, op.orderamount, 
                                  op.minuscoast, op.totalincome, op.date, op.status, op.ordername  
                                  FROM product AS p
                                  INNER JOIN productsupply AS ps ON p.productsupply_id = ps.productsupply_id
                                  INNER JOIN orderproduct AS op ON p.product_id = op.product_id
                                  WHERE op.status = 'Buy' AND YEAR(op.date) = '$year' AND MONTH(op.date) = '$month'");
  } else {
    // If no datetime is selected, show all data
    $query = mysqli_query($conn, "SELECT p.product_id, p.price, p.pID, ps.productname, op.order_id, op.orderquantity, op.orderamount, 
                                  op.minuscoast, op.totalincome, op.date, op.status, op.ordername  
                                  FROM product AS p
                                  INNER JOIN productsupply AS ps ON p.productsupply_id = ps.productsupply_id
                                  INNER JOIN orderproduct AS op ON p.product_id = op.product_id
                                  WHERE op.status = 'Buy'");
  }

  return $query;
}



function displayProductBuyDashboard($conn)
{
  $query = mysqli_query($conn, "SELECT p.product_id,p.price,p.pID, ps.productname, op.order_id, op.orderquantity, op.orderamount, op.minuscoast, op.totalincome, op.date, op.status,op.ordername  FROM product AS p  INNER JOIN productsupply AS ps ON p.productsupply_id = ps.productsupply_id   INNER JOIN orderproduct AS op ON p.product_id = op.product_id   WHERE op.status = 'Buy' ORDER BY op.date DESC LIMIT 4");
  return $query;
}

function displayviewProduct($conn)
{
  $query  = mysqli_query($conn, "SELECT * FROM `productsupply` WHERE productsupply_status IS NULL");
  return $query;
}

function displayPurchasesummary($conn)
{
  return mysqli_query($conn, "SELECT YEAR(op.date) AS year, SUM(op.totalincome) AS total_orderamount, SUM(op.orderquantity) AS total_quanitity, MIN(op.date) AS min_date, MAX(op.date) AS max_date FROM product AS p INNER JOIN productsupply AS ps ON p.productsupply_id = ps.productsupply_id INNER JOIN orderproduct AS op ON p.product_id = op.product_id WHERE op.status = 'Buy' GROUP BY YEAR(op.date) ORDER BY year DESC");
}

function displayPurchasesummaryView($conn, $year)
{
  $yearCondition = isset($year) ? "AND YEAR(op.date) = $year" : "";

  $query = mysqli_query($conn, "SELECT p.product_id, p.price, p.pID, ps.productname, op.order_id, op.orderquantity, op.orderamount, op.minuscoast, op.totalincome, op.date, op.status FROM product AS p INNER JOIN productsupply AS ps ON p.productsupply_id = ps.productsupply_id INNER JOIN orderproduct AS op ON p.product_id = op.product_id WHERE op.status = 'Buy' $yearCondition ORDER BY ps.productsupply_id ");

  return $query;
}
function displayunpaidinProfile($conn)
{
  $query = mysqli_query($conn, "SELECT * FROM `monthly_payment`WHERE `member_id` = $_GET[member_id] AND monthly_payment.status = 'Unpaid'");
  return $query;
}


function displayLoanPending($conn)
{
  $query = mysqli_query($conn, "SELECT member.*, loan.* FROM `loan` INNER JOIN member ON member.member_id = loan.member_id WHERE loan.status = 'Pending'");
  return $query;
}

function displayLoanreport($conn, $filterDate = null)
{
  $query = "SELECT member.*, loan.* 
            FROM `loan` 
            INNER JOIN member ON member.member_id = loan.member_id 
            WHERE loan.status = 'Accept'";

  // Apply the month filter if a date is provided
  if ($filterDate) {
    $query .= " AND DATE_FORMAT(loan.date, '%Y-%m') = '$filterDate'";
  }

  return mysqli_query($conn, $query);
}


function displayMiscellaneous($conn)
{
  $query = mysqli_query($conn, "SELECT product.*, productsupply.* FROM `product` INNER JOIN productsupply ON  product.productsupply_id  = productsupply.productsupply_id ORDER BY  productdate DESC");
  return $query;
}


function displayhighfunds($conn)
{
  $query = mysqli_query($conn, "SELECT member.member_id, member.mname,member.reference, SUM(share.mshare) AS total_mshare FROM member INNER JOIN share ON member.member_id = share.member_id  GROUP BY member.member_id ORDER BY total_mshare DESC");
  return $query;
}

function displaySoldthismonth($conn)
{
  $currentMonth = date("m");
  $currentYear = date("Y");

  $query = mysqli_query($conn, "SELECT p.product_id, p.price, p.pID, ps.productname, op.order_id, op.orderquantity, op.orderamount, op.minuscoast, op.totalincome, op.date, op.status, op.ordername FROM product AS p INNER JOIN productsupply AS ps ON p.productsupply_id = ps.productsupply_id INNER JOIN orderproduct AS op ON p.product_id = op.product_id WHERE op.status = 'Buy' AND MONTH(op.date) = '$currentMonth' AND YEAR(op.date) = '$currentYear'");
  return $query;
}

function displaySoldlastMonth($conn)
{

  $currentMonth = date("m");
  $currentYear = date("Y");


  $lastMonth = $currentMonth - 1;
  if ($lastMonth == 0) {
    $lastMonth = 12;
    $currentYear -= 1;
  }

  $query = mysqli_query($conn, "SELECT p.product_id, p.price, p.pID, ps.productname, op.order_id, op.orderquantity, op.orderamount, op.minuscoast, op.totalincome, op.date, op.status, op.ordername FROM product AS p INNER JOIN productsupply AS ps ON p.productsupply_id = ps.productsupply_id INNER JOIN orderproduct AS op ON p.product_id = op.product_id WHERE op.status = 'Buy' AND MONTH(op.date) = '$lastMonth' AND YEAR(op.date) = '$currentYear'");

  return $query;
}


function displaySoldlastyear($conn)
{
  $lastYear = date("Y") - 1;

  $query = mysqli_query($conn, "SELECT p.product_id, p.price, p.pID, ps.productname, op.order_id, op.orderquantity, op.orderamount, op.minuscoast, op.totalincome, op.date, op.status, op.ordername FROM product AS p INNER JOIN productsupply AS ps ON p.productsupply_id = ps.productsupply_id INNER JOIN orderproduct AS op ON p.product_id = op.product_id WHERE op.status = 'Buy' AND YEAR(op.date) = '$lastYear'");

  return $query;
}


function displayTotalinterestSummary($conn)
{
  return mysqli_query($conn, "SELECT YEAR(date) AS year, SUM(interestearned) AS total_interest, SUM(generalfunds) AS total_general_funds, SUM(capital) AS total_capital, SUM(profit) AS total_profit FROM savings GROUP BY YEAR(date) ORDER BY year DESC");
}


function displaywithdrawGenfund($conn)
{
  return mysqli_query($conn, "SELECT `admin`, `amount`, `type`, `date` FROM `withdraw` WHERE `type` = 'GenFund' ORDER BY `date` DESC");
}
function displaywithdrawCapital($conn)
{
  return mysqli_query($conn, "SELECT `admin`, `amount`, `type`, `date` FROM `withdraw` WHERE `type` = 'Capital'");
}
function displaywithdrawProfit($conn)
{
  return mysqli_query($conn, "SELECT `admin`, `amount`, `type`, `date` FROM `withdraw` WHERE `type` = 'Profit'");
}

function displayProfilePaid($conn)
{
  $query = mysqli_query($conn, "SELECT * FROM `payment_history`WHERE `member_id` = $_GET[member_id] AND status = 'Paid' ORDER BY datepayment DESC");
  return $query;
}


function displayLoanhistory($conn)
{
  return mysqli_query($conn, "
    SELECT 
      loan_id,
      MAX(payment_history_id) AS payment_history_id,
      MAX(member_id) AS member_id,
      MAX(status) AS status,
      MAX(datepayment) AS datepayment
    FROM `payment_history`
    WHERE `member_id` = {$_GET['member_id']} 
      AND `status` = 'Paid' 
    GROUP BY `loan_id`
    ORDER BY `loan_id` DESC
  ");
}


function displaywithSales($conn)
{
  return mysqli_query($conn, "SELECT `admin`, `amount`, `type`, `date` FROM `withdraw` WHERE `type` = 'Sales' ORDER BY `date` DESC");
}
