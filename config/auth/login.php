<?php
require_once __DIR__ . '/../db.php';
session_start();

$error = '';
$loginOptions = [
    'citizen' => 'Resident',
    'collector' => 'Collection team',
    'admin' => 'Operations',
];
$loginDescriptions = [
    'citizen' => 'a resident',
    'collector' => 'a collection team member',
    'admin' => 'an operations user',
];
$selectedRole = 'citizen';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';
    $selectedRole = $_POST['role'] ?? 'citizen';
    if (!isset($loginOptions[$selectedRole])) {
        $selectedRole = 'citizen';
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$login, $login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password']) && $user['role'] === $selectedRole) {
        $dashboardByRole = [
            'admin' => '../../admin/dashboard.php',
            'collector' => '../../collector/dashboard.php',
            'citizen' => '../../citizen/dashboard.php',
        ];

        if (isset($dashboardByRole[$user['role']])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['full_name'] = $user['full_name'];
            header('Location: ' . $dashboardByRole[$user['role']]);
            exit;
        } else {
            $error = 'This account has no valid dashboard role.';
        }
    }

    if (!$error) {
        $error = 'The email, password, or selected access type is incorrect.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Waste Hub</title>
    <meta name="description" content="Sign in to Waste Hub to manage waste pickup requests and service reports.">
    <link rel="icon" type="image/png" href="../../images/waste hub logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <script src="../../assets/js/cookie-consent.js" defer></script>
</head>
<body class="auth-page">
<main class="auth-layout">
    <section class="auth-visual" aria-label="Waste Hub community">
        <div class="auth-visual-content">
            <p class="auth-kicker"><span></span> Better together</p>
            <h1>Small actions.<br><span>Cleaner places.</span></h1>
            <p class="auth-visual-caption">One shared space for the people who keep our communities moving.</p>
        </div>
    </section>
    <section class="auth-panel">
        <div class="auth-form-wrap">
            <a class="auth-back" href="../../index.php"><span aria-hidden="true">&larr;</span> Back to home</a>
            <p class="auth-eyebrow"><?= htmlspecialchars($loginOptions[$selectedRole]) ?> access</p>
            <h2>Sign in as <?= htmlspecialchars($loginDescriptions[$selectedRole]) ?></h2>
            <p class="auth-intro">Report waste, attach a photo, and track local service.</p>

            <?php if ($error): ?>
                <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" class="auth-form">
                <fieldset class="auth-role-picker">
                    <legend class="visually-hidden">Choose your access type</legend>
                    <?php foreach ($loginOptions as $role => $label): ?>
                        <label class="auth-role-option">
                            <input class="visually-hidden" type="radio" name="role" value="<?= htmlspecialchars($role) ?>" <?= $selectedRole === $role ? 'checked' : '' ?>>
                            <span><?= htmlspecialchars($label) ?></span>
                        </label>
                    <?php endforeach; ?>
                </fieldset>

                <div class="auth-field">
                    <label for="login">Email address or username</label>
                    <input id="login" type="text" name="login" class="form-control" placeholder="you@example.com" autocomplete="username" value="<?= htmlspecialchars($_POST['login'] ?? '') ?>" required>
                </div>

                <div class="auth-field">
                    <label for="password">Password</label>
                    <div class="auth-password-wrap">
                        <input id="password" type="password" name="password" class="form-control" placeholder="Enter your password" autocomplete="current-password" required>
                        <button class="auth-password-toggle" type="button" aria-controls="password" aria-pressed="false">Show</button>
                    </div>
                </div>

                <button type="submit" class="auth-submit">
                    <span>Sign in as <?= htmlspecialchars(strtolower($loginOptions[$selectedRole])) ?></span>
                    <span aria-hidden="true">&rarr;</span>
                </button>
            </form>

            <p class="auth-register">New to Waste Hub? <a href="register.php">Create an account</a></p>
            <div class="auth-legal">
                <a href="../../privacy.php">Privacy policy</a>
                <a href="../../terms.php">Terms &amp; conditions</a>
            </div>
        </div>
    </section>
</main>
<script>
document.querySelectorAll('input[name="role"]').forEach((option) => {
    option.addEventListener('change', () => {
        const roleNames = {
            citizen: 'a resident',
            collector: 'a collection team member',
            admin: 'an operations user',
        };
        const label = option.nextElementSibling.textContent;
        document.querySelector('.auth-eyebrow').textContent = `${option.nextElementSibling.textContent} access`;
        document.querySelector('.auth-panel h2').textContent = `Sign in as ${roleNames[option.value]}`;
        document.querySelector('.auth-submit span:first-child').textContent = `Sign in as ${label.toLowerCase()}`;
    });
});

document.querySelector('.auth-password-toggle').addEventListener('click', (event) => {
    const button = event.currentTarget;
    const password = document.getElementById('password');
    const isVisible = password.type === 'text';
    password.type = isVisible ? 'password' : 'text';
    button.textContent = isVisible ? 'Show' : 'Hide';
    button.setAttribute('aria-pressed', String(!isVisible));
});
</script>
</body>
</html>