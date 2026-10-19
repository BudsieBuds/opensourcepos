---
title: Employee Roles & Permissions
description: Role-based access control (RBAC), module permissions, reporting grants, and cashier access control.
---

Open Source Point of Sale includes a granular role-based access control (RBAC) permission system to secure store operations, protect financial reports, and restrict sensitive inventory actions.

---

## 1. Creating and Managing Employees

Navigate to **Employees** $\rightarrow$ **+ New Employee**:

1. **Personal Information**: First name, last name, phone number, email address.
2. **Login Credentials**:
   - **Username**: Unique login identifier (e.g. `jane.doe` or `cashier1`).
   - **Password**: Password (securely hashed using PHP's `password_hash()` BCRYPT algorithm).
3. **Language**: Staff member's preferred interface language (the UI switches automatically upon login).
4. **Permissions**: Check or uncheck access to specific modules and reporting grants.

---

## 2. Core Modules & Permissions

OSPOS structures access control around 15 core module permissions:

| Module Identifier | System Module Name | Operational Scope |
| :--- | :--- | :--- |
| **`sales`** | Sales Register | Ring up sales, process returns, take deposits, and suspend transactions. |
| **`customers`** | Customers | Search, view, create, and manage customer accounts and Due balances. |
| **`items`** | Items & Inventory | Product catalog, pricing, barcodes, and inventory adjustments. |
| **`item_kits`** | Item Kits | Create and manage bundled product packages and combo meals. |
| **`receivings`** | Receivings | Process supplier purchase orders and inter-location stock transfers. |
| **`suppliers`** | Suppliers | Vendor directory, contact persons, and supplier accounts. |
| **`reports`** | Reports | Master grant for the reporting suite. |
| **`cashups`** | Cashups | Open/close cash registers, count denominations, and record discrepancies. |
| **`expenses`** | Expenses | Record operational store expenditures and petty cash payouts. |
| **`expenses_categories`**| Expense Categories | Manage expense categorization buckets. |
| **`giftcards`** | Gift Cards | Issue, top-up, and manage store gift cards. |
| **`messages`** | SMS Messages | Compose and dispatch SMS text messages to customer phone numbers. |
| **`office`** | Back Office | Access to administrative management dashboards. |
| **`employees`** | Employees | Administrative control over staff accounts and permission grants. |
| **`config`** | Store Configuration | Full access to business profile, tax rules, and system settings. |

---

## 3. Granular Reporting Grants (Sub-Permissions)

To allow department managers or shift supervisors to view specific reports without exposing entire business financials, OSPOS provides sub-permissions under the `reports` module:

- **`reports_sales`**: Summary and detailed transaction sales logs.
- **`reports_categories`**: Sales broken down by product category.
- **`reports_customers`**: Customer spending rankings.
- **`reports_discounts`**: Audits of all line-item and cart-level discounts applied by cashiers.
- **`reports_items`**: Top-selling products and item velocity.
- **`reports_employees`**: Cashier productivity and commission tracking.
- **`reports_inventory`**: Low stock alerts and inventory valuation totals.
- **`reports_receivings`**: Purchase order and supplier delivery summaries.
- **`reports_suppliers`**: Purchasing volume by vendor.
- **`reports_taxes`**: Sales tax, VAT, and India GST collections.
- **`reports_payments`**: Reconciliation by tender type (Cash, Card, Due, Check).
- **`reports_expenses_categories`**: Expense breakdowns.

---

## 4. Location-Specific Stock Permissions

In multi-store or multi-warehouse retail operations, employees can be restricted to specific physical locations:

- **`sales_stock` (per location)**: Restricts which stock location the cashier can deduct inventory from at checkout.
- **`items_stock` (per location)**: Restricts which location's physical inventory counts the employee can view or adjust.
- **`receivings_stock` (per location)**: Restricts which warehouse or store the employee can receive incoming supplier deliveries into.

---

## 5. Recommended Role Templates

### Role A: Counter Cashier
- **Enabled**: `sales`, `customers`, `cashups`.
- **Location**: Assigned strictly to their active checkout counter.
- **Disabled**: All `reports_*`, `config`, `employees`, `items`, `expenses`.

### Role B: Receiving & Stock Clerk
- **Enabled**: `items`, `item_kits`, `receivings`, `suppliers`.
- **Sub-permissions**: `reports_inventory`, `reports_receivings`.
- **Disabled**: `sales`, `cashups`, `config`, `employees`, `expenses`.

### Role C: Store General Manager
- **Enabled**: `sales`, `customers`, `items`, `item_kits`, `receivings`, `suppliers`, `reports` (all sub-permissions), `cashups`, `expenses`, `giftcards`, `messages`, `office`.
- **Disabled**: `config` and `employees` (reserved for system owner/IT).
