---
title: Store Configuration & Integrations
description: Complete breakdown of Store Config tabs, branding, SMS messaging, Mailchimp, dinner tables, and shortcuts.
---

The **Store Configuration** panel allows administrators to customize business details, branding assets, receipt layouts, restaurant dinner tables, and third-party integrations.

Access these settings by logging in as an administrator and navigating to **Store Config** (the gear icon).

---

## 1. Store Config Sections Overview

```text
Store Config Tabs:
├── 🏢 Info: Store name, address, phone, website, return policy, and logo upload
├── ⚙️ General: Themes, login layout, default discount, invoice & work order toggles
├── 🌐 Locale: Timezone, language, currency symbol/side, number & date formatting
├── ✉️ Email: SMTP server configuration (Gmail, Microsoft 365, SendGrid)
├── 📱 Message: SMS text messaging gateway settings
├── 🐵 Mailchimp: Automatic customer email newsletter synchronization
├── 📍 Stock Locations: Multi-warehouse and counter inventory locations
├── 🍽️ Dinner Tables: Restaurant dining table names and status
├── 🏛️ Taxes: Tax jurisdictions, categories, rates matrix, and India GST
├── ⭐ Customer Rewards: Loyalty point earning packages and redemption rules
├── 🏷️ Barcode: Barcode label templates, font sizing, and token input formats
├── 🖨️ Receipt: Margins, print delay auto-return, and silent printing
├── ⌨️ Shortcuts: Keyboard shortcut assignments
└── 🧾 Invoice: Sequential numbering tokens, quote prefixes, and UBL e-invoicing
```

---

## 2. Branding & Company Profile (Info Tab)

- **Company Name**: Your legal or trade business name (appears on receipts, invoices, and browser tabs).
- **Company Logo**: Upload a high-resolution logo image (PNG, JPG, or SVG). 
  - *Recommendation*: Use a transparent PNG or vector SVG with a landscape aspect ratio (e.g. 400x120 pixels).
  - Used on web receipts, PDF invoices, and email templates.
- **Store Address**: Multi-line physical address.
- **Phone & Email**: Customer contact telephone number and reply-to email address.
- **Website URL**: Your online store or corporate website.
- **Return Policy**: The policy printed at the bottom of every receipt.

---

## 3. Integrations: SMS Text Messaging & Mailchimp

### SMS Text Messaging (Message Tab)
OSPOS can send text messages directly to customers (e.g., notifying them that a repair work order is completed or confirming a large order):
1. In the **Message** tab, enter your SMS Gateway API credentials:
   - **Gateway Username (`msg_uid`)**
   - **Gateway Password (`msg_pwd`)**
   - **Sender ID / Originator (`msg_src`)** (e.g. `YourShopName`)
2. In **Messages** in the main menu, cashiers can compose and send SMS messages directly to customer phone numbers.

### Mailchimp Newsletter Sync (Mailchimp Tab)
Automatically synchronize customer email addresses into your Mailchimp marketing lists:
1. Enter your **Mailchimp API Key**.
2. Click **Check API Key**; OSPOS queries your Mailchimp account and lists your audience lists.
3. Select your target **Mailchimp List**.
4. Whenever a new customer is created in OSPOS with an email address, they are automatically subscribed to your Mailchimp newsletter!

---

## 4. Dinner Tables (Restaurant Dining Mode)

For restaurants, cafes, and bars:
1. In **Store Config** $\rightarrow$ **Dinner Tables**, create your dining floor plan:
   - *Example*: `Table 1`, `Table 2`, `Table 3`, `Patio A`, `Bar 1`.
2. When ringing up orders in **Sales**, cashiers assign items directly to an open table and suspend the sale while guests dine.

---

## 5. Keyboard Shortcuts (Shortcuts Tab)

Customizable keyboard shortcuts for rapid counter checkout:
- Default shortcuts: <kbd>ESC</kbd> to Cancel, <kbd>ALT</kbd> + <kbd>1</kbd> to Focus Items, <kbd>ALT</kbd> + <kbd>2</kbd> to Focus Customers, <kbd>ALT</kbd> + <kbd>5</kbd> for Tendered, <kbd>ALT</kbd> + <kbd>7</kbd> to Complete.
- Administrators can remap keyboard shortcut keys to match existing cashier muscle memory or POS keyboard layouts.

---

## 6. Invoice Numbering & Document Formats (Invoice Tab)

OSPOS provides a powerful token substitution engine (`App\Libraries\Token_lib`) for generating custom invoice, quotation, and work order numbering sequences.

### Supported Numbering Tokens

You can combine standard `strftime` / `IntlDateFormatter` date specifiers with OSPOS sequence tokens:

| Token | Meaning | Example Output |
| :--- | :--- | :--- |
| `%Y` | 4-digit year | `2026` |
| `%y` | 2-digit year | `26` |
| `%m` | 2-digit month | `10` |
| `%d` | 2-digit day | `18` |
| `{ISEQ}` or `{ISEQ:len}` | Next sequential invoice number (padded to `len` digits) | `{ISEQ:6}` $\rightarrow$ `000142` |
| `{QSEQ}` or `{QSEQ:len}` | Next sequential quotation number (padded to `len` digits) | `{QSEQ:5}` $\rightarrow$ `00038` |
| `{WSEQ}` or `{WSEQ:len}` | Next sequential work order number (padded to `len` digits) | `{WSEQ:5}` $\rightarrow$ `00012` |
| `{CO}` or `{CO:len}` | Total invoice count | `{CO:6}` $\rightarrow$ `001500` |
| `{SCO}` | Suspended invoice count | `4` |
| `{YCO}` | Invoice count for current year | `412` |
| `{QCO}` | Quote count for current year | `85` |
| `{CU}` | Customer full name | `John Doe` |

### Configuration Examples
- **Sales Invoice Format (`sales_invoice_format`)**:
  - Pattern: `INV-%Y%m-{ISEQ:5}` $\rightarrow$ `INV-202610-00042`
  - Pattern: `%y%m{ISEQ:6}` $\rightarrow$ `2610000042`
- **Quotation Format (`sales_quote_format`)**:
  - Pattern: `EST-%Y-{QSEQ:4}` $\rightarrow$ `EST-2026-0015`
- **Work Order Format (`work_order_format`)**:
  - Pattern: `WO-%y%m{WSEQ:5}` $\rightarrow$ `WO-261000007`
- **Receiving Invoice Format (`recv_invoice_format`)**:
  - Pattern for vendor purchasing orders: `RECV-%Y-{CO:5}`

### Invoice Options & Line Item Sequencing
- **Invoice Types**:
  - `invoice`: Standard retail/commercial invoice (`invoice.php`)
  - `tax_invoice`: Formal tax invoice with breakdown table (`tax_invoice.php`)
  - `custom_invoice`: User-defined template (`custom_invoice.php`)
  - `custom_tax_invoice`: User-defined tax template (`custom_tax_invoice.php`)
- **Line Sequence Order**:
  - `Entry`: Preserves the exact chronological order cashiers scanned items.
  - `Group by Type`: Groups standard items, kits, and amount entries together.
  - `Group by Category`: Groups items under their product category headers on invoices.
- **Starting Sequence Counters**:
  - Set `last_used_invoice_number`, `last_used_quote_number`, or `last_used_work_order_number` to resume numbering from a previous POS system.

