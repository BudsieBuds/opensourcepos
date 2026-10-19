---
title: Translations & Weblate
description: Contributing translations, working with language files in CodeIgniter 4, and Weblate synchronization.
---

Open Source Point of Sale supports more than 40 languages. Translations are managed continuously via our community localization portal on **Weblate**.

---

## 1. Contributing Translations on Weblate (No Coding Needed)

The easiest way to improve translations or add a new language is through our Weblate translation portal:

👉 **[Translate OSPOS on Weblate](https://translate.opensourcepos.org/engage/opensourcepos/)**

- Translators work directly in a web interface.
- Includes automatic translation suggestions and glossary terminology.
- Translated strings are automatically committed back to the Git repository via automated synchronization pull requests.

---

## 2. Language Files in CodeIgniter 4

In the codebase, translation strings live in `app/Language/{locale}/`:

```text
app/Language/
├── en/               # English (Base Reference)
│   ├── Common.php
│   ├── Customers.php
│   ├── Employees.php
│   ├── Expenses.php
│   ├── Items.php
│   ├── Reports.php
│   └── Sales.php
├── de/               # German
├── es/               # Spanish
├── fr/               # French
├── nl/               # Dutch
└── ...
```

### File Format

Each language file returns an associative array of key-value pairs:

```php
<?php

// app/Language/en/Sales.php

return [
    'sale_register'       => 'Sales Register',
    'find_or_scan_item'   => 'Find/Scan Item',
    'complete_sale'       => 'Complete Sale',
    'confirm_cancel_sale' => 'Are you sure you want to clear this sale? All items will be removed.',
    'item_number'         => 'Item # {0}',
];
```

---

## 3. Using Translation Strings in Code

Never hardcode user-facing text strings in PHP views, controllers, or JavaScript. Always use the `lang()` helper:

```php
<!-- In a View -->
<h1><?= lang('Sales.sale_register') ?></h1>

<!-- With parameter replacement -->
<p><?= lang('Sales.item_number', [$item->item_id]) ?></p>
```

---

## 4. Language Fallback & Conventions

CodeIgniter 4 uses a cascading language fallback mechanism:
1. It attempts to find the translation in the user's selected locale (e.g. `nl-BE`).
2. If the string is missing, it falls back to the parent language (e.g. `nl`).
3. If still missing, it falls back to the default language (`en`).

### Developer Localization Rules
- **Strict Alphabetical Ordering**: Any new keys added to `app/Language/en/` files **must** be placed in strict alphabetical order.
- **Complete Key Coverage**: When introducing a new key in English, the key must also be declared across all other locale files. Untranslated entries in non-English files must have an empty string value `''` (e.g. `'new_feature' => ''`), which allows CodeIgniter 4 to fall back cleanly to English without triggering missing key warnings.
- **Literal Tokens & Placeholders**: Placeholders like `{0}`, `{name}`, or `{filePath}` must remain untranslated and unaltered.

---

## 5. Developer Maintenance Scripts

The repository includes automation scripts to audit and synchronize language dictionaries:

| Script | Purpose |
| :--- | :--- |
| **`align_language_files.php`** | Synchronizes and re-sorts translation keys alphabetically across all language directories to match the English master. |
| **`checkUnusedLanguageLines.php`** | Scans all views, controllers, and models using regex to detect deprecated, orphaned translation keys that are no longer referenced in code. |
| **`clearUntranslated.php`** | Sanitizes redundant or untranslated string entries across locales. |

:::tip[Adding a New Language]
To introduce a new language, create a new locale directory in `app/Language/{code}/` (e.g. `app/Language/pt-BR/`), copy the English language files, and translate the values or contribute directly on Weblate.
:::


