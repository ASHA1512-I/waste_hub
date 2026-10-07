<?php
$configuredSiteUrl = getenv('SITE_URL');
$requestScheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$serverName = $_SERVER['SERVER_NAME'] ?? 'localhost';
$serverPort = (int) ($_SERVER['SERVER_PORT'] ?? ($requestScheme === 'https' ? 443 : 80));
$defaultPort = $requestScheme === 'https' ? 443 : 80;
$portSuffix = $serverPort !== $defaultPort ? ":$serverPort" : '';
$scriptDirectory = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
$basePath = $scriptDirectory === '/' || $scriptDirectory === '.' ? '' : $scriptDirectory;
$siteUrl = rtrim($configuredSiteUrl ?: "$requestScheme://$serverName$portSuffix$basePath", '/');
?>