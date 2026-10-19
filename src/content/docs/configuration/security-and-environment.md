---
title: Security, Hostnames & .env
description: Hardening your Open Source Point of Sale installation, configuring allowedHostnames, and managing encryption keys.
---

Because point-of-sale systems handle customer payment records, transactions, and inventory data, securing your production deployment is critical.

---

## 1. Allowed Hostnames (MANDATORY in Production)

:::caution[CRITICAL SECURITY REQUIREMENT]
OpenSourcePOS validates the incoming HTTP `Host` header against a strict whitelist to prevent **Host Header Injection** and cache poisoning vulnerabilities. 

**You MUST configure `app.allowedHostnames` in your `.env` file before launching in production.** If not configured, the application will refuse to start and throw a `RuntimeException`.
:::

### Configuration

Add your domain name(s) as a comma-separated list in `.env`:

```ini
# Production domain(s) - do NOT include http://, https://, or ports
app.allowedHostnames = 'pos.yourdomain.com,checkout.yourdomain.com'

# For local development workstations:
app.allowedHostnames = 'localhost'
```

If deploying via Docker Compose, you can pass this via the environment variable:

```yaml
environment:
  - ALLOWED_HOSTNAMES=pos.yourdomain.com
```

---

## 2. Enforcing HTTPS / SSL

Running your checkout over unencrypted HTTP exposes cashier sessions and customer information to network eavesdropping.

When running behind an SSL-terminating reverse proxy (Cloudflare, Nginx, Traefik, AWS ALB), instruct OSPOS to generate secure `https://` URLs:

```ini
FORCE_HTTPS = true
```

---

## 3. Cryptographic Keys & Startup Provisioning

OSPOS uses two 256-bit encryption keys stored in `.env`:

1. **`encryption.key`**: Used by CodeIgniter's Encrypter service to encrypt sensitive stored tokens and secrets.
2. **`throttle.key`**: Used by the rate limiter to track and throttle failed login attempts and protect against brute-force password guessing.

### Automatic Provisioning via CLI
OSPOS includes a built-in CLI command to provision keys and migrate legacy CodeIgniter 3 cipher data:

```bash
php spark env:provision
```

In Docker/Compose deployments where `.env` may be mounted read-only, you can inject these keys via container environment variables:

```yaml
environment:
  - ENCRYPTION_KEY=${ENCRYPTION_KEY}
  - THROTTLE_KEY=${THROTTLE_KEY}
```

### Generating Keys Manually
If you need to generate a new 256-bit key manually:

```bash
openssl rand -hex 32
```

Add to `.env`:

```ini
encryption.key = 'hex2bin:your_64_character_hex_string_here'
throttle.key = 'hex2bin:your_64_character_hex_string_here'
```

:::warning[Do Not Rotate encryption.key Carelessly]
If you change or delete `encryption.key`, any existing data in the database that was encrypted with the old key will become permanently unreadable! Always back up your `.env` file.
:::

---

## 4. Single Sign-On (SSO) & Demo Deployment Hardening

For public demo sites or enterprise deployments where user authentication and permissions are managed upstream via LDAP, Active Directory, or an SSO identity provider:

```ini
# When true, disables the "change password" feature for all employees
DISALLOW_PASSWORD_CHANGE = true

# When true, disables changing employee grants/permissions and blocks creating new employees with grants
DISALLOW_GRANT_CHANGE = true
```

---

## 5. Honeypot Anti-Spam Protection

To block automated bot submissions on public-facing forms (such as customer registration or message portals), OSPOS includes a built-in honeypot trap:

```ini
honeypot.hidden = true
honeypot.label = 'Fill This Field'
honeypot.name = 'honeypot'
honeypot.template = '<label>{label}</label><input type="text" name="{name}" value="">'
honeypot.container = '<div style="display:none">{template}</div>'
```

---

## 6. System Logging & Audit Thresholds

Configure system logging depth in `.env`:

```ini
# 0 = Disabled, 1 = Emergency, 2 = Alert, 3 = Critical, 4 = Runtime Errors,
# 5 = Warnings, 6 = Notices, 7 = Info, 8 = Debug, 9 = All Messages
logger.threshold = 4

# Toggle SQL database query logging
app.db_log_enabled = false
```

---

## 7. Content Security Policy (CSP) & Session Security

OSPOS includes headers designed to block cross-site scripting (XSS) and clickjacking attacks:

- **Strict Content Security Policy (CSP)**: Restricts scripts and styles from executing unless permitted.
- **Secure Cookie Flags**: Session cookies are configured with:
  - `HttpOnly = true` (Inaccessible to malicious client-side JavaScript).
  - `SameSite = Lax` (Protects against Cross-Site Request Forgery / CSRF).
  - `Secure = true` (Transmitted strictly over HTTPS).

---

## 8. Automated Daily Database Backups

Set up an automated daily backup cron job so your business can recover from hardware failure or accidental data deletion:

```bash
# Open crontab editor
sudo crontab -e
```

Add a daily backup scheduled at 2:00 AM:

```bash
0 2 * * * mysqldump -u osposuser -p'YourPassword' ospos | gzip > /var/backups/ospos/ospos_$(date +\%F).sql.gz
```


