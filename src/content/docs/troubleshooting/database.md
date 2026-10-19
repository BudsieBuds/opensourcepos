---
title: Database & Migration Troubleshooting
description: Diagnose database connection failures, MariaDB/MySQL strict mode issues, and schema migration errors.
---

Database connectivity and schema health are fundamental to Open Source Point of Sale. This guide covers diagnosing and fixing common database errors.

---

## 1. Database Connection Failures

### "Access denied for user 'ospos'@'localhost'"
- **Cause**: Incorrect database username or password in `.env`.
- **Fix**: Verify database credentials:
  ```bash
  # Test connection via CLI
  mysql -u osposuser -p ospos
  ```
  Ensure the values match `database.default.username` and `database.default.password` in `.env`.

### "Connection Refused / Can't connect to local MySQL server"
- **Cause**: MariaDB/MySQL service is stopped or listening on a different port/socket.
- **Fix**:
  ```bash
  # Check service status
  sudo systemctl status mariadb # or mysql

  # Start service if stopped
  sudo systemctl start mariadb
  ```
- **If using Docker**: Ensure the `mysql` container is running and healthy:
  ```bash
  docker compose ps
  docker compose logs mysql
  ```

---

## 2. MySQL 8.0 `ONLY_FULL_GROUP_BY` Errors

### Symptom
Complex reports or inventory summaries fail with:
```text
Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column... which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by
```

### Solution
Configure MySQL/MariaDB to use a compatible SQL mode:

1. Open your MySQL configuration file:
   ```bash
   sudo nano /etc/mysql/my.cnf # or /etc/mysql/mysql.conf.d/mysqld.cnf
   ```
2. Under the `[mysqld]` section, add:
   ```ini
   [mysqld]
   sql_mode = "STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION"
   ```
3. Restart MySQL:
   ```bash
   sudo systemctl restart mysql
   ```

---

## 3. Database Migration Failures

If an upgrade halts midway through a database migration:

### Step 1: Run Migrations from CLI to View Detailed Errors
Open a terminal in your OSPOS directory and execute:

```bash
php spark migrate
```

CodeIgniter will output the exact SQL statement and column definition that failed.

### Step 2: Check the Migrations Table
Open your database management tool (phpMyAdmin or MySQL CLI) and inspect the `ospos_migrations` table:

```sql
SELECT * FROM ospos_migrations ORDER BY id DESC LIMIT 10;
```

If a migration failed midway, fix the underlying database column conflict manually, then re-run `php spark migrate`.

---

## 4. International Characters / Emojis ("Incorrect string value")

### Symptom
Saving product descriptions or customer names with accents, Asian characters, or emojis fails with:
```text
General error: 1366 Incorrect string value
```

### Solution
Ensure your database and tables use full 4-byte UTF-8 (`utf8mb4`):

```sql
-- Convert database default
ALTER DATABASE ospos CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Convert specific table
ALTER TABLE ospos_items CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE ospos_customers CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

