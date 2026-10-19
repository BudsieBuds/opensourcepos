---
title: Traditional Server Installation
description: Install Open Source Point of Sale on Ubuntu/Debian Linux using Apache or Nginx and MariaDB.
---

This guide covers installing Open Source Point of Sale directly on a Linux server (Ubuntu 24.04 LTS or 22.04 LTS) using a standard LAMP (Linux, Apache, MariaDB, PHP) or LEMP (Linux, Nginx, MariaDB, PHP) stack.

:::note[Pre-built Release vs Source Code]
Always download the **pre-built release archive** (`opensourcepos.202x.x.x.zip`) from GitHub Releases. The raw Git repository does not contain compiled vendor libraries or frontend assets. If you clone the repository from Git, you must follow the [Developer Build Workflow](/developer/environment/).
:::

---

## 1. System Packages & Prerequisites

Update your package index and install required utilities:

```bash
sudo apt update && sudo apt upgrade -y
sudo apt install -y curl unzip git software-properties-common
```

---

## 2. Install MariaDB Server

Install MariaDB and secure the installation:

```bash
sudo apt install -y mariadb-server mariadb-client
sudo mysql_secure_installation
```

Log in to the MariaDB shell:

```bash
sudo mysql -u root -p
```

Create the database and a dedicated user:

```sql
CREATE DATABASE ospos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'osposuser'@'localhost' IDENTIFIED BY 'StrongPasswordHere123!';
GRANT ALL PRIVILEGES ON ospos.* TO 'osposuser'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

---

## 3. Install PHP 8.2 or 8.3 & Extensions

Install PHP and all required extensions:

```bash
sudo apt install -y \
  php \
  php-cli \
  php-fpm \
  php-mysql \
  php-bcmath \
  php-curl \
  php-gd \
  php-intl \
  php-mbstring \
  php-xml \
  php-zip
```

Verify your PHP version:

```bash
php -v
# Output should show PHP 8.2 or PHP 8.3
```

---

## 4. Download and Install OSPOS

Create the web directory and download the latest pre-built release:

```bash
sudo mkdir -p /var/www/ospos
cd /tmp

# Download the latest release (replace URL with latest release asset from GitHub)
curl -s https://api.github.com/repos/opensourcepos/opensourcepos/releases/latest \
  | grep "browser_download_url.*zip" \
  | cut -d : -f 2,3 \
  | tr -d \" \
  | wget -qi -

# Unzip to destination
sudo unzip -q opensourcepos*.zip -d /var/www/ospos/
```

### Configure File Ownership & Permissions

The web server user (`www-data`) must own the application directory, particularly `writable/` and `public/uploads/`:

```bash
sudo chown -R www-data:www-data /var/www/ospos
sudo chmod -R 755 /var/www/ospos
sudo chmod -R 775 /var/www/ospos/writable
sudo chmod -R 775 /var/www/ospos/public/uploads
```

---

## 5. Configure Environment Variables (`.env`)

Copy the example environment file:

```bash
cd /var/www/ospos
sudo cp .env.example .env
sudo chown www-data:www-data .env
sudo chmod 640 .env
```

Open `.env` in your editor:

```bash
sudo nano .env
```

Configure the essential settings:

```ini
# Set environment
CI_ENVIRONMENT = production

# CRITICAL SECURITY: Hostname whitelist (comma-separated, no protocols or ports)
app.allowedHostnames = 'pos.yourshop.com,localhost'

# Database Connection
database.default.hostname = 'localhost'
database.default.database = 'ospos'
database.default.username = 'osposuser'
database.default.password = 'StrongPasswordHere123!'
database.default.DBDriver = 'MySQLi'
database.default.DBPrefix = 'ospos_'

# Force HTTPS if using SSL certificate
FORCE_HTTPS = true
```

:::caution[CRITICAL: allowedHostnames]
`app.allowedHostnames` is **required in production**. If omitted or left blank, OpenSourcePOS will halt execution with a `RuntimeException: Security: allowedHostnames is not configured` error to protect against HTTP Host Header injection attacks.
:::

---

## 6. Web Server Configuration

:::important[DocumentRoot Must Point to `/public`]
OpenSourcePOS uses CodeIgniter 4's secure public web root pattern. **Your web server DocumentRoot MUST point to `/var/www/ospos/public`**, NOT `/var/www/ospos`. Pointing to the root directory exposes application source code and breaks asset routing.
:::

### Option A: Apache 2.4 Setup

Enable Apache rewrite module:

```bash
sudo a2enmod rewrite headers
```

Create a VirtualHost configuration:

```bash
sudo nano /etc/apache2/sites-available/ospos.conf
```

Paste the following:

```apache
<VirtualHost *:80>
    ServerName pos.yourshop.com
    DocumentRoot /var/www/ospos/public

    <Directory /var/www/ospos/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/ospos_error.log
    CustomLog ${APACHE_LOG_DIR}/ospos_access.log combined
</VirtualHost>
```

Enable the site and restart Apache:

```bash
sudo a2ensite ospos.conf
sudo a2dissite 000-default.conf # Optional: disable default page
sudo systemctl restart apache2
```

---

### Option B: Nginx Setup

If using Nginx with PHP-FPM:

```bash
sudo nano /etc/nginx/sites-available/ospos
```

Paste the following server block:

```nginx
server {
    listen 80;
    server_name pos.yourshop.com;
    root /var/www/ospos/public;
    index index.php index.html;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock; # Check your PHP version socket
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\. {
        deny all;
    }

    location ~* \.(jpg|jpeg|gif|png|css|js|ico|xml|svg|woff2)$ {
        expires 30d;
        add_header Cache-Control "public, no-transform";
    }
}
```

Enable the site and test configuration:

```bash
sudo ln -s /etc/nginx/sites-available/ospos /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

---

## 7. Enable SSL / HTTPS (Certbot)

Secure your installation with a free Let's Encrypt certificate:

```bash
sudo apt install -y certbot python3-certbot-apache # Or python3-certbot-nginx
sudo certbot --apache -d pos.yourshop.com
```

---

## 8. First Login

Open your browser and navigate to `https://pos.yourshop.com`. 

On first load, OSPOS will automatically run initial database migrations to populate the schema.

Log in with:
- **Username**: `admin`
- **Password**: `pointofsale`

Next, proceed to [First Steps & Initial Store Setup](/getting-started/first-steps/).

