<?php
session_start();
require_once __DIR__ . '/includes/site_config.php';
// If already logged in, redirect to the correct dashboard
if (isset($_SESSION['user_id'])) {
 $dashboardByRole = [
  'admin' => 'admin/dashboard.php',
  'collector' => 'collector/dashboard.php',
  'citizen' => 'citizen/dashboard.php',
 ];
 if (isset($dashboardByRole[$_SESSION['role'] ?? ''])) {
  header('Location: ' . $dashboardByRole[$_SESSION['role']]);
  exit;
 }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Waste Hub | Smart Waste Collection and Reporting</title>
 <meta name="description" content="Schedule waste pickups, report local waste issues, and follow collection updates with Waste Hub.">
 <link rel="canonical" href="<?= htmlspecialchars($siteUrl . '/index.php', ENT_QUOTES, 'UTF-8') ?>">
 <link rel="icon" type="image/png" href="images/waste hub logo.png">
 <meta property="og:type" content="website">
 <meta property="og:title" content="Waste Hub | Smart Waste Collection and Reporting">
 <meta property="og:description" content="Schedule waste pickups, report local waste issues, and follow collection updates with Waste Hub.">
 <meta property="og:url" content="<?= htmlspecialchars($siteUrl . '/index.php', ENT_QUOTES, 'UTF-8') ?>">
 <meta property="og:image" content="<?= htmlspecialchars($siteUrl . '/images/Waste%20pickers%20on%20landfill%20copy.jpg', ENT_QUOTES, 'UTF-8') ?>">
 <meta property="og:image:alt" content="Waste recovery workers collecting material at a landfill">
 <meta name="twitter:card" content="summary_large_image">
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
 <link rel="stylesheet" href="assets/css/style.css">
 <script src="assets/js/cookie-consent.js" defer></script>
</head>
<body>
 <!-- Navbar -->
 <nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top">
 <div class="container">
 <a class="navbar-brand fw-bold d-inline-flex align-items-center gap-2" href="index.php">
 <img class="site-logo" src="images/waste hub logo.png" alt="Waste Hub logo">
 <span>Waste Hub</span>
 </a>
 <div class="d-flex">
 <a href="config/auth/login.php" class="btn btn-outline-light me-2">Login</a>
 <a href="config/auth/register.php" class="btn btn-light text-success">Register</a>
 </div>
 </div>
 </nav>

 <!-- Hero Section -->
 <section class="hero py-5">
 <div class="container">
 <h1 class="display-4 fw-bold mb-3">Smart Waste Management for a Cleaner City</h1>
 <p class="lead mb-4">Request pickups, report issues, and track waste collection all in one place.</p>
 <a href="config/auth/register.php" class="btn btn-light btn-lg text-success me-2">Get Started</a>
 <a href="config/auth/login.php" class="btn btn-outline-light btn-lg">Login</a>
 </div>
 </section>

 <!-- Features -->
 <section class="py-5">
 <div class="container">
 <div class="row text-center g-4">
 <div class="col-md-4 feature-item">
 <img class="feature-image" src="images/GARBAGE.jpg" alt="Waste collection crew working beside a collection truck" loading="lazy">
 <h4>Easy Pickup Requests</h4>
 <p>Citizens can schedule waste collection with just a few clicks.</p>
 </div>
 <div class="col-md-4 feature-item">
 <img class="feature-image" src="images/plastics.jpg" alt="Workers sorting and collecting recyclable plastics" loading="lazy">
 <h4>Complaint Reporting</h4>
 <p>Report overflowing bins or illegal dumping with photo evidence.</p>
 </div>
 <div class="col-md-4 feature-item">
 <img class="feature-image" src="images/gathering waste.jpg" alt="Waste recovery workers handling collected material" loading="lazy">
 <h4>Real-time Tracking</h4>
 <p>Admins and collectors manage schedules and update status live.</p>
 </div>
 </div>
 </div>
 </section>

 <!-- Footer -->
 <footer class="bg-dark text-white text-center py-4">
 <div class="container">
 <p class="mb-0">&copy; <?= date('Y') ?> Waste Hub. All rights reserved.</p>
 <p class="mt-2 mb-0"><a class="text-white" href="privacy.php">Privacy policy</a><span class="mx-2">|</span><a class="text-white" href="terms.php">Terms &amp; conditions</a></p>
 </div>
 </footer>
</body>
</html>