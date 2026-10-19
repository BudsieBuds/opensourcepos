---
title: Sales Modes & Restaurant Service
description: Using Return mode, Quotation estimates, Work Orders, and Restaurant Table Dining in OSPOS.
---

Open Source Point of Sale supports multiple transaction workflows beyond standard retail checkout. Using the **Register Mode** selector at the top of the Sales screen, you can switch between different operational modes based on your store configuration:

| Register Mode | Config Requirement | Description |
| :--- | :--- | :--- |
| **Sale / Receipt** | Default mode | Rings up immediate counter sales and prints standard receipts. |
| **Return** | Always available | Handles product refunds and exchanges with negative inventory deduction. |
| **Quote** | `invoice_enable` active | Creates formal price estimates without affecting inventory or financial balances. |
| **Work Order** | `work_order_enable` active | Service repair orders tracking equipment, customer labor, and repair parts. |
| **Invoice** | `invoice_enable` active | Commercial B2B invoice generation with payment terms and line item grouping. |

---

## 1. Return Mode (Refunds & Exchanges)

When a customer brings back merchandise for a refund or exchange:

1. In the **Sales** register, change the mode dropdown from **Sale** (or **Receipt**) to **Return**.
2. Scan or search for the item being returned.
3. The item is entered with a **negative quantity** (e.g. `-1`) and a negative subtotal.
4. If the customer is returning an item and buying another item at the same time (an **exchange**):
   - Add the returned item (negative amount).
   - Add the new item being purchased (positive amount).
   - The register automatically calculates the net difference (either money owed to the customer or additional payment due).
5. In the payment panel, select the refund method (e.g. **Cash**, **Credit Card refund**, or store credit **Due**).
6. Click **Complete Sale**.

:::note[Automatic Stock Restock]
When a return is completed, OSPOS automatically increments your physical stock count for that item at the current stock location.
:::

---

## 2. Estimate / Quotation Mode

Quotation mode allows you to create formal price estimates for customers without affecting current inventory or revenue reports.

### Creating a Quote
1. Switch the mode dropdown to **Quote**.
2. Select or create the customer (required for quotes).
3. Add the requested items, quantities, and negotiated discounts.
4. Click **Finish Quote** (or press <kbd>ALT</kbd> + <kbd>8</kbd>).
5. OSPOS generates a formal **Quotation Document** with:
   - Formatted Quote Number (configured via `sales_quote_format`, e.g. `EST-%Y-{QSEQ:4}`)
   - Itemized list and tax calculations
   - Quote comments and company terms
   - Print or Email options for the client.

### Converting a Quote into a Sale
When the customer approves the quote:
1. Open **Sales** $\rightarrow$ **Suspended Sales**.
2. Locate the customer's suspended quote.
3. Click **Unsuspend / Convert to Sale**.
4. All quoted items and prices load into the live register cart.
5. Tender payment and complete the sale. Inventory is deducted only upon sale completion.

---

## 3. Work Orders Mode

Work Orders are designed for repair shops, computer technicians, tailors, bike shops, and custom fabrication businesses that take in customer items for service.

### Creating a Work Order
1. Switch the mode dropdown to **Work Order**.
2. Select the customer.
3. Add service labor items and required parts/materials to the cart.
4. If the customer pays an advance down payment, tender a **Cash Deposit** or **Credit Deposit** payment.
5. Suspend or complete the work order ticket.

### Tracking and Invoicing
- Open **Sales** $\rightarrow$ **Suspended Sales** to view active work order tickets.
- Additional diagnostic parts or labor hours can be added as repairs proceed.
- When the repair is finished, reopen the work order, apply the remaining payment balance, and print the final invoice.

---

## 4. Restaurant & Dinner Table Service

OSPOS includes specialized hospitality features for dining tables, bars, and patio seating.

### Enabling Dinner Tables
1. Go to **Store Config** $\rightarrow$ **Dinner Tables**.
2. Check **Dinner Table Enable**.
3. Add your dining tables using the **+** button:
   - *Example*: `Table 1`, `Table 2`, `Table 3`, `Patio A`, `Bar 1`.
4. Click **Submit** to save.

### Taking Table Orders
1. In the Sales register, a **Dinner Table** selector appears in the top register bar.
2. Select the guest table (e.g., *Table 4*).
3. Add food and beverage items to the ticket.
4. Click **Suspend Sale** to keep the tab open while the guests dine. The table is marked occupied.
5. To ring up additional rounds or courses, reopen the table from **Suspended Sales**, add the items, and re-suspend.

### Closing Tables & Splitting Payments
1. When the guests request the check, reopen the table.
2. Accept payment (supports split tender across multiple credit cards and cash).
3. Click **Complete Sale** to close the ticket and release the table back to available status.

