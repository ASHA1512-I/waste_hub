<?php require_once __DIR__ . '/includes/site_config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms &amp; Conditions - Waste Hub</title>
    <meta name="description" content="Review the terms for using Waste Hub accounts, pickup requests, and waste-service reports.">
    <link rel="canonical" href="<?= htmlspecialchars($siteUrl . '/terms.php', ENT_QUOTES, 'UTF-8') ?>">
    <link rel="icon" type="image/png" href="images/waste hub logo.png">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Terms &amp; Conditions - Waste Hub">
    <meta property="og:description" content="Terms for using Waste Hub accounts, pickup requests, and service reports.">
    <meta property="og:url" content="<?= htmlspecialchars($siteUrl . '/terms.php', ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:image" content="<?= htmlspecialchars($siteUrl . '/images/Waste%20pickers%20on%20landfill%20copy.jpg', ENT_QUOTES, 'UTF-8') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/cookie-consent.js" defer></script>
</head>
<body>
<nav class="navbar navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand fw-bold d-inline-flex align-items-center gap-2" href="index.php">
            <img class="site-logo" src="images/waste hub logo.png" alt="Waste Hub logo">
            <span>Waste Hub</span>
        </a>
        <a class="btn btn-outline-light" href="index.php">Home</a>
    </div>
</nav>
<main class="container py-5 legal-content">
    <h1 class="mb-2">Terms &amp; Conditions</h1>
    <p class="text-muted mb-4">Last updated: October 7, 2026</p>

    <h2 class="h4 mt-4">Using Waste Hub</h2>
    <p>Waste Hub provides tools for account holders to submit waste pickup requests and service complaints, and for authorized staff to manage those requests. By using the service, you agree to these terms and to the <a href="privacy.php">Privacy Policy</a>.</p>

    <h2 class="h4 mt-4">Accounts and accurate information</h2>
    <p>Provide accurate information and keep your sign-in details private. You are responsible for activity under your account and should promptly tell the service administrator if you believe it has been accessed without permission.</p>

    <h2 class="h4 mt-4">Requests and reports</h2>
    <p>Submit truthful, relevant pickup requests and complaints. Do not upload unlawful, abusive, or unrelated content, or content you do not have permission to share. A submitted request is not a guarantee of a particular collection time; availability and completion depend on the service operator's schedules and operational capacity.</p>

    <h2 class="h4 mt-4">Acceptable use</h2>
    <p>Do not misuse the service, interfere with its operation, attempt to access another person's account or data, or use it in a way that violates applicable law. The operator may restrict or suspend access where necessary to protect users or the service.</p>

    <h2 class="h4 mt-4">Availability and changes</h2>
    <p>The service is provided as available and may be changed, interrupted, or discontinued. Nothing in these terms limits rights or remedies that cannot be excluded under applicable law.</p>

    <h2 class="h4 mt-4">Contact and updates</h2>
    <p>For questions about these terms, contact your local Waste Hub administrator. The operator may update these terms; continued use after a revised version is posted is subject to the updated terms, to the extent permitted by law.</p>
</main>
<footer class="bg-dark text-white text-center py-4">
    <a class="text-white" href="index.php">Waste Hub home</a>
    <span class="mx-2">|</span>
    <a class="text-white" href="privacy.php">Privacy policy</a>
</footer>
</body>
</html>