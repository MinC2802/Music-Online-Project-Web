<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../logout.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../db.php';

    $id = $_POST['id'];
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];
    $is_retailer = $_POST['is_retailer'] ?? 0;

    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, role = ?, is_retailer = ? WHERE id = ?");
    $stmt->bind_param("sssii", $username, $email, $role, $is_retailer, $id);


    if ($stmt->execute()) {
        header("Location: manageUsers.php?message=User+updated+successfully");
        exit();
    } else {
        die("Failed to update user.");
    }
}
?>
