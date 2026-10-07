<?php
require_once '../includes/auth.php';
requireRole('admin');
$user = getUser();

// Dashboard Statistics
$pickupsThisMonth = $pdo->query("SELECT COUNT(*) FROM pickups WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())")->fetchColumn();
$pendingPickups   = $pdo->query("SELECT COUNT(*) FROM pickups WHERE status = 'pending'")->fetchColumn();
$completedPickups = $pdo->query("SELECT COUNT(*) FROM pickups WHERE status = 'completed'")->fetchColumn();
$openComplaints   = $pdo->query("SELECT COUNT(*) FROM complaints WHERE status = 'open'")->fetchColumn();
$totalCitizens    = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'citizen'")->fetchColumn();
$totalCollectors  = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'collector'")->fetchColumn();
$totalBins        = $pdo->query("SELECT COUNT(*) FROM bins")->fetchColumn();
$fullBins         = $pdo->query("SELECT COUNT(*) FROM bins WHERE status IN ('full', 'overflow')")->fetchColumn();

// Recent pickups
$recentPickups = $pdo->query("
    SELECT p.*, u.full_name 
    FROM pickups p 
    JOIN users u ON p.citizen_id = u.id 
    ORDER BY p.created_at DESC 
    LIMIT 6
")->fetchAll();

// Recent complaints
$recentComplaints = $pdo->query("
    SELECT c.*, u.full_name 
    FROM complaints c 
    JOIN users u ON c.citizen_id = u.id 
    ORDER BY c.created_at DESC 
    LIMIT 5
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Waste Hub</title>
    <meta name="description" content="View service activity and manage Waste Hub operations.">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/png" href="../images/waste hub logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/cookie-consent.js" defer></script>
    <style>
        .stat-card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-3px);
        }
        .stat-icon {
            font-size: 2rem;
            opacity: 0.8;
        }
    </style>
</head>
<body>
<!-- Top Navbar -->
<nav class="navbar navbar-dark bg-success">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold d-inline-flex align-items-center gap-2" href="dashboard.php"><img class="site-logo" src="../images/waste hub logo.png" alt="Waste Hub logo"><span>Waste Hub Admin</span></a>
        <div class="d-flex align-items-center">
            <span class="text-white me-3">Welcome, <?= htmlspecialchars($user['full_name']) ?></span>
            <a href="../config/auth/logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar p-0">
            <a href="dashboard.php" class="active">Dashboard</a>
            <a href="assign_pickups.php">Assign Pickups</a>
            <a href="manage_complaints.php">Complaints</a>
            <a href="manage_users.php">Manage Users</a>
            <a href="manage_bins.php">Manage Bins</a>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 p-4">
            <h2 class="mb-4">Dashboard Overview</h2>

            <!-- Stats Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card stat-card p-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-muted mb-1">Pickups This Month</h6>
                                <h3 class="mb-0"><?= $pickupsThisMonth ?></h3>
                            </div>
                            <div class="stat-icon text-success">📅</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card p-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-muted mb-1">Pending Pickups</h6>
                                <h3 class="mb-0 text-warning"><?= $pendingPickups ?></h3>
                            </div>
                            <div class="stat-icon text-warning">⏳</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card p-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-muted mb-1">Open Complaints</h6>
                                <h3 class="mb-0 text-danger"><?= $openComplaints ?></h3>
                            </div>
                            <div class="stat-icon text-danger">📢</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card p-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-muted mb-1">Full / Overflow Bins</h6>
                                <h3 class="mb-0 text-danger"><?= $fullBins ?></h3>
                            </div>
                            <div class="stat-icon text-danger">🗑️</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Secondary Stats -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card p-3 text-center">
                        <h5 class="text-muted">Total Citizens</h5>
                        <h3><?= $totalCitizens ?></h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 text-center">
                        <h5 class="text-muted">Total Collectors</h5>
                        <h3><?= $totalCollectors ?></h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 text-center">
                        <h5 class="text-muted">Total Bins</h5>
                        <h3><?= $totalBins ?></h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 text-center">
                        <h5 class="text-muted">Completed Pickups</h5>
                        <h3 class="text-success"><?= $completedPickups ?></h3>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Recent Pickups -->
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                            <span>Recent Pickup Requests</span>
                            <a href="assign_pickups.php" class="btn btn-sm btn-light">View All</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Citizen</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($recentPickups)): ?>
                                            <tr><td colspan="3" class="text-center text-muted py-3">No pickups yet</td></tr>
                                        <?php else: ?>
                                            <?php foreach ($recentPickups as $p): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($p['full_name']) ?></td>
                                                    <td><?= date('d M Y', strtotime($p['requested_date'])) ?></td>
                                                    <td>
                                                        <?php
                                                        $badgeClass = match($p['status']) {
                                                            'pending'   => 'warning',
                                                            'assigned'  => 'info',
                                                            'completed' => 'success',
                                                            default     => 'secondary'
                                                        };
                                                        ?>
                                                        <span class="badge bg-<?= $badgeClass ?>">
                                                            <?= ucfirst($p['status']) ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Complaints -->
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                            <span>Recent Complaints</span>
                            <a href="manage_complaints.php" class="btn btn-sm btn-light">View All</a>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                <?php if (empty($recentComplaints)): ?>
                                    <li class="list-group-item text-center text-muted py-3">No complaints yet</li>
                                <?php else: ?>
                                    <?php foreach ($recentComplaints as $c): ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong><?= htmlspecialchars($c['title']) ?></strong><br>
                                                <small class="text-muted"><?= htmlspecialchars($c['full_name']) ?></small>
                                            </div>
                                            <?php
                                            $cBadge = match($c['status']) {
                                                'open'        => 'danger',
                                                'in_progress' => 'warning',
                                                'resolved'    => 'success',
                                                default       => 'secondary'
                                            };
                                            ?>
                                            <span class="badge bg-<?= $cBadge ?>">
                                                <?= ucfirst(str_replace('_', ' ', $c['status'])) ?>
                                            </span>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>