<?php


$stmt = $conn->prepare('SELECT * FROM `posts` WHERE id = ?');
$stmt->bind_param('i', $_GET['id']);

// Execute query
$stmt->execute();

// Get the result
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$stmt = $conn->prepare('DELETE FROM `posts` WHERE id = ?');
$stmt->bind_param('i', $_GET['id']);

// Execute query
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Delete the image file
unlink($row['poster']);

echo "<script>alert('Post deleted successfully!'); window.location.replace(agents.phpp');</script>";

?>

