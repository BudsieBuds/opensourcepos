---
title: Windows Installation (XAMPP / WSL)
description: Run Open Source Point of Sale on Windows using Docker Desktop, WSL2, or XAMPP.
---

Running Open Source Point of Sale on Windows is popular for single-store checkout counters, offline local testing, and training environments.

There are two primary approaches for Windows:
1. **Docker Desktop with WSL2** (Recommended: cleanest setup, zero environment conflicts).
2. **XAMPP / WAMP** (Traditional Windows all-in-one Apache/PHP/MySQL package).

---

## Method 1: Docker Desktop with WSL2 (Recommended)

Docker on Windows provides a production-identical Linux environment without managing PHP extensions or web server configurations manually.

1. Install [Docker Desktop for Windows](https://www.docker.com/products/docker-desktop/) with the WSL2 backend enabled.
2. Open PowerShell or Windows Terminal and create a project directory:
   ```powershell
   mkdir C:\ospos
   cd C:\ospos
   ```
3. Download the Compose file:
   ```powershell
   Invoke-WebRequest -Uri https://raw.githubusercontent.com/opensourcepos/opensourcepos/master/docker-compose.yml -OutFile docker-compose.yml
   ```
4. Create an empty `.env` file:
   ```powershell
   New-Item -ItemType File -Name .env
   ```
5. Start the containers:
   ```powershell
   docker compose up -d
   ```
6. Open your browser at `http://localhost` and log in with `admin` / `pointofsale`.

---

## Method 2: XAMPP for Windows

If you prefer a direct Windows installation using XAMPP:

### 1. Install XAMPP with PHP 8.2 or 8.3
Download and install [XAMPP for Windows](https://www.apachefriends.org/) with PHP 8.2 or later (installed to `C:\xampp` by default).

### 2. Enable Required PHP Extensions
Open `C:\xampp\php\php.ini` in a text editor (e.g., Notepad++ or VS Code) and ensure the following extensions are uncommented (remove the leading `;` if present):

```ini
extension=bcmath
extension=curl
extension=gd
extension=intl
extension=mbstring
extension=openssl
extension=pdo_mysql
extension=mysqli
```

Save the file and restart Apache from the XAMPP Control Panel.

### 3. Create the Database
1. Open the XAMPP Control Panel and start **Apache** and **MySQL**.
2. Click **Admin** next to MySQL to open phpMyAdmin (`http://localhost/phpmyadmin`).
3. Click **New** and create a database named `ospos` with Collation `utf8mb4_unicode_ci`.

### 4. Extract OSPOS
1. Download the latest release zip (`opensourcepos.202x.x.x.zip`) from GitHub Releases.
2. Extract the contents into `C:\xampp\htdocs\ospos`.

### 5. Configure `.env`
1. In `C:\xampp\htdocs\ospos`, copy `.env.example` and rename it to `.env`.
2. Open `.env` and set:
   ```ini
   CI_ENVIRONMENT = production
   app.allowedHostnames = 'localhost'

   database.default.hostname = 'localhost'
   database.default.database = 'ospos'
   database.default.username = 'root'
   database.default.password = ''
   database.default.DBDriver = 'MySQLi'
   database.default.DBPrefix = 'ospos_'
   ```

### 6. Configure Apache VirtualHost

:::caution[CRITICAL]
Do not serve OSPOS directly from `http://localhost/ospos/` without pointing the web root to `/public`. If Apache serves the root folder, URLs will break and internal configuration files could be exposed.
:::

Open `C:\xampp\apache\conf\extra\httpd-vhosts.conf` and add:

```apache
<VirtualHost *:80>
    ServerName ospos.local
    DocumentRoot "C:/xampp/htdocs/ospos/public"
    <Directory "C:/xampp/htdocs/ospos/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Add the domain to your Windows hosts file (`C:\Windows\System32\drivers\etc\hosts`) running as Administrator:

```text
127.0.0.1 ospos.local
```

Restart Apache in the XAMPP Control Panel.

### 7. Access OSPOS
Open your browser and visit:
```text
http://ospos.local
```
Log in using:
- **Username**: `admin`
- **Password**: `pointofsale`

---

## Windows Troubleshooting

- **Port 80 Conflict**: If Apache fails to start in XAMPP, port 80 may be blocked by IIS or World Wide Web Publishing Service. Stop IIS or change Apache port to `8080` in `httpd.conf`.
- **`ext-intl` missing error**: Ensure `extension=intl` is enabled in `C:\xampp\php\php.ini` and that the Apache service was restarted.
- **`allowedHostnames is not configured`**: Ensure `app.allowedHostnames = 'localhost,ospos.local'` exists in your `.env` file.

