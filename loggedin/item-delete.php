<?php

require '../config.php';

$id = $_GET['id'];

$stmt = $conn->prepare('SELECT * FROM `items` WHERE `id` = ?');
$stmt->bind_param('i', $id);

// Execute query
$stmt->execute();

// Get the result
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$stmt = $conn->prepare('DELETE FROM `items` WHERE `id` = ?');
$stmt->bind_param('s', $id);

// Execute query
$stmt->execute();

// Get the result
$result = $stmt->get_result();

echo "<script>alert('Item deleted successfully!'); window.location.replace('item.php');</script>";

?>

