<?php

require '../config.php';

$id = $_GET['id'];

$stmt = $conn->prepare('SELECT * FROM `customers` WHERE `id` = ?');
$stmt->bind_param('i', $id);

// Execute query
$stmt->execute();

// Get the result
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$stmt = $conn->prepare('DELETE FROM `customers` WHERE `id` = ?');
$stmt->bind_param('s', $id);

// Execute query
$stmt->execute();

// Get the result
$result = $stmt->get_result();

echo "<script>alert('Customer deleted successfully!'); window.location.replace('cust.php');</script>";

?>

