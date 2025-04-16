<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'client') {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $budget = $_POST['budget'];
    $deadline = $_POST['deadline'];
    $client_id = $_SESSION['user']['id'];

    $stmt = $pdo->prepare("INSERT INTO jobs (client_id, title, description, budget, deadline) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$client_id, $title, $description, $budget, $deadline]);

    echo "<script>alert('Job Posted Successfully!'); window.location.href = 'dashboard_client.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Post Job - ProWork</title>
    <style>
        body { background: #f0fdf4; font-family: Arial; }
        .form-container {
            max-width: 500px;
            margin: 60px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        }
        h2 { text-align: center; color: #047857; }
        input, textarea {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border-radius: 10px;
            border: 1px solid #ccc;
        }
        button {
            width: 100%;
            background: #047857;
            color: white;
            padding: 12px;
            margin-top: 20px;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Post a New Job</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Job Title" required />
        <textarea name="description" placeholder="Job Description" required></textarea>
        <input type="number" name="budget" placeholder="Budget (PKR)" required />
        <input type="date" name="deadline" required />
        <button type="submit">Post Job</button>
    </form>
</div>

</body>
</html>
