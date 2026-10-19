---
title: Plugins & Modular Extensions
description: Extending Open Source Point of Sale with custom payment providers, external integrations, and modules.
---

Open Source Point of Sale is designed to be extensible. Developers can build custom payment providers, integrate external ERPs, or create standalone business modules.

---

## 1. Modular Architecture Overview

OSPOS uses CodeIgniter 4's application structure, which supports modular code organization. Custom modules typically comprise:

1. **Controller**: Handles routing and view rendering (in `app/Controllers/`).
2. **Model**: Database interactions and queries (in `app/Models/`).
3. **View**: User interface and forms (in `app/Views/`).
4. **Permissions Registration**: Enrolling the new module in the employee permissions matrix (`ospos_permissions` table).

---

## 2. Implementing a Custom Payment Provider

Payment providers (such as custom EFTPOS terminals, regional mobile money wallets, or local payment apps) implement a standard checkout interface:

```php
<?php

namespace App\Libraries\Payment;

interface PaymentProviderInterface
{
    /**
     * Initiate a charge request.
     *
     * @param float  $amount Transaction amount
     * @param string $currency Store currency code
     * @param array  $metadata Additional sale metadata
     * @return PaymentResult
     */
    public function processPayment(float $amount, string $currency, array $metadata): PaymentResult;

    /**
     * Process a refund to the original tender.
     */
    public function refundPayment(string $transactionId, float $amount): PaymentResult;
}
```

### Flow of a Custom Payment Hook:
1. Cashier selects the custom payment method in the Sales register.
2. The controller dispatches a request to your payment library.
3. The provider library communicates with the external terminal/API.
4. Upon confirmation, the transaction reference is returned and saved into `ospos_sales_payments`.

---

## 3. Registering Navigation & Permissions

To make a new module appear in the main OSPOS top navigation:

1. Add the route in `app/Config/Routes.php`:
   ```php
   $routes->get('custom_module', 'CustomModule::index');
   ```

2. Register the module in `app/Database/Migrations/`:
   ```php
   $this->db->table('modules')->insert([
       'name_lang_key' => 'module_custom_module',
       'desc_lang_key' => 'module_custom_module_desc',
       'sort'          => 120,
       'module_id'     => 'custom_module',
   ]);
   ```

3. Add permission keys into `ospos_permissions` so administrators can grant or restrict access per employee role.

---

## 4. Best Practices for Custom Extensions

- **Never modify database tables destructively**: Always use incremental CodeIgniter 4 migrations (`php spark make:migration`) so future upstream updates can be merged without conflicts.
- **Use the Event System**: CodeIgniter 4 events (`app/Config/Events.php`) allow you to listen for sales completion (`sales.completed`) or stock adjustment (`inventory.updated`) without editing core controller files.
- **Submit PRs upstream**: If you build a driver for a widely used payment terminal or regional tax format, consider submitting a pull request to benefit the global OSPOS community!

