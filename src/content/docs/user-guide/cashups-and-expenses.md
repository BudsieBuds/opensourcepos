---
title: Cashups (Till Balancing) & Expenses
description: Daily cash register reconciliation, counting currency denominations, discrepancy reporting, and logging operating expenses.
---

Accurate cash control and expense tracking are vital to retail financial health. Open Source Point of Sale provides a **Cashup** module for till balancing and an **Expenses** module for logging operational costs.

---

## 1. Daily Cashup (Till Balancing)

The **Cashup** module tracks the physical cash inside your register till from the moment the store opens until closing time. It compares the actual counted cash against the system's expected total to detect any cash drawer discrepancies (overages or shortages).

### Step 1: Opening the Till (Starting Float)
At the start of the day or shift:
1. Navigate to **Cashups** in the main menu.
2. Click **+ New Cashup**.
3. Enter the **Opening Float** (the starting cash kept in the drawer to make change, e.g. `$200.00`).
4. Select the **Employee** opening the till.
5. Save the opening record.

### Step 2: Mid-Day Cash Movements
During the business day:
- All completed cash sales automatically increase the expected cash balance.
- Any cash refunds given to customers decrease the expected cash balance.
- Any cash expenses paid directly from the till (e.g. paying $15 for cleaning supplies out of the drawer) decrease expected cash.

### Step 3: Closing the Till (End-of-Day Count)
At the end of the shift or business day:
1. Open **Cashups** and click **Close / Edit** on the active cashup session.
2. OSPOS presents a currency denomination counter.
3. Count the physical cash in the drawer and enter the count for each denomination:
   - Hundreds ($100 $\times$ count)
   - Fifties ($50 $\times$ count)
   - Twenties ($20 $\times$ count)
   - Tens, Fives, Ones, and Coins
4. OSPOS calculates the **Total Physical Cash**.

### Step 4: Discrepancy Reporting
OSPOS compares the counted cash against the mathematical expectation:

$$\text{Discrepancy} = \text{Counted Cash} - (\text{Opening Float} + \text{Cash Sales} - \text{Cash Refunds} - \text{Cash Expenses})$$

- **Zero ($0.00)**: Till is perfectly balanced.
- **Positive (+)**: Till is **Over** (more cash in drawer than recorded).
- **Negative (-)**: Till is **Short** (cash is missing or an unrecorded cash payout occurred).

5. Enter any explanatory notes and click **Submit**.
6. Print the **Cashup Summary Slip** to file with the day's banking deposit.

---

## 2. Store Expenses

The **Expenses** module allows you to record business expenditures directly inside OSPOS so that your financial and profit reports reflect your true **Net Profit**, not just gross margin.

### Setting Up Expense Categories
Go to **Store Config** $\rightarrow$ **Expense Categories** to define standard accounting buckets:
- *Store Utilities (Electric, Water, Internet)*
- *Cleaning Supplies & Sanitation*
- *Petty Cash / Store Sundries*
- *Rent & Facilities*
- *Equipment Maintenance & Repairs*
- *Staff Refreshments & Meals*

### Recording an Expense
1. Click **Expenses** in the main menu.
2. Click **+ New Expense**.
3. Fill in the details:
   - **Expense Category**: Select from your pre-defined categories.
   - **Amount**: The total amount paid.
   - **Tax Amount**: Any deductible VAT or sales tax included in the expense.
   - **Payment Type**:
     - *Cash (from Drawer)*: **Important:** This automatically deducts from your active Cashup expected drawer balance!
     - *Company Card / Bank Transfer*: Does not affect the physical cash drawer.
   - **Employee**: The staff member who incurred or authorized the expense.
   - **Supplier / Payee**: The company paid (e.g., *City Power Co.*).
   - **Description / Receipt Ref**: Invoice number or reference details.
4. Click **Submit**.

Expenses are automatically tabulated into your **Expense Reports** and subtracted from gross revenue on your store **Profit & Loss Summary**.

