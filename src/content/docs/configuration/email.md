---
title: Email Setup (SMTP & Notifications)
description: Configure email delivery (SMTP, Gmail, Microsoft 365, SendGrid) to send receipts, quotes, and purchase orders.
---

Open Source Point of Sale can automatically email digital receipts to customers, send formal quotations to clients, and dispatch purchase orders directly to suppliers.

To configure email delivery, navigate to **Store Config** $\rightarrow$ **Email**.

---

## 1. Supported Email Protocols

| Protocol | Best For | Recommendation |
| :--- | :--- | :--- |
| **SMTP** | Cloud providers (SendGrid, Mailgun, Amazon SES, Postmark) or Google Workspace / Microsoft 365. | **Strongly Recommended** (reliable delivery, avoids spam filters). |
| **Sendmail** | Linux servers running a local Postfix or Exim mail transfer agent. | For experienced system administrators. |
| **PHP `mail()`** | Basic hosting environments using the built-in PHP mail function. | Not recommended (frequently blocked by recipient spam filters). |

---

## 2. Setting Up SMTP Delivery

Select **Email Protocol**: `SMTP` and fill in the connection parameters:

- **SMTP Host**: Mail server address (e.g. `smtp.sendgrid.net`, `smtp.gmail.com`, or `smtp.office365.com`).
- **SMTP Port**:
  - `587` (Recommended: STARTTLS encryption)
  - `465` (SSL/TLS encryption)
  - `25` (Unencrypted: not recommended)
- **SMTP Encryption**: Select `TLS` (for port 587) or `SSL` (for port 465).
- **SMTP Username**: Your email address or API user (e.g. `apikey` for SendGrid).
- **SMTP Password**: Your email password or dedicated **App Password**.
- **From Address**: The sender email address that customers see (e.g. `receipts@yourstore.com`).
- **From Name**: Your store name (e.g. `City Market Receipts`).

---

## 3. Provider-Specific Examples

### Google Workspace / Gmail
- **Host**: `smtp.gmail.com`
- **Port**: `587`
- **Encryption**: `TLS`
- **Username**: `your-store@gmail.com`
- **Password**: A dedicated **Google App Password** (Generated in Google Account $\rightarrow$ Security $\rightarrow$ 2-Step Verification $\rightarrow$ App Passwords. Do *not* use your primary Google login password).

### Microsoft 365 / Outlook
- **Host**: `smtp.office365.com`
- **Port**: `587`
- **Encryption**: `STARTTLS`
- **Username**: `pos@yourdomain.com`
- **Password**: Your Microsoft 365 account or app password.

### SendGrid
- **Host**: `smtp.sendgrid.net`
- **Port**: `587`
- **Encryption**: `TLS`
- **Username**: `apikey`
- **Password**: `SG.your_sendgrid_api_key_here`

---

## 4. Testing Your Configuration

1. After entering your SMTP credentials, locate the **Test Email** section at the bottom of the page.
2. Enter your personal email address.
3. Click **Send Test Email**.
4. Check your inbox for the confirmation message.
5. If the test fails, inspect the log file at `writable/logs/log-YYYY-MM-DD.php` for the raw SMTP handshake error.

