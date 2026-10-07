<?php
require_once '../includes/auth.php';
requireRole('admin');
$user = getUser();

$success = $error = '';

// Add / Edit user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
 $full_name = trim($_POST['full_name']);
 $username = trim($_POST['username']);
 $email = trim($_POST['email']);
 $role = $_POST['role'];
 $phone = trim($_POST['phone'] ?? '');
 $address = trim($_POST['address'] ?? '');
 $password = $_POST['password'] ?? '';

 if (empty($full_name) || empty($username) || empty($email) || empty($role)) {
 $error = 'Please fill all required fields.';
 } else {
 try {
 if ($id > 0) {
 // Update
 if (!empty($password)) {
 $hashed = password_hash($password, PASSWORD_DEFAULT);
 $stmt = $pdo->prepare("UPDATE users SET full_name=?, username=?, email=?, role=?, phone=?, address=?, password=? WHERE id=?");
 $stmt->execute([$full_name, $username, $email, $role, $phone, $address, $hashed, $id]);
 } else {
 $stmt = $pdo->prepare("UPDATE users SET full_name=?, username=?, email=?, role=?, phone=?, address=? WHERE id=?");
 $stmt->execute([$full_name, $username, $email, $role, $phone, $address, $id]);
 }
 $success = 'User updated successfully!';
 } else {
 // Create
 if (empty($password)) {
 $error = 'Password is required for new users.';
 } else {
 $hashed = password_hash($password, PASSWORD_DEFAULT);
 $stmt = $pdo->prepare("INSERT INTO users (full_name, username, email, password, role, phone, address) VALUES (?,?,?,?,?,?,?)");
 $stmt->execute([$full_name, $username, $email, $hashed, $role, $phone, $address]);
 $success = 'User created successfully!';
 }
 }
 } catch (PDOException $e) {
 $error = 'Username or email already exists.';
 }
 }
}

// Delete user
if (isset($_GET['delete'])) {
 $id = (int)$_GET['delete'];
 if ($id != $_SESSION['user_id']) { // prevent self-delete
 $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
 $stmt->execute([$id]);
 $success = 'User deleted successfully!';
 } else {
 $error = 'You cannot delete your own account.';
 }
}

// Fetch all users
$users = $pdo->query("SELECT * FROM users ORDER BY role, full_name")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>Manage Users - Waste Hub</title>
 <meta name="description" content="Manage Waste Hub user accounts and service roles.">
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

<div class="container-fluid">
 <div class="row">
 <div class="col-md-2 sidebar p-0">
 <a href="dashboard.php">Dashboard</a>
 <a href="assign_pickups.php">Assign Pickups</a>
 <a href="manage_complaints.php">Complaints</a>
 <a href="manage_users.php" class="active">Manage Users</a>
 <a href="manage_bins.php">Manage Bins</a>
 </div>

 <div class="col-md-10 p-4">
 <div class="d-flex justify-content-between align-items-center mb-4">
 <h2>User Management</h2>
 <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#userModal" onclick="resetForm()">
 + Add New User
 </button>
 </div>

 <?php if ($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
 <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>

 <div class="table-responsive">
 <table class="table table-bordered table-hover">
 <thead class="table-success">
 <tr>
 <th>Name</th>
 <th>Username</th>
 <th>Email</th>
 <th>Role</th>
 <th>Phone</th>
 <th>Actions</th>
 </tr>
 </thead>
 <tbody>
 <?php foreach ($users as $u): ?>
 <tr>
 <td><?= htmlspecialchars($u['full_name']) ?></td>
 <td><?= htmlspecialchars($u['username']) ?></td>
 <td><?= htmlspecialchars($u['email']) ?></td>
 <td>
 <span class="badge bg-<?= $u['role']==='admin'?'danger':($u['role']==='collector'?'primary':'secondary') ?>">
 <?= ucfirst($u['role']) ?>
 </span>
 </td>
 <td><?= htmlspecialchars($u['phone'] ?: '-') ?></td>
 <td>
 <button class="btn btn-sm btn-outline-primary"
 onclick='editUser(<?= json_encode($u) ?>)'>
 Edit
 </button>
 <?php if ($u['id'] != $_SESSION['user_id']): ?>
 <a href="?delete=<?= $u['id'] ?>" class="btn btn-sm btn-outline-danger"
 onclick="return confirm('Delete this user?')">Delete</a>
 <?php endif; ?>
 </td>
 </tr>
 <?php endforeach; ?>
 </tbody>
 </table>
 </div>
 </div>
 </div>
</div>

<!-- Add / Edit Modal -->
<div class="modal fade" id="userModal" tabindex="-1">
 <div class="modal-dialog">
 <form method="POST" class="modal-content">
 <div class="modal-header">
 <h5 class="modal-title" id="modalTitle">Add New User</h5>
 <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
 </div>
 <div class="modal-body">
 <input type="hidden" name="id" id="userId">
 <div class="mb-3">
 <label class="form-label">Full Name *</label>
 <input type="text" name="full_name" id="full_name" class="form-control" required>
 </div>
 <div class="mb-3">
 <label class="form-label">Username *</label>
 <input type="text" name="username" id="username" class="form-control" required>
 </div>
 <div class="mb-3">
 <label class="form-label">Email *</label>
 <input type="email" name="email" id="email" class="form-control" required>
 </div>
 <div class="mb-3">
 <label class="form-label">Role *</label>
 <select name="role" id="role" class="form-select" required>
 <option value="citizen">Citizen</option>
 <option value="collector">Collector</option>
 <option value="admin">Admin</option>
 </select>
 </div>
 <div class="mb-3">
 <label class="form-label">Phone</label>
 <input type="text" name="phone" id="phone" class="form-control">
 </div>
 <div class="mb-3">
 <label class="form-label">Address</label>
 <textarea name="address" id="address" class="form-control" rows="2"></textarea>
 </div>
 <div class="mb-3">
 <label class="form-label">Password <small class="text-muted">(leave blank to keep current)</small></label>
 <input type="password" name="password" id="password" class="form-control">
 </div>
 </div>
 <div class="modal-footer">
 <button type="submit" class="btn btn-success">Save User</button>
 </div>
 </form>
 </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function resetForm() {
 document.getElementById('modalTitle').innerText = 'Add New User';
 document.getElementById('userId').value = '';
 document.getElementById('full_name').value = '';
 document.getElementById('username').value = '';
 document.getElementById('email').value = '';
 document.getElementById('role').value = 'citizen';
 document.getElementById('phone').value = '';
 document.getElementById('address').value = '';
 document.getElementById('password').value = '';
 document.getElementById('password').required = true;
}

function editUser(u) {
 document.getElementById('modalTitle').innerText = 'Edit User';
 document.getElementById('userId').value = u.id;
 document.getElementById('full_name').value = 