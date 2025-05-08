<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'plms');
$conn->set_charset("utf8");
extract($_POST);
extract($_GET);
extract($_SESSION);
error_reporting(0);



if (isset($_POST['loginBtn'])) {
  $admin_user = $_POST['admin_user'];
  $admin_pass = $_POST['admin_pass'];
  $stmt = $conn->prepare("SELECT * FROM `admin` WHERE `admin_user` = ?");
  $stmt->bind_param("s", $admin_user);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
    if ($admin_pass == $admin['admin_pass']) {
      $_SESSION['admin_id'] = $admin['admin_id'];
      $_SESSION['admin_user'] = $admin['admin_user'];
      header('Location: ../pages/dashboard.php');
      exit();
    } else {
      header('Location: ../index.php?invalid');
      exit();
    }
  } else {
    header('Location: ../index.php?invalid');
    exit();
  }
  $stmt->close();
}




if (isset($REGISTERMEMBER)) {
  $reference = substr(strtoupper(uniqid('MEM')), -10);

  $fileName = $_FILES['mprofile']['name'];
  $fileTemp = $_FILES['mprofile']['tmp_name'];
  $exp = explode(".", $fileName);
  $extension = end($exp);

  $newprofileFileName = time() . "." . $extension;
  move_uploaded_file($fileTemp, "../image/member/PROFILE/" . $newprofileFileName);


  $fileName = $_FILES['mvalidID']['name'];
  $fileTemp = $_FILES['mvalidID']['tmp_name'];
  $exp = explode(".", $fileName);
  $extension = end($exp);

  $newvalidIDFileName = time() . "." . $extension;
  move_uploaded_file($fileTemp, "../image/member/ID/" . $newvalidIDFileName);


  $sql1 = "INSERT INTO `member`(`reference`,`mname`, `mgender`, `mcontact`, `mbdate`, `maddress`, `mprofile`, `mvalidID`, `started`,`mstatus`) VALUES ('$reference','$mname','$mgender','$mcontact','$mbdate','$maddress','$newprofileFileName','$newvalidIDFileName',NOW(),0)";



  $query1 = $conn->query($sql1);
  $lastinsertID = mysqli_insert_id($conn);


  $fileName = $_FILES['bprofile']['name'];
  $fileTemp = $_FILES['bprofile']['tmp_name'];
  $exp = explode(".", $fileName);
  $extension = end($exp);

  $newbprofileFileName = time() . "." . $extension;
  move_uploaded_file($fileTemp, "../image/beneficiary/PROFILE/" . $newbprofileFileName);


  $fileName = $_FILES['bvalidID']['name'];
  $fileTemp = $_FILES['bvalidID']['tmp_name'];
  $exp = explode(".", $fileName);
  $extension = end($exp);

  $newbvalidIDFileName = time() . "." . $extension;
  move_uploaded_file($fileTemp, "../image/beneficiary/ID/" . $newbvalidIDFileName);

  $sql2 = "INSERT INTO `beneficiary`(`member_id`, `bname`, `bgender`, `bcontact`, `bdate`, `baddress`, `brelation`, `bprofile`, `bvalidID`) VALUES ('$lastinsertID','$bname','$bgender','$bcontact','$bdate','$baddress','$brelation','$newbprofileFileName','$newbvalidIDFileName')";

  $query2 = $conn->query($sql2);
  $invoice_number = 'INV' . str_pad(substr(strtoupper(uniqid()), -6), 6, '0', STR_PAD_LEFT);
  $sql3 = "INSERT INTO `share`(`invoice_number`,`member_id`, `mshare`, `type`, `date`) VALUES ('$invoice_number','$lastinsertID','$mshare','Registration',NOW())";
  $query3 = $conn->query($sql3);
  $lastinserSharetID = mysqli_insert_id($conn);

  $sql4 = "INSERT INTO `funding`(`share_id`, `amount`, `date`,`withdraw` ) VALUES ('$lastinserSharetID','$mshare',NOW(),'$mshare')";
  $query4 = $conn->query($sql4);
}


if (isset($_GET['member_id'])) {
  $memberID = $_GET['member_id'];
  $sql = "SELECT member.*, beneficiary.* FROM `member` INNER JOIN beneficiary ON member.member_id = beneficiary.member_id WHERE member.member_id = '$memberID'";
  $result = $conn->query($sql);
  echo json_encode($result->fetch_assoc());
}

if (isset($UPDATEMEMBER)) {

  function handleFileUpload($file, $currentFile, $path)
  {
    if (!empty($_FILES[$file]['name'])) {
      $fileName = $_FILES[$file]['name'];
      $fileTemp = $_FILES[$file]['tmp_name'];
      $extension = pathinfo($fileName, PATHINFO_EXTENSION);
      $newFileName = time() . "." . $extension;
      move_uploaded_file($fileTemp, $path . $newFileName);
      return $newFileName;
    }
    return $currentFile;
  }

  $newprofileFileName = handleFileUpload('mprofile', $_POST['current_mprofile'], "../image/member/PROFILE/");
  $newvalidIDFileName = handleFileUpload('mvalidID', $_POST['current_mvalidID'], "../image/member/ID/");

  $sql1 = "UPDATE `member` SET `mname`='$mname',`mgender`='$mgender',`mcontact`='$mcontact',`mbdate`='$mbdate',`maddress`='$maddress',`mprofile`='$newprofileFileName',`mvalidID`='$newvalidIDFileName' WHERE `member_id` = '$memberID'";
  $query1 = $conn->query($sql1);

  $newbprofileFileName = handleFileUpload('bprofile', $_POST['current_bprofile'], "../image/beneficiary/PROFILE/");
  $newbvalidIDFileName = handleFileUpload('bvalidID', $_POST['current_bvalidID'], "../image/beneficiary/ID/");

  $sql2 = "UPDATE `beneficiary` SET `bname`='$bname',`bgender`='$bgender',`bcontact`='$bcontact',`bdate`='$bdate',`baddress`='$baddress',`brelation`='$brelation',`bprofile`='$newbprofileFileName',`bvalidID`='$newbvalidIDFileName' WHERE `member_id` = '$memberID'";
  $query2 = $conn->query($sql2);
}

if (isset($_POST['removemember'])) {
  $memberID = $_POST['member_id'];
  $sql = "UPDATE `member` SET `mstatus`='3' WHERE `member_id` = '$memberID'";
  $query = $conn->query($sql);
}


if (isset($ADDNEWFUNDS)) {

  $invoice_number = 'INV' . str_pad(substr(strtoupper(uniqid()), -6), 6, '0', STR_PAD_LEFT);

  $sql = "INSERT INTO `share`(`invoice_number`,`member_id`, `mshare`, `type`, `date`) VALUES ('$invoice_number','$member_id','$mshare','Add Funds',NOW())";
  $query = $conn->query($sql);
  $lastInsertID = mysqli_insert_id($conn);

  $sql1 = "INSERT INTO `funding`(`share_id`, `amount`, `date`,`withdraw`) VALUES ('$lastInsertID','$mshare',NOW(),'$mshare')";
  $query1 = $conn->query($sql1);
}


if (isset($_GET['share_id'])) {
  $shareID = $_GET['share_id'];
  $sql = "
    SELECT share.*, funding.*, member.*
    FROM `share`
    INNER JOIN funding ON share.share_id = funding.share_id
    INNER JOIN member ON share.member_id = member.member_id
    WHERE share.share_id = $shareID";

  $result = $conn->query($sql);
  echo json_encode($result->fetch_assoc());
}



if (isset($EDITFUNDSFORM)) {
  $sql = "UPDATE `share` SET `mshare`='$mshare' WHERE share_id = $shareID ";
  $query = $conn->query($sql);

  $sql1 = "UPDATE `funding` SET `amount`='$mshare',`withdraw`='$mshare' WHERE share_id = $shareID";
  $query1 = $conn->query($sql1);
}



if (isset($_POST['REGISTERLoan'])) {
  date_default_timezone_set('Asia/Manila');
  $today = date("Y-m-d");
  $todaynow = $today;
  $amount = $_POST['amount'];


  // $sql = "SELECT SUM(`withdraw`) as totalAvailable FROM `funding` WHERE `withdraw` != 0";
  // $result = $conn->query($sql);
  // $row = $result->fetch_array();
  // $totalAvailable = $row['totalAvailable'];


  // if ($amount > $totalAvailable) {
  //   echo json_encode(['status' => 'error', 'message' => 'Not enough available funds to complete the loan registration process.']);
  //   return;
  // }

  $checkQuery = "SELECT `member_id` FROM `loan` WHERE `member_id` = '$member_id' AND `status` = 'Pending'";
  $result = $conn->query($checkQuery);

  if ($result->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'A pending loan for this member already exists.']);
    return;
  }


  $insertloan = "INSERT INTO `loan`(`member_id`, `type`, `purpose`, `amount`, `tenure`, `date`, `status`, `interest`, `totalinterest`, `monthlyinterest`, `totalpayment`, `monthlypayment`)  VALUES ('$member_id', 'Loan', '$purpose', '$amount', '$tenure', NOW(), 'Pending', '$interest', '$totalinterest', '$monthlyinterest', '$totalpayment', '$monthlypayment')";
  $insertloanquery = $conn->query($insertloan);

  if ($insertloanquery) {
    echo json_encode(['status' => 'success', 'message' => 'Loan registered successfully.']);
  } else {
    echo json_encode(['status' => 'error', 'message' => 'Error during loan registration: ' . $conn->error]);
  }
}






if (isset($_POST['EDITLoanFORM'])) {

  $sql = "SELECT SUM(`withdraw`) as totalAvailable FROM `funding` WHERE `withdraw` != 0";
  $result = $conn->query($sql);
  $row = $result->fetch_array();
  $totalAvailable = $row['totalAvailable'];


  if ($amount > $totalAvailable) {
    echo json_encode(['status' => 'error', 'message' => 'Not enough available funds to complete the loan registration process.']);
    return;
  }


  $insertloan = "UPDATE `loan` SET `member_id`='$member_id',`purpose`='$purpose',`amount`='$amount',`tenure`='$tenure',`interest`='$interest',`totalinterest`='$totalinterest',`monthlyinterest`='$monthlyinterest',`totalpayment`='$totalpayment',`monthlypayment`='$monthlypayment' WHERE `loan_id`= $loan_id ";
  $insertloanquery = $conn->query($insertloan);

  if ($insertloanquery) {
    echo json_encode(['status' => 'success', 'message' => 'Loan registered successfully.']);
  } else {
    echo json_encode(['status' => 'error', 'message' => 'Error during loan registration: ' . $conn->error]);
  }
}



if (isset($_POST['AcceptBTN'])) {
  date_default_timezone_set('Asia/Manila');
  $today = date("Y-m-d");
  $todaynow = $today;

  $loanID = $_POST['loan_id'];

  // LEFT JOIN to get member's name and contact
  $fetchloan = "SELECT loan.member_id, loan.purpose, loan.amount, loan.tenure, loan.interest, loan.totalinterest, loan.monthlyinterest, loan.totalpayment, loan.monthlypayment, member.mname, member.mcontact
                FROM loan
                LEFT JOIN member ON loan.member_id = member.member_id
                WHERE loan.loan_id = $loanID";
  $result = $conn->query($fetchloan);
  $row = $result->fetch_array();

  $member_id = $row['member_id'];
  $purpose = $row['purpose'];
  $amount = $row['amount'];
  $tenure = $row['tenure'];
  $interest = $row['interest'];
  $totalinterest = $row['totalinterest'];
  $monthlyinterest = $row['monthlyinterest'];
  $totalpayment = $row['totalpayment'];
  $monthlypayment = $row['monthlypayment'];
  $member_name = $row['mname'];  // Member's name
  $phoneNumber = $row['mcontact'];  // Member's contact number

  // Check if enough funds are available
  $sql = "SELECT SUM(`withdraw`) as totalAvailable FROM `funding` WHERE `withdraw` != 0";
  $result = $conn->query($sql);
  $row = $result->fetch_array();
  $totalAvailable = $row['totalAvailable'];

  if ($amount > $totalAvailable) {
    echo json_encode(['status' => 'error', 'message' => 'Not enough available funds to complete the loan registration process.']);
    return;
  }

  // Update loan status
  $updateloanstatus = "UPDATE `loan` SET `status`='Approved' WHERE `loan_id` = $loanID";
  $updateloanstatusquery = $conn->query($updateloanstatus);

  for ($i = 1; $i <= $tenure; $i++) {
    $started = date("Y-m-d", strtotime($today . " + $i months"));
    $duedate = date("Y-m-d", strtotime($started . " + 1 months"));
    // Generate a unique invoice number with 'INV' prefix
    $invoice_number = 'INV' . str_pad(substr(strtoupper(uniqid()), -6), 6, '0', STR_PAD_LEFT);

    $sql = "INSERT INTO `monthly_payment`(`loan_id`,`member_id`, `reference_payment`,`amount`,`purpose`, `loanstarted`, `duedate`, `tenure`, `interest`, `totalinterest`, `monthlyinterest`, `totalpayment`, `monthlypayment`, `status`) 
              VALUES ('$loanID','$member_id', '$invoice_number','$amount','$purpose', '$todaynow', '$started', '$tenure', '$interest', '$totalinterest', '$monthlyinterest', '$totalpayment', '$monthlypayment', 'Unpaid')";
    $query = $conn->query($sql);
  }

  // Update member status
  $updatestatus = "UPDATE `member` SET `mstatus`='1' WHERE `member_id` = '$member_id'";
  $query1 = $conn->query($updatestatus);

  $totalWithdrawn = 0;

  // Withdraw the loan amount from available funds
  do {
    $sql = "SELECT * FROM `funding` WHERE `withdraw` != 0 LIMIT 1";
    $result = $conn->query($sql);
    $row = $result->fetch_array();
    $availableAmount = $row['withdraw'];

    if ($amount <= $availableAmount) {
      $totalWithdrawn += $amount;
      $totalamount = $availableAmount - $amount;
      $update = "UPDATE `funding` SET `withdraw`='$totalamount' WHERE `funding_id` = '$row[0]'";
      $upquery = $conn->query($update);
      $amount = 0;
    } else {
      $totalWithdrawn += $availableAmount;
      $newtotalamount = $amount - $availableAmount;
      $update = "UPDATE `funding` SET `withdraw`= 0 WHERE `funding_id` = '$row[0]'";
      $upquery = $conn->query($update);
      $amount = $newtotalamount;
    }
  } while ($amount != 0);

  // Record the withdrawal
  if ($totalWithdrawn > 0) {
    $insert = "INSERT INTO `withdraw`(`loan_id`,`member_id`, `amount`, `type`, `date`) VALUES ('$loanID','$member_id', '$totalWithdrawn', 'Loan', NOW())";
    $inquery = $conn->query($insert);
  }

  $message = 'Hello ' . $member_name .   'Your loan has been approved!. Please visit our office to claim your loan amount or reach out to us for further instructions. Thank you for choosing us for your financial needs!';



  $apiKey = '52eeae903efd299bee45a37f7f6f56d3';
  $sender = 'BoardSpot';
  $url = 'https://semaphore.co/api/v4/messages';

  $data = [
    'apikey' => $apiKey,
    'number' => $phoneNumber,
    'message' => $message,
    'sendername' => $sender
  ];

  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  $response = curl_exec($ch);
  curl_close($ch);

  echo json_encode(['status' => 'success', 'message' => 'Loan approved successfully and SMS sent!']);
}








// if (isset($_GET['monthly_payment_id'])) {
//   $monthlyID = $_GET['monthly_payment_id'];
//   $sql = "SELECT monthly_payment.*, member.*, share.* FROM `member` INNER JOIN `monthly_payment`ON member.member_id = monthly_payment.member_id  LEFT JOIN `share`  ON member.member_id = share.member_id   WHERE monthly_payment.monthly_payment_id = $monthlyID  AND monthly_payment.status = 'Unpaid'";
//   $result = $conn->query($sql);
//   echo json_encode($result->fetch_assoc());
// }


if (isset($_GET['loan_id'])) {
  $loanID = intval($_GET['loan_id']);

  // $sql = "SELECT  monthly_payment.*,  member.*, loan.* FROM `member` INNER JOIN `monthly_payment` ON member.member_id = monthly_payment.member_id LEFT JOIN `loan` ON loan.loan_id = monthly_payment.loan_id WHERE monthly_payment.loan_id = $loanID  AND monthly_payment.status = 'Unpaid'";
  $sql = "SELECT member.*, loan.* FROM `loan` INNER JOIN member ON member.member_id = loan.member_id WHERE loan.status = 'Pending'";

  $result = $conn->query($sql);
  echo json_encode($result->fetch_assoc());
}





if (isset($_GET['monthly_payment_id'])) {
  $monthlypaymentID = intval($_GET['monthly_payment_id']);
  $sql = "SELECT * FROM `monthly_payment` WHERE `monthly_payment_id` ='$monthly_payment_id' ";
  $result = $conn->query($sql);
  echo json_encode($result->fetch_assoc());
}



if (isset($paymentreference)) {
  date_default_timezone_set('Asia/Manila');
  $today = date("Y-m-d");
  $todaynow = $today;


  $updatepayment = "UPDATE `monthly_payment` SET `datepayment`='$todaynow', `status`='Paid' WHERE `monthly_payment_id` = '$monthly_payment_id'";
  $updatepaymentquery = $conn->query($updatepayment);


  $selectpayment = "SELECT `loan_id`, `member_id`, `reference_payment`, `amount`, `purpose`, `loanstarted`, `duedate`, `datepayment`, `tenure`, `interest`, `totalinterest`, `monthlyinterest`, `totalpayment`, `monthlypayment`, `status` FROM `monthly_payment` WHERE `monthly_payment_id` = '$monthly_payment_id'";
  $result = $conn->query($selectpayment);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();


    $inserthistory = "INSERT INTO `payment_history`(`loan_id`, `member_id`, `reference_payment`, `amount`, `purpose`, `loanstarted`, `duedate`, `datepayment`, `tenure`, `interest`, `totalinterest`, `monthlyinterest`, `totalpayment`, `monthlypayment`, `status`,`type`)VALUES ('{$row['loan_id']}', '{$row['member_id']}','{$row['reference_payment']}','{$row['amount']}','{$row['purpose']}','{$row['loanstarted']}', '{$row['duedate']}','{$todaynow}', '{$row['tenure']}','{$row['interest']}', '{$row['totalinterest']}','{$row['monthlyinterest']}','{$row['totalpayment']}','{$row['monthlypayment']}', '{$row['status']}','Loan Payment' )";
    $inserthistoryquery = $conn->query($inserthistory);

    $deletepayment = "DELETE FROM `monthly_payment` WHERE `monthly_payment_id` = '$monthly_payment_id'";
    $conn->query($deletepayment);


    $checkUnpaid = "SELECT COUNT(*) AS unpaid_count FROM `monthly_payment` WHERE `member_id` = '{$row['member_id']}' AND `status` = 'Unpaid'";
    $unpaidResult = $conn->query($checkUnpaid);
    $unpaidRow = $unpaidResult->fetch_assoc();


    if ($unpaidRow['unpaid_count'] == 0) {
      $updateMemberStatus = "UPDATE `member` SET `mstatus` = 0 WHERE `member_id` = '{$row['member_id']}'";
      $conn->query($updateMemberStatus);


      echo 'last_payment';
    } else {

      echo 'payment_processed';
    }
  }


  $interestearned = $monthlyinterest;

  $generalfunds = $interestearned * 0.10;
  $capital = $interestearned * 0.20;
  $remaining = $interestearned - ($generalfunds + $capital);
  $profit = $remaining;



  $insertsavings = "INSERT INTO `savings` (`interestearned`, `generalfunds`, `gfwithdraw`, `capital`, `capitalwithdraw`, `profit`, `profitwithdraw`, `date`)  VALUES  ('$interestearned', '$generalfunds', '$generalfunds', '$capital', '$capital', '$profit', '$profit', NOW())";
  $insertsavingsquery = $conn->query($insertsavings);


  $payment1 = $monthlypayment - $monthlyinterest;
  $insertfunding = "INSERT INTO `funding`(`date`, `withdraw`) VALUES (NOW(),'$payment1')";
  $insertfundingquery = $conn->query($insertfunding);
}




if (isset($addproduct)) {

  $result = $conn->query("SELECT MAX(CAST(SUBSTRING(pID, 3) AS UNSIGNED)) AS max_pid FROM product");
  $row = $result->fetch_assoc();
  $nextPID = isset($row['max_pid']) ? $row['max_pid'] + 1 : 1;
  $formattedPID = sprintf("OR%03d", $nextPID);
  $sql = "INSERT INTO `product`(`productsupply_id`, `quantitytotal`, `quantity`, `price`,`coast`, `productdate`, `pID`)  VALUES ('$productsupply_id', '$quantity', '$quantity', '$price', '$coast',NOW(), '$formattedPID')";
  $query = $conn->query($sql);

  if ($query) {
    echo "Product added successfully with pID $formattedPID";
  } else {
    echo "Error: " . $conn->error;
  }
}



if (isset($_POST['addproducts'])) {
  $productname = $_POST['productname'];

  $checkQuery = "SELECT * FROM `productsupply` WHERE `productname` = '$productname' AND productsupply_status	IS NULL";
  $result = $conn->query($checkQuery);

  if ($result->num_rows > 0) {

    echo "Product name already exists!";
  } else {

    if (isset($addproducts)) {
      $sql = "INSERT INTO `productsupply`(`productname`) VALUES ('$productname')";
      $query = $conn->query($sql);
      if ($query) {
        echo "Product added successfully!";
      } else {
        echo "Failed to add product!";
      }
    }
  }
  exit();
}




if (isset($_GET['payment_history_id'])) {
  $payment_history_id = $_GET['payment_history_id'];
  $query = "SELECT payment_history.*, member.* FROM `member`INNER JOIN `payment_history` ON member.member_id = payment_history.member_id WHERE payment_history.payment_history_id = '$payment_history_id'";
  $result = $conn->query($query);
  echo json_encode($result->fetch_assoc());
}







if (isset($_POST['plusquantityForm']) || isset($_POST['minusquantityForm'])) {

  $product_id = $_POST['product_id'];


  $currentResult = $conn->query("SELECT quantitytotal, quantity FROM product WHERE product_id ='$product_id'");
  $currentRow = $currentResult->fetch_assoc();
  $currentQuantityTotal = $currentRow['quantitytotal'];
  $currentQuantity = $currentRow['quantity'];

  if (isset($_POST['plusquantityForm'])) {

    $plusquantity = $_POST['plusquantity'];
    $newQuantityTotal = $currentQuantityTotal + $plusquantity;
    $newQuantity = $currentQuantity + $plusquantity;
  } elseif (isset($_POST['minusquantityForm'])) {

    $minusquantity = $_POST['minusquantity'];
    $newQuantityTotal = $currentQuantityTotal - $minusquantity;
    $newQuantity = $currentQuantity - $minusquantity;
  }


  $sql = "UPDATE product SET `quantitytotal`='$newQuantityTotal', `quantity`='$newQuantity' WHERE `product_id`='$product_id'";
  $query = $conn->query($sql);


  if ($query) {
    echo "Quantity updated successfully.";
  } else {
    echo "Error updating quantity: " . $conn->error;
  }
}

if (isset($Editproduct)) {
  $sql = "UPDATE `product` SET `productsupply_id`='$productsupply_id',`price`='$price',`productdate`='$date' WHERE `product_id` = '$product_id'";
  $query = $conn->query($sql);
}



if (isset($_POST['orderForm'])) {
  list($productsupply_id, $product_id) = explode('|', $_POST['productsupply_id']);
  $quantity = $_POST['quantity'];
  $coast = $_POST['coast'];

  // Retrieve current product coast from product table
  $currentResult = $conn->query("SELECT coast,pID FROM product WHERE product_id ='$product_id'");
  $currentRow = $currentResult->fetch_assoc();
  $nowcoast = $currentRow['coast'];
  $nowpID = $currentRow['pID'];

  // Check product quantity
  $result = $conn->query("SELECT `quantity` as total_quantity FROM `product` WHERE `quantity` != 0 AND `product_id`='$product_id'");
  $row = $result->fetch_array();
  $total_quantity = $row['total_quantity'];

  if ($quantity > $total_quantity) {
    echo json_encode(['status' => 'error', 'message' => 'Not enough available product to complete purchase.']);
    return;
  } else {
    $checkQuery = $conn->query("SELECT * FROM `orderproduct` WHERE `product_id` = '$product_id' LIMIT 1");

    if ($checkQuery->num_rows > 0) {
      // If order exists, add a new order without modifying the existing record
      $insertSql = "INSERT INTO `orderproduct` (productsupply_id,product_id,orderproductno,ordername, orderquantity, orderamount, minuscoast, totalincome, date, status)  
                    VALUES ('$productsupply_id','$product_id','$nowpID','$ordername', '$quantity', '$coast', NULL, '$coast', NOW(), 'Pending')";
      $conn->query($insertSql);
      echo json_encode(['status' => 'success', 'message' => 'New order added .']);
    } else {
      // Calculate the total income if no prior order exists
      $totalIncome = $coast - $nowcoast;
      $insertSql = "INSERT INTO `orderproduct` (productsupply_id,product_id,orderproductno,ordername, orderquantity, orderamount, minuscoast, totalincome, date, status)  
                    VALUES ('$productsupply_id','$product_id','$nowpID','$ordername', '$quantity', '$coast', '$nowcoast', '$totalIncome', NOW(), 'Pending')";
      $conn->query($insertSql);
      echo json_encode(['status' => 'success', 'message' => 'New order added.']);
    }
  }
}





if (isset($_GET['order_id'])) {
  $order_id = $_GET['order_id'];
  $sql = "SELECT p.product_id,p.pID,p.price, ps.productname, op.order_id, op.orderquantity, op.orderamount, op.minuscoast, op.totalincome,op.productsupply_id, op.date, op.status,op.ordername,op.orderproductno  FROM product AS p   INNER JOIN productsupply AS ps ON p.productsupply_id = ps.productsupply_id   INNER JOIN orderproduct AS op ON p.productsupply_id = op.productsupply_id  WHERE op.order_id = '$order_id' ";
  $result = mysqli_query($conn, $sql);
  echo json_encode($result->fetch_assoc());
}


// if (isset($_GET['order_id'])) { 
//   $order_id = $_GET['order_id'];
//   $sql = "SELECT p.product_id,p.pID,p.price, ps.productname, op.order_id, op.orderquantity, op.orderamount, op.minuscoast, op.totalincome,op.productsupply_id, op.date, op.status,op.ordername  FROM product AS p   INNER JOIN productsupply AS ps ON p.productsupply_id = ps.productsupply_id   INNER JOIN orderproduct AS op ON p.productsupply_id = op.productsupply_id  WHERE op.order_id = '$order_id' AND op.status = 'Buy'";
//   $result = mysqli_query($conn, $sql);
//   echo json_encode($result->fetch_assoc());
// }



if (isset($_GET['product_id'])) {
  $productID = $_GET['product_id'];
  $sql = "SELECT * FROM `product` WHERE product_id = $productID";
  $result = mysqli_query($conn, $sql);
  echo json_encode($result->fetch_assoc());
}
if (isset($editorderForm)) {
  // Retrieve `minuscoast` from `orderproduct`
  $checkQuery = $conn->query("SELECT minuscoast FROM orderproduct WHERE order_id ='$order_id'");
  if ($checkQuery && $checkQuery->num_rows > 0) {
    $currentRow = $checkQuery->fetch_assoc();
    $nowcoast = $currentRow['minuscoast'];

    // Calculate new total income
    $newtotalincome = $coast - $nowcoast;

    // Update the orderproduct record
    $sql = "UPDATE `orderproduct`  SET `productsupply_id`='$productsupply_id', `orderquantity`='$quantity', `orderamount`='$coast', `totalincome`='$newtotalincome' WHERE `order_id` = '$order_id'";
    $query = $conn->query($sql);

    // Check if the query was successful
    if ($query) {
      echo "Order updated successfully.";
    } else {
      echo "Error updating order: " . $conn->error;
    }
  } else {
    echo "No matching order found or error in query.";
  }
}





if (isset($buyBTN)) {
  $productID = $_POST['product_id'];
  $orderID = $_POST['order_id'];

  $fetchdata = "SELECT `orderquantity` AS totalorder, `totalincome` as totalincome FROM `orderproduct` WHERE product_id = $productID AND order_id = $orderID";
  $result = $conn->query($fetchdata);
  $row = $result->fetch_array();
  $totalorder = $row['totalorder'];
  $totalincome = $row['totalincome'];

  $sql = "SELECT `quantity` as total_quantity FROM `product` WHERE `quantity` != 0 AND `product_id`=$productID";
  $result = $conn->query($sql);
  $row = $result->fetch_array();
  $total_quantity = $row['total_quantity'];

  if ($totalorder > $total_quantity) {
    echo json_encode(['status' => 'error', 'message' => 'Not enough available product to complete purchase.']);
    return;
  } else {
    $sql = "UPDATE `orderproduct` SET `status`='Buy', `withdraw_income` = '$totalincome' WHERE `order_id` = '$orderID'";
    $query = $conn->query($sql);
    if ($query) {
      $newQuantity = $total_quantity - $totalorder;
      $sql1 = "UPDATE `product` SET `quantity`='$newQuantity' WHERE `product_id`=$productID";
      $query = $conn->query($sql1);
      echo json_encode(['status' => 'success', 'message' => 'Purchase successful.']);
    }
  }
}


$query = "SELECT ps.productname, SUM(op.orderamount) AS total_sales FROM orderproduct AS op  INNER JOIN productsupply AS ps ON op.productsupply_id = ps.productsupply_id WHERE op.status = 'Buy' GROUP BY ps.productname  ORDER BY total_sales DESC";
$result = $conn->query($query);

// Prepare data for the chart
$labels = [];
$data = [];

while ($row = $result->fetch_assoc()) {
  $labels[] = $row['productname'];
  $data[] = $row['total_sales'];
}

// Encode data as JSON
$labelsJSON = json_encode($labels);
$dataJSON = json_encode($data);


if (isset($_GET['productsupply_id'])) {
  $productsupply_id = $_GET['productsupply_id'];
  $sql = "SELECT * FROM productsupply WHERE productsupply_id = $productsupply_id";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
  } else {
    echo json_encode(['error' => 'No product found']);
  }
}

if (isset($editproductForm)) {
  $sql = "UPDATE `productsupply` SET `productname`='$productname' WHERE productsupply_id = $productsupply_id ";
  $query = $conn->query($sql);
}

if (isset($deleteproductBTN)) {
  $productsupply_id = $_GET['productsupply_id'];
  $sql = "UPDATE `productsupply` SET `productsupply_status`='Deleted' WHERE `productsupply_id` = $productsupply_id";
  $query = $conn->query($sql);
}

if (isset($deleteproductBTNLIST)) {
  $product_id = $_GET['product_id'];
  $sql = "UPDATE `product` SET `product_status`='Deleted' WHERE product_id = $product_id";
  $query = $conn->query($sql);
}

if (isset($misllaneousForm)) {
  $sql = "UPDATE `product` SET `coast`='$coast' WHERE product_id = $product_id ";
  $query = $conn->query($sql);
}


if (isset($withdrawgenfund)) {

  $sql = "SELECT SUM(`gfwithdraw`) as totalAvailable FROM `savings` WHERE `gfwithdraw` != 0";
  $result = $conn->query($sql);
  $row = $result->fetch_array();
  $totalAvailable = $row['totalAvailable'];

  if ($amount > $totalAvailable) {
    echo json_encode(['status' => 'error', 'message' => 'Not enough available Genfund to complete the Withdraw process.']);
    return;
  }

  $totalWithdrawn = 0;

  do {
    $sql = "SELECT * FROM `savings` WHERE `gfwithdraw` != 0 LIMIT 1";
    $result = $conn->query($sql);
    $row = $result->fetch_array();
    $availableAmount = $row['gfwithdraw'];

    if ($amount <= $availableAmount) {
      $totalWithdrawn += $amount;
      $totalamount = $availableAmount - $amount;
      $update = "UPDATE `savings` SET `gfwithdraw`='$totalamount' WHERE `savings_id` = '$row[0]'";
      $upquery = $conn->query($update);
      $amount = 0;
    } else {
      $totalWithdrawn += $availableAmount;
      $newtotalamount = $amount - $availableAmount;
      $update = "UPDATE `savings` SET `gfwithdraw`= 0 WHERE `savings_id` = '$row[0]'";
      $upquery = $conn->query($update);
      $amount = $newtotalamount;
    }
  } while ($amount != 0);

  if ($totalWithdrawn > 0) {
    $insert = "INSERT INTO `withdraw`(`admin`, `amount`, `type`, `date`) VALUES ('Admin', '$totalWithdrawn', 'GenFund', NOW())";
    $inquery = $conn->query($insert);
  }

  echo json_encode(['status' => 'success', 'message' => 'General Fund withdrawal completed successfully!']);
}

if (isset($withdrawcapital)) {

  $sql = "SELECT SUM(`capitalwithdraw`) as totalAvailable FROM `savings` WHERE `capitalwithdraw` != 0";
  $result = $conn->query($sql);
  $row = $result->fetch_array();
  $totalAvailable = $row['totalAvailable'];

  if ($amount > $totalAvailable) {
    echo json_encode(['status' => 'error', 'message' => 'Not enough available Capital to complete the Withdraw process.']);
    return;
  }

  $totalWithdrawn = 0;

  do {
    $sql = "SELECT * FROM `savings` WHERE `capitalwithdraw` != 0 LIMIT 1";
    $result = $conn->query($sql);
    $row = $result->fetch_array();
    $availableAmount = $row['capitalwithdraw'];

    if ($amount <= $availableAmount) {
      $totalWithdrawn += $amount;
      $totalamount = $availableAmount - $amount;
      $update = "UPDATE `savings` SET `capitalwithdraw`='$totalamount' WHERE `savings_id` = '$row[0]'";
      $upquery = $conn->query($update);
      $amount = 0;
    } else {
      $totalWithdrawn += $availableAmount;
      $newtotalamount = $amount - $availableAmount;
      $update = "UPDATE `savings` SET `capitalwithdraw`= 0 WHERE `savings_id` = '$row[0]'";
      $upquery = $conn->query($update);
      $amount = $newtotalamount;
    }
  } while ($amount != 0);

  if ($totalWithdrawn > 0) {
    $insert = "INSERT INTO `withdraw`(`admin`, `amount`, `type`, `date`) VALUES ('Admin', '$totalWithdrawn', 'Capital', NOW())";
    $inquery = $conn->query($insert);
  }

  echo json_encode(['status' => 'success', 'message' => 'Capital withdrawal completed successfully!']);
}


if (isset($withdrawprofit)) {

  $sql = "SELECT SUM(`profitwithdraw`) as totalAvailable FROM `savings` WHERE `profitwithdraw` != 0";
  $result = $conn->query($sql);
  $row = $result->fetch_array();
  $totalAvailable = $row['totalAvailable'];

  if ($amount > $totalAvailable) {
    echo json_encode(['status' => 'error', 'message' => 'Not enough available Profit to complete the Withdraw process.']);
    return;
  }

  $totalWithdrawn = 0;

  do {
    $sql = "SELECT * FROM `savings` WHERE `profitwithdraw` != 0 LIMIT 1";
    $result = $conn->query($sql);
    $row = $result->fetch_array();
    $availableAmount = $row['profitwithdraw'];

    if ($amount <= $availableAmount) {
      $totalWithdrawn += $amount;
      $totalamount = $availableAmount - $amount;
      $update = "UPDATE `savings` SET `profitwithdraw`='$totalamount' WHERE `savings_id` = '$row[0]'";
      $upquery = $conn->query($update);
      $amount = 0;
    } else {
      $totalWithdrawn += $availableAmount;
      $newtotalamount = $amount - $availableAmount;
      $update = "UPDATE `savings` SET `profitwithdraw`= 0 WHERE `savings_id` = '$row[0]'";
      $upquery = $conn->query($update);
      $amount = $newtotalamount;
    }
  } while ($amount != 0);

  if ($totalWithdrawn > 0) {
    $insert = "INSERT INTO `withdraw`(`admin`, `amount`, `type`, `date`) VALUES ('Admin', '$totalWithdrawn', 'Profit', NOW())";
    $inquery = $conn->query($insert);
  }

  echo json_encode(['status' => 'success', 'message' => 'Profit withdrawal completed successfully!']);
}


if (isset($withdrawSales)) {

  $sql = "SELECT SUM(`withdraw_income`) as totalAvailable FROM `orderproduct` WHERE `withdraw_income` != 0";
  $result = $conn->query($sql);
  $row = $result->fetch_array();
  $totalAvailable = $row['totalAvailable'];

  if ($amount > $totalAvailable) {
    echo json_encode(['status' => 'error', 'message' => 'Not enough available Sales Amount to complete the Withdraw process.']);
    return;
  }

  $totalWithdrawn = 0;

  do {
    $sql = "SELECT * FROM `orderproduct` WHERE `withdraw_income` != 0 LIMIT 1";
    $result = $conn->query($sql);
    $row = $result->fetch_array();
    $availableAmount = $row['withdraw_income'];

    if ($amount <= $availableAmount) {
      $totalWithdrawn += $amount;
      $totalamount = $availableAmount - $amount;
      $update = "UPDATE `orderproduct` SET `withdraw_income`='$totalamount' WHERE `order_id` = '$row[0]'";
      $upquery = $conn->query($update);
      $amount = 0;
    } else {
      $totalWithdrawn += $availableAmount;
      $newtotalamount = $amount - $availableAmount;
      $update = "UPDATE `orderproduct` SET `withdraw_income`= 0 WHERE `order_id` = '$row[0]'";
      $upquery = $conn->query($update);
      $amount = $newtotalamount;
    }
  } while ($amount != 0);

  if ($totalWithdrawn > 0) {
    $insert = "INSERT INTO `withdraw`(`admin`, `amount`, `type`, `date`) VALUES ('Admin', '$totalWithdrawn', 'Sales', NOW())";
    $inquery = $conn->query($insert);
  }

  echo json_encode(['status' => 'success', 'message' => 'Sales Amount withdrawal completed successfully!']);
}


