<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'client') {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}

$client_id = $_SESSION['user']['id'];

$stmt = $pdo->prepare("SELECT jobs.id AS job_id, jobs.title, proposals.*, users.name AS freelancer_name 
    FROM jobs 
    JOIN proposals ON jobs.id = proposals.job_id 
    JOIN users ON proposals.freelancer_id = users.id 
    WHERE jobs.client_id = ?");
$stmt->execute([$client_id]);
$proposals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Client Dashboard - ProWork</title>
    <style>
        body { background: #ecfdf5; font-family: sans-serif; padding: 30px; }
        h2 { text-align: center; color: #065f46; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 40px;
            background: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        button {
            padding: 8px 16px;
            border: none;
            background: #047857;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            margin-right: 10px;
        }
        button.reject { background: #dc2626; }
    </style>
</head>
<body>

<h2>Client Dashboard - View Proposals</h2>

<table>
    <tr>
        <th>Job Title</th>
        <th>Freelancer</th>
        <th>Cover Letter</th>
        <th>Bid</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php foreach ($proposals as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['freelancer_name']) ?></td>
            <td><?= htmlspecialchars($row['cover_letter']) ?></td>
            <td>PKR <?= $row['bid_amount'] ?></td>
            <td><?= ucfirst($row['status']) ?></td>
            <td>
                <?php if ($row['status'] == 'pending'): ?>
                    <form method="post" action="process_proposal.php" style="display:inline;">
                        <input type="hidden" name="proposal_id" value="<?= $row['id'] ?>">
                        <input type="hidden" name="action" value="accept">
                        <button type="submit">Accept</button>
                    </form>
                    <form method="post" action="process_proposal.php" style="display:inline;">
                        <input type="hidden" name="proposal_id" value="<?= $row['id'] ?>">
                        <input type="hidden" name="action" value="reject">
                        <button class="reject" type="submit">Reject</button>
                    </form>
                <?php else: ?>
                    <?= ucfirst($row['status']) ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
