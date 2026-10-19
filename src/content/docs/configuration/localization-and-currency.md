---
title: Localization, Currency & Multi-Currency
description: Configure languages, date/time formats, regional currencies, and alternate currency receipt printing.
---

Open Source Point of Sale is deployed in more than 150 countries. It includes complete internationalization (i18n) controls to adapt the user interface, date conventions, and currency formats to your local region.

---

## 1. Language & Translations

OSPOS is translated into over **40 languages** thanks to its active community on [Weblate](https://translate.opensourcepos.org/engage/opensourcepos/).

### System-Wide Default Language
1. Navigate to **Store Config** $\rightarrow$ **Localization**.
2. Select your default language from the **Language** dropdown (e.g., English, Spanish, French, German, Dutch, Portuguese, Arabic, Russian, Chinese, Hindi, etc.).
3. Click **Submit**.

### Per-Employee Language Preference
Different employees at the same checkout counter can operate in their preferred languages:
1. Navigate to **Employees**.
2. Edit an employee profile.
3. Select their personal **Language**.
4. When that employee logs in, the entire POS interface switches to their selected language.

---

## 2. Date, Time & Timezone Settings

Accurate timestamps are critical for sales auditing, till balancing, and tax reporting:

- **Timezone**: Choose your exact IANA timezone (e.g., `America/Chicago`, `Europe/Paris`, `Asia/Singapore`).
- **Date Format**: Choose the date convention standard in your country:
  - `YYYY-MM-DD` (ISO 8601 standard: `2026-10-18`)
  - `DD/MM/YYYY` (UK, Europe, Australia: `18/10/2026`)
  - `MM/DD/YYYY` (United States: `10/18/2026`)
- **Time Format**: Choose between **12-Hour** (`02:30 PM`) or **24-Hour** (`14:30`) clock.

---

## 3. Currency Formatting

Configure how monetary amounts are displayed on screens and receipts:

| Setting | Options / Examples | Notes |
| :--- | :--- | :--- |
| **Currency Symbol** | `$`, `€`, `£`, `₹`, `¥`, `kr`, `R$`, `₱`, `CHF` | Any unicode currency glyph or text symbol. |
| **Currency Side** | **Left** (`$10.00`) or **Right** (`10.00 €`) | Determines whether the symbol precedes or follows the amount. |
| **Decimal Separator** | Dot (`.`) or Comma (`,`) | Use comma for continental Europe / Latin America. |
| **Thousands Separator** | Comma (`,`), Dot (`.`), Space (` `), or None | E.g. `$1,000.00` vs `1.000,00 €` vs `1 000,00 €`. |
| **Decimal Places** | `0`, `1`, `2`, or `3` | Typically `2`. Set to `0` for currencies like JPY, KRW, CLP, or VND. |

---

## 4. Alternate Currency on Receipts

For tourist destinations, border shops, duty-free stores, or international hotels, OSPOS can display a secondary currency conversion on customer receipts.

For example, your store accounting runs in **Mexican Pesos (MXN)**, but tourists frequently pay in or request **US Dollars (USD)**.

### Configuring Alternate Currency
1. In **Store Config** $\rightarrow$ **Receipt**, locate **Alternate Currency**.
2. Enable **Show Alternate Currency on Receipt**.
3. Set the **Alternate Currency Symbol** (e.g. `USD $`).
4. Set the **Exchange Rate** (e.g., `1 USD = 18.50 MXN`).
5. When a receipt is printed, OSPOS calculates and prints:
   ```text
   Total Due:      $ 370.00 MXN
   USD Equivalent: $  20.00 USD  (Rate: 18.50)
   ```

