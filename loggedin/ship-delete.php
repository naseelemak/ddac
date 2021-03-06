<?php

require '../config.php';

$id = $_GET['id'];

$stmt = $conn->prepare('SELECT * FROM `shipments` WHERE `id` = ?');
$stmt->bind_param('i', $id);

// Execute query
$stmt->execute();

// Get the result
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$stmt = $conn->prepare('DELETE FROM `shipments` WHERE `id` = ?');
$stmt->bind_param('s', $id);

// Execute query
$stmt->execute();

// Get the result
$result = $stmt->get_result();

echo "<script>alert('Shipment entry deleted successfully!'); window.location.replace('ship.php');</script>";

?>

