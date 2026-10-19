---
title: Backup & Disaster Recovery Runbook
description: Automated backup scripts, 3-2-1 backup strategy, and disaster recovery restoration procedures for OSPOS.
---

A hardware failure, corrupted SSD, or ransomware attack on a retail store's checkout counter can halt business immediately. A tested **Disaster Recovery Strategy** ensures your business can resume ringing up customers in minutes.

---

## 1. The 3-2-1 Backup Rule for Retail

Every physical store should follow the industry-standard **3-2-1 Backup Rule**:
- **3 Copies of Data**: 1 live operational database + 2 independent backup archives.
- **2 Different Storage Media**: e.g., local server SSD + USB external drive.
- **1 Off-Site Copy**: A secure cloud backup (AWS S3, Backblaze B2, Google Cloud, or remote VPS) in case of fire, flood, or hardware theft.

---

## 2. Essential Backup Assets

You must back up three components:

1. **MariaDB / MySQL Database**: All historical transactions, inventory quantities, customers, and till cashups.
2. **`.env` Configuration File**: Contains your secret `encryption.key`. *(If this key is lost, encrypted database fields cannot be decrypted).*
3. **`public/uploads/` Folder**: Stored product images, logos, and receipt attachments.

---

## 3. Automated Daily Backup Script (Linux / Traditional)

Create an automated backup script on your server:

```bash
sudo nano /usr/local/bin/backup-ospos.sh
sudo chmod +x /usr/local/bin/backup-ospos.sh
```

Paste the following script:

```bash
#!/bin/bash
set -e

# Configuration
BACKUP_DIR="/var/backups/ospos"
DATE=$(date +%Y-%m-%d_%H%M%S)
DB_NAME="ospos"
DB_USER="osposuser"
DB_PASS="YourSecureDatabasePassword"
OSPOS_DIR="/var/www/ospos"

mkdir -p "$BACKUP_DIR"

echo "[$(date)] Starting OSPOS backup..."

# 1. Dump MariaDB database
mysqldump -u "$DB_USER" -p"$DB_PASS" --single-transaction --quick "$DB_NAME" \
  | gzip > "$BACKUP_DIR/db_${DATE}.sql.gz"

# 2. Archive .env and uploads
tar -czf "$BACKUP_DIR/files_${DATE}.tar.gz" \
  -C "$OSPOS_DIR" .env public/uploads

# 3. Rotate old backups (delete archives older than 30 days)
find "$BACKUP_DIR" -type f -mtime +30 -delete

echo "[$(date)] Backup completed: db_${DATE}.sql.gz and files_${DATE}.tar.gz"
```

### Schedule Daily Automation via Cron

```bash
sudo crontab -e
```

Add an execution entry at 1:30 AM every night:

```bash
30 1 * * * /usr/local/bin/backup-ospos.sh >> /var/log/ospos_backup.log 2>&1
```

---

## 4. Docker Backup Script

If using Docker Compose:

```bash
#!/bin/bash
DATE=$(date +%Y-%m-%d_%H%M%S)
BACKUP_DIR="/opt/backups/ospos"
mkdir -p "$BACKUP_DIR"

# Dump database container
docker compose exec -T mysql mysqldump -uadmin -ppointofsale ospos \
  | gzip > "$BACKUP_DIR/docker_ospos_db_${DATE}.sql.gz"

# Copy secrets and uploads
cp .env "$BACKUP_DIR/env_${DATE}.bak"
docker run --rm -v ospos_uploads:/data -v "$BACKUP_DIR":/backup alpine \
  tar -czf "/backup/docker_uploads_${DATE}.tar.gz" -C /data .
```

---

## 5. Emergency Disaster Recovery (Restoration Runbook)

If your main server fails and you need to restore OSPOS onto replacement hardware:

### Step 1: Provision Replacement Server & Stack
Install Docker or LAMP stack on the replacement machine following the [Installation Guide](/getting-started/installation/).

### Step 2: Restore the Database
```bash
# Decompress and import database dump
gunzip < /path/to/backup/db_YYYY-MM-DD.sql.gz | mysql -u osposuser -p ospos
```

### Step 3: Restore Files & Secrets
```bash
# Restore .env and uploads
tar -xzf /path/to/backup/files_YYYY-MM-DD.tar.gz -C /var/www/ospos/
sudo chown -R www-data:www-data /var/www/ospos/public/uploads /var/www/ospos/.env
```

### Step 4: Verify System Health
1. Open the POS register URL in your browser.
2. Log in and verify that past sales, customer balances, and product images appear correctly.
3. Perform a test cash checkout.
