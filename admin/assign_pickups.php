<?php
require_once '../includes/auth.php';
requireRole('admin');

$success = '';

// Assign collector
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pickup_id'])) {
    $pickup_id = (int)$_POST['pickup_id'];
    $collector_id = (int)$_POST['collector_id'];
    $stmt = $pdo->prepare("UPDATE pickups SET collector_id=?, status='assigned', assigned_at=NOW() WHERE id=?");
    $stmt->execute([$collector_id, $pickup_id]);
    $success = 'Pickup assigned successfully!';
}

// Pending pickups
$pending = $pdo->query("SELECT p.*, u.full_name, u.phone 
                        FROM pickups p 
                        JOIN users u ON p.citizen_id = u.id 
                        WHERE p.status = 'pending' 
                        ORDER BY p.created_at ASC")->fetchAll();

// Collectors list
$collectors = $pdo->query("SELECT id, full_name FROM users WHERE role='collector'")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assign Pickups - Waste Hub</title>
    <meta name="description" content="Review pickup requests and assign waste collection work to collectors.">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/png" href="../images/waste hub logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/cookie-consent.js" defer></script>
</head>
<body>
<nav class="navbar navbar-dark bg-success">
    <div class="container-fluid">
        <a class="navbar-brand d-inline-flex align-items-center gap-2" href="dashboard.php"><img class="site-logo" src="../images/waste hub logo.png" alt="Waste Hub logo"><span>Waste Hub Admin</span></a>
        <a href="../config/auth/logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
</nav>

<div class="container py-4">
    <h2 class="mb-4">Assign Pickups to Collectors</h2>
    <?php if ($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>

    <?php if (empty($pending)): ?>
        <div class="alert alert-info">No pending pickup requests.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-success">
                    <tr>
                        <th>Citizen</th>
                        <th>Date</th>
                        <th>Phone</th>
                        <th>Notes</th>
                        <th>Assign To</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pending as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['full_name']) ?></td>
                            <td><?= htmlspecialchars($p['requested_date']) ?></td>
                            <td><?= htmlspecialchars($p['phone']) ?></td>
                            <td><?= htmlspecialchars($p['notes'] ?: '-') ?></td>
                            <td>
                                <form method="POST" class="d-flex gap-2">
                                    <input type="hidden" name="pickup_id" value="<?= $p['id'] ?>">
                                    <select name="collector_id" class="form-select form-select-sm" required>
                                        <option value="">Select Collector</option>
                                        <?php foreach ($collectors as $c): ?>
                                            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['full_name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-success">Assign</button>
                                </form>
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