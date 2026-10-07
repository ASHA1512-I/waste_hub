<?php
require_once '../includes/auth.php';
requireRole('admin');

$success = '';

// Update status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['complaint_id'];
    $status = $_POST['status'];
    $notes = trim($_POST['admin_notes'] ?? '');
    $stmt = $pdo->prepare("UPDATE complaints SET status=?, admin_notes=? WHERE id=?");
    $stmt->execute([$status, $notes, $id]);
    $success = 'Complaint updated!';
}

$complaints = $pdo->query("SELECT c.*, u.full_name 
                           FROM complaints c 
                           JOIN users u ON c.citizen_id = u.id 
                           ORDER BY c.created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Complaints - Waste Hub</title>
    <meta name="description" content="Review citizen waste complaints, attached photos, and resolution status.">
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
    <h2 class="mb-4">Manage Complaints</h2>
    <?php if ($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-success">
                <tr>
                    <th>Citizen</th>
                    <th>Title</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($complaints as $c): ?>
                    <tr>
                        <td><?= htmlspecialchars($c['full_name']) ?></td>
                        <td><?= htmlspecialchars($c['title']) ?></td>
                        <td><?= htmlspecialchars($c['location'] ?: '-') ?></td>
                        <td>
                            <span class="badge bg-<?= $c['status']==='resolved'?'success':($c['status']==='open'?'danger':'warning') ?>">
                                <?= ucfirst(str_replace('_',' ',$c['status'])) ?>
                            </span>
                        </td>
                        <td><?= date('d M Y', strtotime($c['created_at'])) ?></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal<?= $c['id'] ?>">
                                Update
                            </button>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="modal<?= $c['id'] ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Update Complaint</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong><?= htmlspecialchars($c['title']) ?></strong></p>
                                        <p><?= nl2br(htmlspecialchars($c['description'])) ?></p>
                                        <?php if ($c['photo']): ?>
                                            <img src="../uploads/<?= htmlspecialchars($c['photo']) ?>" alt="Photo attached to complaint: <?= htmlspecialchars($c['title']) ?>" class="img-fluid mb-3" style="max-height:200px">
                                        <?php endif; ?>
                                        <input type="hidden" name="complaint_id" value="<?= $c['id'] ?>">
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select">
                                                <option value="open" <?= $c['status']==='open'?'selected':'' ?>>Open</option>
                                                <option value="in_progress" <?= $c['status']==='in_progress'?'selected':'' ?>>In Progress</option>
                                                <option value="resolved" <?= $c['status']==='resolved'?'selected':'' ?>>Resolved</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Admin Notes</label>
                                            <textarea name="admin_notes" class="form-control" rows="2"><?= htmlspecialchars($c['admin_notes'] ?? '') ?></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>