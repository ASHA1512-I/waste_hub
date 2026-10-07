<?php require_once __DIR__ . '/includes/site_config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - Waste Hub</title>
    <meta name="description" content="Learn what account, pickup, and complaint information Waste Hub collects and how it is used and protected.">
    <link rel="canonical" href="<?= htmlspecialchars($siteUrl . '/privacy.php', ENT_QUOTES, 'UTF-8') ?>">
    <link rel="icon" type="image/png" href="images/waste hub logo.png">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Privacy Policy - Waste Hub">
    <meta property="og:description" content="How Waste Hub handles account, pickup, and complaint information.">
    <meta property="og:url" content="<?= htmlspecialchars($siteUrl . '/privacy.php', ENT_QUOTES, 'UTF-8') ?>">
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
    <h1 class="mb-2">Privacy Policy</h1>
    <p class="text-muted mb-4">Last updated: October 7, 2026</p>

    <h2 class="h4 mt-4">Information we collect</h2>
    <p>When you create an account, Waste Hub stores your name, username, email address, password hash, and any phone number or address you provide. When you use the service, we store pickup requests and their status, and complaint titles, descriptions, locations, and any photos you submit.</p>

    <h2 class="h4 mt-4">How we use information</h2>
    <p>We use this information to operate accounts, schedule and manage waste pickups, respond to complaints, and maintain service records. Authorized administrators can access information needed to manage the service. Collection staff may receive the contact and location details needed to complete an assigned pickup.</p>

    <h2 class="h4 mt-4">Cookies and browser storage</h2>
    <p>Waste Hub uses essential session cookies to keep you signed in and protect account workflows. The site does not use analytics or advertising cookies. Your cookie preference is stored in your browser's local storage so the notice does not reappear after you choose. You can clear cookies and site storage in your browser settings; signing in may then require a new session.</p>

    <h2 class="h4 mt-4">Service providers and sharing</h2>
    <p>Information is shared only with authorized service staff who need it to provide or administer Waste Hub, or when disclosure is required by law. The site loads the Bootstrap interface library from jsDelivr, whose servers may receive standard connection information such as your IP address and browser details when the page loads.</p>

    <h2 class="h4 mt-4">Retention and security</h2>
    <p>Records are kept for as long as needed to operate the service, meet administrative requirements, and address service issues. Passwords are stored as hashes. The operator should secure the hosting environment and configure HTTPS before accepting real account information.</p>

    <h2 class="h4 mt-4">Your choices and questions</h2>
    <p>You may ask the service administrator to review or correct your account information or to explain applicable deletion options. Privacy rights depend on the laws that apply where the service operates. Contact your local Waste Hub administrator with a privacy request or question.</p>

    <h2 class="h4 mt-4">Changes to this policy</h2>
    <p>This policy may be updated as the service changes. The updated date above indicates the latest revision.</p>

    <p class="mt-5"><a href="terms.php">Read the Terms &amp; Conditions</a></p>
</main>
<footer class="bg-dark text-white text-center py-4">
    <a class="text-white" href="index.php">Waste Hub home</a>
    <span class="mx-2">|</span>
    <a class="text-white" href="terms.php">Terms &amp; conditions</a>
</footer>
</body>
</html>