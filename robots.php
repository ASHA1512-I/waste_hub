<?php
require_once __DIR__ . '/includes/site_config.php';
header('Content-Type: text/plain; charset=utf-8');
?>
User-agent: *
Allow: /
Disallow: /config/
Sitemap: <?= htmlspecialchars($siteUrl . '/sitemap.xml', ENT_QUOTES, 'UTF-8') ?>