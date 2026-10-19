---
title: Common Errors & Solutions
description: Solutions for common installation, routing, session, and web server issues in Open Source Point of Sale.
---

This guide covers common issues and error messages encountered when installing, configuring, or running Open Source Point of Sale.

---

## 1. "System folder missing"

### Symptom
When opening OSPOS in your browser, an error message states:
```text
Your system folder path does not appear to be set correctly.
```

### Cause
This occurs when you clone the raw Git repository directly instead of downloading the official pre-built release package. The raw Git repository does not contain third-party PHP dependencies (Composer packages) or compiled frontend assets.

### Solution
- **If you are an end user**: Download the official pre-built release archive (`opensourcepos.202x.x.x.zip`) from [GitHub Releases](https://github.com/opensourcepos/opensourcepos/releases).
- **If you are a developer**: Follow the [Developer Build Guide](/developer/environment/) and run:
  ```bash
  composer install
  npm install
  npm run build
  ```

---

## 2. "RuntimeException: Security: allowedHostnames is not configured"

### Symptom
The application crashes with:
```text
RuntimeException: Security: allowedHostnames is not configured.
```

### Cause
To protect against HTTP Host Header Injection vulnerabilities, OSPOS requires a strict domain whitelist in production.

### Solution
Open your `.env` file and set `app.allowedHostnames` to your domain:

```ini
app.allowedHostnames = 'pos.yourdomain.com,localhost'
```
*(Do not include `http://`, `https://`, or port numbers).*

---

## 3. 404 Not Found on All Pages Except the Homepage

### Symptom
The homepage loads, but clicking any link (like `/sales` or `/items`) returns a `404 Not Found` error.

### Cause
URL rewriting is not functioning on your web server.

### Solution for Apache
1. Enable `mod_rewrite`:
   ```bash
   sudo a2enmod rewrite
   ```
2. Open your VirtualHost configuration (`/etc/apache2/sites-available/ospos.conf`) and ensure `AllowOverride All` is enabled:
   ```apache
   <Directory /var/www/ospos/public>
       AllowOverride All
       Require all granted
   </Directory>
   ```
3. Restart Apache:
   ```bash
   sudo systemctl restart apache2
   ```

### Solution for Nginx
Ensure your Nginx configuration contains the URL rewrite directive:
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

---

## 4. Blank White Screen / HTTP 500 Internal Server Error

### Cause
A fatal PHP error occurred, but error display is suppressed in production mode.

### How to Diagnose:
Inspect the CodeIgniter log files located in:
```bash
cat /var/www/ospos/writable/logs/log-$(date +%Y-%m-%d).php
```
Look for lines starting with `CRITICAL` or `ERROR`. Common causes include:
- Missing PHP extensions (e.g. `php-intl`, `php-gd`, `php-bcmath`).
- Incorrect file permissions on the `writable/` directory.

### Fix Permissions:
```bash
sudo chown -R www-data:www-data /var/www/ospos
sudo chmod -R 775 /var/www/ospos/writable
sudo chmod -R 775 /var/www/ospos/public/uploads
```

---

## 5. Logged Out Immediately After Logging In

### Symptom
Entering valid credentials appears to succeed, but you are instantly redirected back to the login screen.

### Cause
Session cookie misconfiguration or HTTP/HTTPS mismatch.

### Solution
1. If you are accessing OSPOS over HTTP (without SSL), ensure `FORCE_HTTPS = false` in `.env`.
2. If accessing over HTTPS behind a reverse proxy (e.g., Cloudflare, Traefik, Nginx), ensure `FORCE_HTTPS = true` in `.env`.
3. Check that your browser is not blocking third-party session cookies.

