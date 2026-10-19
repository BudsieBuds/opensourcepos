---
title: Overview & System Requirements
description: Introduction to Open Source Point of Sale (OSPOS), architecture overview, and minimum server requirements.
---

**Open Source Point of Sale (OSPOS)** is a free, web-based point-of-sale system designed specifically for small to medium businesses, retail shops, restaurants, and non-profits.

Built on PHP using the modern **CodeIgniter 4** framework, a **MySQL or MariaDB** database backend, and a **Bootstrap** responsive interface, OSPOS provides enterprise-grade retail capabilities without subscription fees or proprietary lock-in.

---

## Key Capabilities

- **Sales Register**: Barcode scanning, fast search, touch-screen friendly, split tender, gift cards, discounts, and quotes/estimates.
- **Multiple Sales Modes**: Standard retail sales, returns/refunds, quotation estimates, work orders, and restaurant table dining.
- **Inventory & Multi-Location**: Stock tracking across multiple stores/warehouses, item kits (bundles/combos), serial number tracking, reorder thresholds, and inventory audits (stocktake).
- **Receivings & Suppliers**: Purchase orders, supplier tracking, inventory receiving, and inter-location stock transfers.
- **Customers & Due Accounts**: Complete customer profiles, purchase logs, discount tiers, loyalty reward points, and customer store credit / accounts receivable (Due tracking).
- **Hardware Integration**: Thermal receipt printers (ESC/POS via USB, Network, Serial, or WebUSB), cash drawers, barcode scanners, price/weight embedded barcode scales, and pole customer displays.
- **Flexible Taxation**: Sales tax, Value Added Tax (VAT), multi-tiered taxes, and comprehensive India Goods and Services Tax (GST) support with HSN/SAC codes.
- **Daily Cashup & Expenses**: Till reconciliation with opening float and closing count discrepancies, plus expense tracking by category.
- **Extensive Reporting**: Summary and detailed sales, inventory valuation, profit margins, discount logs, tax breakdowns, and export to CSV or PDF.
- **Global Localization**: Translated into over 40 languages, multi-currency support, customizable receipt headers, and international currency formats.

---

## Technology Stack

| Layer | Technology |
| :--- | :--- |
| **Backend Framework** | PHP 8.2 to 8.4 with [CodeIgniter 4](https://codeigniter.com/) |
| **Database** | MariaDB 10.4+ / MySQL 5.7 or 8.0+ |
| **Frontend UI** | HTML5, CSS3, Bootstrap, jQuery, FontAwesome |
| **Asset Pipeline** | Node.js, npm, Gulp / esbuild |
| **Deployment** | Docker & Docker Compose, Apache 2.4 (`mod_rewrite`), or Nginx |

---

## Minimum Server Requirements

To run OSPOS reliably in production:

### 1. PHP Version & Extensions
- **PHP Version**: `8.2` through `8.4` (PHP $\le$ 8.1 is **not** supported).
- **Required Extensions**:
  - `php-bcmath` (precision monetary calculations)
  - `php-curl` (external integrations, geocoding)
  - `php-gd` (barcode rendering, product image processing)
  - `php-intl` (internationalization, currency formatting, locale handling)
  - `php-json` (data interchange, API responses)
  - `php-mbstring` (multibyte character strings for multilingual support)
  - `php-openssl` (data encryption, secure session tokens)
  - `php-xml` (XML/DOM processing, report generation)

### 2. Database Server
- **MariaDB 10.4+** (Recommended for performance and open-source alignment)
- **MySQL 5.7+ or 8.0+**
- Default character set: `utf8mb4` with collation `utf8mb4_unicode_ci` or `utf8mb4_general_ci`.

### 3. Web Server
- **Apache 2.4** with `mod_rewrite` enabled and `AllowOverride All` set on the web root.
- **Nginx** with PHP-FPM and URI rewrite routing to `public/index.php`.

### 4. Hardware Resources
- **RAM**: Minimum 512 MB (1 GB+ recommended, especially when generating large PDF reports).
- **Disk Space**: At least 500 MB for core application and dependencies, plus storage for database growth and product photo uploads (`public/uploads/`).
- **CPU**: Any modern 64-bit x86 or ARM CPU (e.g. Raspberry Pi 4/5, AWS t3/t4g, DigitalOcean Basic Droplet).

---

## Choosing a Deployment Method

Depending on your environment and technical preference:

1. **[Docker Compose (Recommended)](/getting-started/docker/)**:
   The fastest and cleanest method. Bundles PHP, Apache, and MariaDB into isolated containers with zero dependency conflicts on the host.
2. **[Traditional Server Installation](/getting-started/installation/)**:
   For dedicated Linux VPS or on-premises Ubuntu/Debian servers running Apache or Nginx.
3. **[Windows (XAMPP / WSL)](/getting-started/windows/)**:
   For local testing or standalone single-station Windows setups.
4. **[Raspberry Pi / Single-Board Computers](/getting-started/raspberry-pi/)**:
   For ultra low-power, compact in-store POS servers.

