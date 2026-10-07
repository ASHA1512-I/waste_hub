<?php
require_once '../includes/auth.php';
requireRole('citizen');
$user = getUser();

// Get citizen's recent pickups & complaints
$stmt = $pdo->prepare("SELECT * FROM pickups WHERE citizen_id = ? ORDER BY created_at DESC LIMIT 5");
$stmt->execute([$_SESSION['user_id']]);
$pickups = $stmt->fetchAll();

$stmt = $pdo->prepare("SELECT * FROM complaints WHERE citizen_id = ? ORDER BY created_at DESC LIMIT 5");
$stmt->execute([$_SESSION['user_id']]);
$complaints = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citizen Dashboard - Waste Hub</title>
    <meta name="description" content="Track your waste pickup requests and submitted service complaints.">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/png" href="../images/waste hub logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/cookie-consent.js" defer></script>
</head>
<body>
<nav class="navbar navbar-dark bg-success">
    <div class="container-fluid">
        <a class="navbar-brand d-inline-flex align-items-center gap-2" href="dashboard.php"><img class="site-logo" src="../images/waste hub logo.png" alt="Waste Hub logo"><span>Waste Hub</span></a>
        <span class="text-white">Welcome, <?= htmlspecialchars($user['full_name']) ?></span>
        <a href="../config/auth/logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar p-0">
            <a href="dashboard.php" class="active">Dashboard</a>
            <a href="request_pickup.php">Request Pickup</a>
            <a href="submit_complaint.php">Submit Complaint</a>
        </div>
        <div class="col-md-10 p-4">
            <h2 class="mb-4">My Dashboard</h2>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-success text-white">Recent Pickup Requests</div>
                        <div class="card-body">
                            <?php if (empty($pickups)): ?>
                                <p class="text-muted">No pickup requests yet.</p>
                            <?php else: ?>
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($pickups as $p): ?>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span><?= htmlspecialchars($p['requested_date']) ?></span>
                                            <span class="badge bg-<?= $p['status']==='completed'?'success':($p['status']==='pending'?'warning':'info') ?>">
                                                <?= ucfirst($p['status']) ?>
                                            </span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-success text-white">Recent Complaints</div>
                        <div class="card-body">
                            <?php if (empty($complaints)): ?>
                                <p class="text-muted">No complaints submitted.</p>
                            <?php else: ?>
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($complaints as $c): ?>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span><?= htmlspecialchars($c['title']) ?></span>
                                            <span class="badge bg-<?= $c['status']==='resolved'?'success':($c['status']==='open'?'danger':'warning') ?>">
                                                <?= ucfirst(str_replace('_',' ',$c['status'])) ?>
                                            </span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>