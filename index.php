<?php
session_start();
include 'db.php';

$jobs = $pdo->query("SELECT jobs.*, users.name FROM jobs JOIN users ON jobs.client_id = users.id ORDER BY jobs.id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>ProWork - Freelance Marketplace</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f0fdf4; }
        header { background: #047857; color: white; padding: 20px; text-align: center; }
        .buttons a { color: white; margin: 0 10px; text-decoration: none; font-weight: bold; }
        .container { padding: 30px; }
        .job { background: white; border-radius: 12px; padding: 20px; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .job h3 { margin: 0; color: #047857; }
        .filter { margin-bottom: 20px; }
        select { padding: 8px; border-radius: 8px; border: 1px solid #ccc; }
    </style>
</head>
<body>

<header>
    <h1>Welcome to ProWork</h1>
    <div class="buttons">
        <a href="signup.php">Signup</a> | 
        <a href="login.php">Login</a> | 
        <a href="logout.php">Logout</a>
    </div>
</header>

<div class="container">
    <div class="filter">
        <label>Filter by Category:</label>
        <select onchange="filterCategory(this.value)">
            <option value="">All</option>
            <option value="Design">Design</option>
            <option value="Writing">Writing</option>
            <option value="Development">Development</option>
        </select>
    </div>

    <div id="jobList">
        <?php foreach ($jobs as $job): ?>
            <div class="job" data-category="<?= htmlspecialchars($job['title']) ?>">
                <h3><?= htmlspecialchars($job['title']) ?></h3>
                <p><?= nl2br(htmlspecialchars($job['description'])) ?></p>
                <p><strong>Budget:</strong> $<?= $job['budget'] ?> | <strong>Deadline:</strong> <?= $job['deadline'] ?></p>
                <p><strong>Posted by:</strong> <?= htmlspecialchars($job['name']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    function filterCategory(category) {
        let jobs = document.querySelectorAll('.job');
        jobs.forEach(job => {
            if (!category || job.getAttribute('data-category').includes(category)) {
                job.style.display = 'block';
            } else {
                job.style.display = 'none';
            }
        });
    }
</script>

</body>
</html>
