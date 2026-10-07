# Waste Hub setup

Configure these environment variables in the PHP/Apache service before opening account pages:

- `DB_HOST` (defaults to `localhost`)
- `DB_NAME` (defaults to `wastehub`)
- `DB_USER`
- `DB_PASSWORD`
- `SITE_URL` (the public HTTPS origin, for example `https://waste.example.org`; include a subdirectory if the app is not installed at the domain root)

On localhost only, missing `DB_USER` and `DB_PASSWORD` default to the common development setup (`root` with an empty password). Set both variables when your local MySQL credentials differ. On every non-local host, both variables are required; credentials are not sent to the browser. Create an administrator account by registering a user and assigning the `admin` role directly in the database.

For production, serve the site through Apache with `mod_rewrite` and `mod_authz_core` enabled. The root `.htaccess` redirects public HTTP requests to HTTPS and maps `/robots.txt` and `/sitemap.xml` to their dynamic PHP endpoints. Localhost is exempt from the HTTPS redirect. Configure a valid TLS certificate before accepting account information.