<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'freelancer') {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}

$freelancer_id = $_SESSION['user']['id'];

// Fetch all jobs for applying
$jobs = $pdo->query("SELECT * FROM jobs ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

// Fetch submitted proposals & status
$stmt = $pdo->prepare("SELECT proposals.*, jobs.title FROM proposals JOIN jobs ON proposals.job_id = jobs.id WHERE proposals.freelancer_id = ?");
$stmt->execute([$freelancer_id]);
$proposals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Freelancer Dashboard - ProWork</title>
    <style>
        body { background: #f0fdf4; font-family: sans-serif; padding: 30px; }
        h2 { text-align: center; color: #047857; }
        .job, .proposal {
            background: white;
            padding: 20px;
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        .job a {
            background: #047857;
            padding: 8px 14px;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 10px;
            display: inline-block;
        }
        .status {
            font-weight: bold;
            padding: 6px 10px;
            border-radius: 6px;
        }
        .accepted { color: #065f46; }
        .rejected { color: #b91c1c; }
        .pending { color: #d97706; }
    </style>
</head>
<body>

<h2>Available Jobs</h2>
<?php foreach ($jobs as $job): ?>
    <div class="job">
        <h3><?= htmlspecialchars($job['title']) ?></h3>
        <p><?= htmlspecialchars($job['description']) ?></p>
        <p><strong>Budget:</strong> PKR <?= $job['budget'] ?> | <strong>Deadline:</strong> <?= $job['deadline'] ?></p>
        <a href="apply_job.php?job_id=<?= $job['id'] ?>">Apply</a>
    </div>
<?php endforeach; ?>

<h2>Your Proposals</h2>
<?php foreach ($proposals as $p): ?>
    <div class="proposal">
        <h4><?= htmlspecialchars($p['title']) ?></h4>
        <p><?= htmlspecialchars($p['cover_letter']) ?></p>
        <p><strong>Bid:</strong> PKR <?= $p['bid_amount'] ?></p>
        <p>Status: 
            <span class="status <?= $p['status'] ?>">
                <?= ucfirst($p['status']) ?>
            </span>
        </p>
    </div>
<?php endforeach; ?>

</body>
</html>
