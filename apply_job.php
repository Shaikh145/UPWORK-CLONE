<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'freelancer') {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}

$job_id = $_GET['job_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cover_letter = $_POST['cover_letter'];
    $bid_amount = $_POST['bid_amount'];
    $freelancer_id = $_SESSION['user']['id'];

    $stmt = $pdo->prepare("INSERT INTO proposals (job_id, freelancer_id, cover_letter, bid_amount) VALUES (?, ?, ?, ?)");
    $stmt->execute([$job_id, $freelancer_id, $cover_letter, $bid_amount]);

    echo "<script>alert('Proposal Submitted!'); window.location.href = 'dashboard_freelancer.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Apply for Job - ProWork</title>
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
        textarea, input {
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
    <h2>Submit Your Proposal</h2>
    <form method="POST">
        <textarea name="cover_letter" placeholder="Write your cover letter..." required></textarea>
        <input type="number" name="bid_amount" placeholder="Your Bid Amount (PKR)" required />
        <button type="submit">Send Proposal</button>
    </form>
</div>

</body>
</html>
