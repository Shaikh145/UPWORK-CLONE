<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'client') {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}

$proposal_id = $_POST['proposal_id'];
$action = $_POST['action'];

$status = ($action === 'accept') ? 'accepted' : 'rejected';

$stmt = $pdo->prepare("UPDATE proposals SET status = ? WHERE id = ?");
$stmt->execute([$status, $proposal_id]);

echo "<script>alert('Proposal $status'); window.location.href = 'dashboard_client.php';</script>";
