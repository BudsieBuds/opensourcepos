---
title: Development Environment & Building
description: Set up a local developer environment, install dependencies, run asset builds, and use Docker Dev.
---

This guide covers setting up a local development environment for contributing to Open Source Point of Sale.

---

## 1. Prerequisites

- **PHP 8.2, 8.3, or 8.4** CLI with required extensions (`ext-intl`, `ext-gd`, `ext-bcmath`, `ext-curl`, `ext-mbstring`, `ext-xml`)
- **Composer 2.5+**
- **Node.js 22+** and **npm 10+**
- **Docker & Docker Compose** (Optional, for containerized development)
- **Git**

---

## 2. Setting Up from Source

Clone the repository:

```bash
git clone https://github.com/opensourcepos/opensourcepos.git
cd opensourcepos
```

### Install Backend Dependencies

```bash
composer install
```

:::note[ext-intl error]
If Composer fails with `'codeigniter4/framework requires ext-intl'`, enable `extension=intl` in your system `php.ini`.
:::

### Install Frontend Dependencies & Build Assets

```bash
npm install
npm run build
```

The build task compiles SCSS, bundles JavaScript, generates icon fonts, and outputs production assets into `public/dist/`.

### Setup Local Environment File

Copy the template `.env` and configure your local database credentials:

```bash
cp .env.example .env
```

Ensure `app.allowedHostnames = 'localhost'` is set for local testing.

---

## 3. Containerized Development with Docker Dev

OSPOS includes a dedicated development Docker Compose configuration (`docker-compose.dev.yml`) with live code mounting and **phpMyAdmin** for database inspection.

### Running Docker Dev

To ensure file permissions inside the container match your host user account, export your user and group IDs:

```bash
# Export host UID and GID
export USERID=$(id -u)
export GROUPID=$(id -g)

# Launch the development stack
docker compose -f docker-compose.dev.yml up -d --build
```

### Development URLs
- **OSPOS App**: `http://localhost:80`
- **phpMyAdmin**: `http://localhost:8080` (Username: `admin`, Password: `pointofsale`)

Any code changes you make in `app/`, `public/`, or `resources/` on your host machine are immediately reflected inside the running container!

### Stopping the Development Stack

```bash
docker compose -f docker-compose.dev.yml down
```

---

## 4. Useful NPM & Spark Commands

```bash
# Rebuild frontend assets
npm run build

# Watch frontend assets for changes during development
npm run watch

# Run database migrations
php spark migrate

# Check route list
php spark routes
```

