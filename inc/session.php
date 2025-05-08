<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'plms');
$checkAdminQuery = "SELECT COUNT(*) as count FROM `admin`";
$result = $conn->query($checkAdminQuery);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
  header('Location: ../index.php');
  exit();
}

if (!isset($_SESSION['admin_id'])) {
  header('Location: ../index.php');
  exit();
}

$admin_id = $_SESSION['admin_id'];
