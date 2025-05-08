<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'plms');
$conn->set_charset("utf8");
extract($_POST);
extract($_GET);

if (isset($_POST['confirmationEditMember'])) {
  $sql = "SELECT * FROM `admin` WHERE `admin_pass` = '$admin_pass'";
  $query = $conn->query($sql);

  if ($query->num_rows > 0) {
    echo '1';
  } else {
    echo '2';
  }
}

if (isset($_POST['confirmationDeleteMember'])) {
  $sql = "SELECT * FROM `admin` WHERE `admin_pass` = '$admin_pass'";
  $query = $conn->query($sql);

  if ($query->num_rows > 0) {
    echo '1';
  } else {
    echo '2';
  }
}

if (isset($_POST['confirmationAddFunds'])) {
  $sql = "SELECT * FROM `admin` WHERE `admin_pass` = '$admin_pass'";
  $query = $conn->query($sql);

  if ($query->num_rows > 0) {
    echo '1';
  } else {
    echo '2';
  }
}
if (isset($_POST['confirmationEditFunds'])) {
  $sql = "SELECT * FROM `admin` WHERE `admin_pass` = '$admin_pass'";
  $query = $conn->query($sql);

  if ($query->num_rows > 0) {
    echo '1';
  } else {
    echo '2';
  }
}
if (isset($_POST['confirmationLoan'])) {
  $sql = "SELECT * FROM `admin` WHERE `admin_pass` = '$admin_pass'";
  $query = $conn->query($sql);

  if ($query->num_rows > 0) {
    echo '1';
  } else {
    echo '2';
  }
}
if (isset($_POST['confirmationLoanEdit'])) {
  $sql = "SELECT * FROM `admin` WHERE `admin_pass` = '$admin_pass'";
  $query = $conn->query($sql);

  if ($query->num_rows > 0) {
    echo '1';
  } else {
    echo '2';
  }
}
if (isset($_POST['confirmationViewLoan'])) {
  $sql = "SELECT * FROM `admin` WHERE `admin_pass` = '$admin_pass'";
  $query = $conn->query($sql);

  if ($query->num_rows > 0) {
    echo '1';
  } else {
    echo '2';
  }
}
if (isset($_POST['confirmationViewfunds'])) {
  $sql = "SELECT * FROM `admin` WHERE `admin_pass` = '$admin_pass'";
  $query = $conn->query($sql);

  if ($query->num_rows > 0) {
    echo '1';
  } else {
    echo '2';
  }
}
if (isset($_POST['confirmationreference'])) {
  $sql = "SELECT * FROM `monthly_payment` WHERE `reference_payment` = '$reference_payment'";
  $query = $conn->query($sql);

  if ($query->num_rows > 0) {
    echo '1';
  } else {
    echo '2';
  }
}
