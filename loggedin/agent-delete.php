<?php

require '../config.php';

$username = base64_decode($_GET['username']);

$stmt = $conn->prepare('SELECT * FROM `agents` WHERE username = ?');
$stmt->bind_param('i', $username);

// Execute query
$stmt->execute();

// Get the result
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$stmt = $conn->prepare('DELETE FROM `agents` WHERE username = ?');
$stmt->bind_param('s', $username);

// Execute query
$stmt->execute();

// Get the result
$result = $stmt->get_result();

echo "<script>alert('Agent deleted successfully!'); window.location.replace('agent.php');</script>";

?>

