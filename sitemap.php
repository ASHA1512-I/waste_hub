<?php
require_once __DIR__ . '/includes/site_config.php';
header('Content-Type: application/xml; charset=utf-8');
$pages = ['/index.php', '/privacy.php', '/terms.php'];
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($pages as $page): ?>
    <url>
        <loc><?= htmlspecialchars($siteUrl . $page, ENT_XML1 | ENT_QUOTES, 'UTF-8') ?></loc>
    </url>
<?php endforeach; ?>
</urlset>