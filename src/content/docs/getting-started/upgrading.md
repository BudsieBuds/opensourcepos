---
title: Upgrading Open Source Point of Sale
description: Step-by-step guide to safely upgrading an existing OSPOS installation to a newer release.
---

This guide covers upgrading an existing installation of Open Source Point of Sale (e.g. from 3.4.1 to 3.4.2, or any 3.x release to the latest version).

---

## Understanding Where Data Lives

Upgrading replaces the **application code** with the new release. Your business data and custom configuration are **not** stored in the core application code:

| Component | What Lives There | Needs Backup? |
| :--- | :--- | :---: |
| **Database** | All products, customers, transactions, employees, settings, and logs. | **YES (Critical)** |
| **`.env` file** | Database passwords, `encryption.key`, `throttle.key`, `app.allowedHostnames`. | **YES (Critical)** |
| **`public/uploads/`** | Product images, receipts, and custom store assets. | **YES (Important)** |
| **Application code** | Framework and logic. Replaced entirely during upgrades. | No (can be downloaded) |

Because of this separation, upgrading is straightforward:
$$\text{Back up} \longrightarrow \text{Replace code} \longrightarrow \text{Restore .env and uploads} \longrightarrow \text{Log in}$$

OSPOS handles database migrations **automatically**. You do **not** need to execute manual SQL update scripts.

---

## 1. Pre-Upgrade Backup (MANDATORY)

Before touching any files, create a full backup.

### For Traditional Installs (Linux/Windows)

```bash
# 1. Back up database
mysqldump -u osposuser -p ospos > ~/ospos_backup_$(date +%F).sql

# 2. Back up .env and uploads
cp /var/www/ospos/.env ~/ospos.env.bak
cp -r /var/www/ospos/public/uploads ~/ospos_uploads_bak
```

### For Docker Installs

```bash
# 1. Dump the database container
docker compose exec mysql mysqldump -uadmin -ppointofsale ospos > ospos_db_backup_$(date +%F).sql

# 2. Copy the .env file
cp .env .env.bak
```

:::caution[Protect encryption.key]
Your `.env` file contains `encryption.key`. If this key is lost or regenerated during an upgrade, previously encrypted sensitive data (like stored tokens or credentials) cannot be decrypted.
:::

---

## 2. Upgrading Docker Installations

If you are running OSPOS via Docker Compose, upgrading takes less than a minute:

1. Navigate to your OSPOS folder:
   ```bash
   cd ~/ospos
   ```
2. Pull the latest Docker images:
   ```bash
   docker compose pull
   ```
3. Restart the containers with the new image:
   ```bash
   docker compose up -d
   ```
4. Check the logs to ensure the application started cleanly:
   ```bash
   docker compose logs -f ospos
   ```
5. Open your browser and log in. The database migrations execute automatically.

---

## 3. Upgrading Traditional Installations (Ubuntu / Debian / Apache / Nginx)

1. Download the latest pre-built release zip from [GitHub Releases](https://github.com/opensourcepos/opensourcepos/releases):
   ```bash
   cd /tmp
   curl -s https://api.github.com/repos/opensourcepos/opensourcepos/releases/latest \
     | grep "browser_download_url.*zip" \
     | cut -d : -f 2,3 \
     | tr -d \" \
     | wget -qi -
   ```

2. Temporarily stop your web server (optional, but recommended):
   ```bash
   sudo systemctl stop apache2 # or nginx
   ```

3. Extract the new release into a temporary folder:
   ```bash
   mkdir -p /tmp/ospos_new
   unzip -q opensourcepos*.zip -d /tmp/ospos_new/
   ```

4. Overwrite application code in `/var/www/ospos/`:
   ```bash
   # Copy new files over existing installation
   sudo cp -r /tmp/ospos_new/* /var/www/ospos/
   ```

5. Restore your `.env` and `public/uploads/` (if overwritten):
   ```bash
   sudo cp ~/ospos.env.bak /var/www/ospos/.env
   sudo cp -r ~/ospos_uploads_bak/* /var/www/ospos/public/uploads/
   ```

6. Re-apply correct ownership and permissions:
   ```bash
   sudo chown -R www-data:www-data /var/www/ospos
   sudo chmod -R 775 /var/www/ospos/writable
   sudo chmod -R 775 /var/www/ospos/public/uploads
   ```

7. Restart the web server:
   ```bash
   sudo systemctl start apache2 # or nginx
   ```

8. Open your browser and log in at your store URL. On first login, CodeIgniter 4 runs all pending database migrations in the background.

---

## 4. Post-Upgrade Verification Checklist

After upgrading:
- [ ] Log in with your administrative account.
- [ ] Check the footer: verify the version number matches the newly installed release.
- [ ] Open the **Sales** register and run a quick test cart.
- [ ] Verify that existing product images display properly in the **Items** list.
- [ ] Check **Reports** to confirm past transaction history and cashup records are intact.
- [ ] If any error occurs, inspect the log file at `writable/logs/log-YYYY-MM-DD.php` for details.

---

## 5. Rollback Procedure

If you encounter unexpected issues after an upgrade:
1. Restore your code directory from backup or re-download the previous release zip.
2. Restore your previous `.env` file.
3. If the database schema was modified, restore your database dump:
   ```bash
   mysql -u osposuser -p ospos < ~/ospos_backup_YYYY-MM-DD.sql
   ```
4. Restart your web server or Docker containers.

