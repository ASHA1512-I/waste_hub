<?php
require_once '../includes/auth.php';
requireRole('collector');
$user = getUser();

// Assigned pickups
$stmt = $pdo->prepare("SELECT p.*, u.full_name, u.phone, u.address 
                       FROM pickups p 
                       JOIN users u ON p.citizen_id = u.id 
                       WHERE p.collector_id = ? AND p.status IN ('assigned','in_progress')
                       ORDER BY p.requested_date ASC");
$stmt->execute([$_SESSION['user_id']]);
$assigned = $stmt->fetchAll();

// Mark as completed
if (isset($_GET['complete'])) {
    $id = (int)$_GET['complete'];
    $stmt = $pdo->prepare("UPDATE pickups SET status='completed', completed_at=NOW() WHERE id=? AND collector_id=?");
    $stmt->execute([$id, $_SESSION['user_id']]);
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Collector Dashboard - Waste Hub</title>
    <meta name="description" content="View assigned waste pickups and update collection progress.">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/png" href="../images/waste hub logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/cookie-consent.js" defer></script>
</head>
<body>
<nav class="navbar navbar-dark bg-success">
    <div class="container-fluid">
        <a class="navbar-brand d-inline-flex align-items-center gap-2" href="dashboard.php"><img class="site-logo" src="../images/waste hub logo.png" alt="Waste Hub logo"><span>Waste Hub - Collector</span></a>
        <span class="text-white">Welcome, <?= htmlspecialchars($user['full_name']) ?></span>
        <a href="../config/auth/logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
</nav>

<div class="container py-4">
    <h2 class="mb-4">My Assigned Pickups</h2>

    <?php if (empty($assigned)): ?>
        <div class="alert alert-info">No active pickups assigned to you.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-success">
                    <tr>
                        <th>Date</th>
                        <th>Citizen</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($assigned as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['requested_date']) ?></td>
                            <td><?= htmlspecialchars($p['full_name']) ?></td>
                            <td><?= htmlspecialchars($p['phone']) ?></td>
                            <td><?= htmlspecialchars($p['address']) ?></td>
                            <td><?= htmlspecialchars($p['preferred_time'] ?: 'Any') ?></td>
                            <td><span class="badge bg-info"><?= ucfirst($p['status']) ?></span></td>
                            <td>
                                <a href="?complete=<?= $p['id'] ?>" class="btn btn-sm btn-success"
                                   onclick="return confirm('Mark this pickup as completed?')">
                                    Mark Completed
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
</body>
</html>