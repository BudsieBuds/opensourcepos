---
title: Docker Quickstart
description: Deploy Open Source Point of Sale using Docker and Docker Compose.
---

Docker is the **recommended** way to run Open Source Point of Sale. It packages the application, its required PHP runtime, Apache, and the MariaDB database into isolated containers, eliminating version incompatibilities and simplifying upgrades.

---

## Prerequisites

- [Docker Engine](https://docs.docker.com/engine/install/) (v20.10 or later)
- [Docker Compose](https://docs.docker.com/compose/) (v2.0 or later, built into modern Docker Desktop / CLI as `docker compose`)

---

## 1. Quickstart Deployment

Create a directory on your server or workstation and navigate into it:

```bash
mkdir ospos && cd ospos
```

### Step 1: Download `docker-compose.yml`

Download the official production Compose file:

```bash
curl -O https://raw.githubusercontent.com/opensourcepos/opensourcepos/master/docker-compose.yml
```

### Step 2: Initialize `.env`

:::caution[Important Host Binding]
The Compose configuration binds `./.env` from the host into the container. You **must** create an empty `.env` file before starting the container, otherwise Docker will create `.env` as a directory on the host and the application will fail to start.
:::

Create the empty file:

```bash
touch .env
```

### Step 3: Launch Containers

Start the containers in detached (background) mode:

```bash
docker compose up -d
```

Docker will automatically:
1. Pull the official MariaDB and OSPOS images.
2. Initialize the database schema and default tables.
3. Automatically provision encryption secrets (`encryption.key` and `throttle.key`) into `./.env`.
4. Launch the web server on port `80`.

---

## 2. Accessing the Application

Once the containers are up, open your web browser and navigate to:

- **Local installation**: `http://localhost`
- **Remote server**: `http://your-server-ip`

Log in using the default administrative credentials:
- **Username**: `admin`
- **Password**: `pointofsale`

:::tip[Security Checklist]
Immediately after logging in:
1. Navigate to **Employees** and change the default `admin` password.
2. Navigate to **Store Config** and configure your store details, currency, and tax rates.
:::

---

## 3. Configuration & Environment Variables

You can customize the deployment by setting environment variables in your `docker-compose.yml` or an `.env` file alongside it.

### Common Environment Variables

| Variable | Default | Description |
| :--- | :--- | :--- |
| `ALLOWED_HOSTNAMES` | `localhost` | **Required in production.** Comma-separated list of domain names (e.g. `pos.yourshop.com,shop.example.com`). Prevents Host Header Injection attacks. |
| `FORCE_HTTPS` | `false` | Set to `true` when running behind an SSL-terminating reverse proxy (Nginx, Traefik, Caddy, Cloudflare). |
| `PHP_TIMEZONE` | `UTC` | Timezone for PHP dates (e.g. `America/New_York`, `Europe/Amsterdam`, `Asia/Kolkata`). |
| `MYSQL_DB_NAME` | `ospos` | Name of the database. |
| `MYSQL_USERNAME` | `admin` | MariaDB administrative username. |
| `MYSQL_PASSWORD` | `pointofsale` | MariaDB password (**change this for production!**). |
| `CI_ENVIRONMENT` | `production` | CodeIgniter environment (`production` or `development`). |

### Example Production `docker-compose.override.yml`

To customize settings without modifying the base file, create a `docker-compose.override.yml`:

```yaml
services:
  ospos:
    environment:
      - ALLOWED_HOSTNAMES=pos.yourshop.com
      - FORCE_HTTPS=true
      - PHP_TIMEZONE=Europe/Amsterdam
      - MYSQL_PASSWORD=MySecureDatabasePass123!
    ports:
      - "8080:80"

  mysql:
    environment:
      - MYSQL_PASSWORD=MySecureDatabasePass123!
```

---

## 4. Reverse Proxy Setup (HTTPS / SSL)

When deploying on the public internet or corporate network, run OSPOS behind a reverse proxy that terminates TLS/SSL (e.g. Let's Encrypt).

### Nginx Reverse Proxy Example

```nginx
server {
    listen 80;
    server_name pos.yourshop.com;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    server_name pos.yourshop.com;

    ssl_certificate /etc/letsencrypt/live/pos.yourshop.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/pos.yourshop.com/privkey.pem;

    location / {
        proxy_pass http://127.0.0.1:8080; # or port 80 if exposed directly
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

Make sure `FORCE_HTTPS=true` is set in the OSPOS container environment so redirect URLs and asset links use `https://`.

---

## 5. Maintenance & Useful Commands

### Viewing Container Logs

```bash
# View live application logs
docker compose logs -f ospos

# View database logs
docker compose logs -f mysql
```

### Stopping and Starting

```bash
# Stop containers without deleting data
docker compose stop

# Restart stopped containers
docker compose start

# Shut down and remove containers (data volumes are preserved)
docker compose down
```

### Backing Up the Database

```bash
docker compose exec mysql mysqldump -uadmin -ppointofsale ospos > ospos_backup_$(date +%F).sql
```

### Restoring the Database

```bash
docker compose exec -T mysql mysql -uadmin -ppointofsale ospos < ospos_backup.sql
```

### Backing Up Uploaded Files and Secrets

All uploaded product images and certificates are stored in the `uploads` Docker volume. Your encryption keys are stored in `./.env`. Always back up:
1. The MySQL backup `.sql` file
2. The `./.env` file (contains `encryption.key` used to decrypt stored tokens)
3. The uploaded images volume

