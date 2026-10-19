---
title: Sales Register & Checkout
description: Ring up sales, scan barcodes, use keyboard shortcuts, apply discounts, handle split payments, and print receipts.
---

The **Sales Register** is the primary checkout interface of Open Source Point of Sale. It is engineered for rapid keyboard-only operation, handheld barcode scanning, or touch-screen interfaces at the checkout counter.

---

## 1. Register Keyboard Shortcuts

For rapid cashier checkout without touching the mouse, OSPOS provides built-in keyboard shortcuts:

| Shortcut Key | Action | What It Does |
| :---: | :--- | :--- |
| <kbd>ESC</kbd> | **Cancel Sale** | Clears the active cart (prompts for confirmation). |
| <kbd>ALT</kbd> + <kbd>1</kbd> | **Focus Items Search** | Moves cursor to the item barcode/search input field. |
| <kbd>ALT</kbd> + <kbd>2</kbd> | **Focus Customers** | Moves cursor to the customer lookup search field. |
| <kbd>ALT</kbd> + <kbd>3</kbd> | **Suspend Sale** | Places the active sale on hold (layaway/open tab). |
| <kbd>ALT</kbd> + <kbd>4</kbd> | **View Suspended** | Opens the list of suspended sales, quotes, and work orders. |
| <kbd>ALT</kbd> + <kbd>5</kbd> | **Focus Amount Tendered** | Highlights the payment amount input box. |
| <kbd>ALT</kbd> + <kbd>6</kbd> | **Add Payment** | Adds the entered payment amount to the transaction. |
| <kbd>ALT</kbd> + <kbd>7</kbd> | **Complete Sale** | Finalizes the transaction and commits it to the database. |
| <kbd>ALT</kbd> + <kbd>8</kbd> | **Finish Transaction** | Closes the receipt dialog and readies a clean register. |
| <kbd>ALT</kbd> + <kbd>9</kbd> | **Help** | Opens the shortcut assistance modal. |

---

## 2. Adding Items to the Cart

There are multiple ways to ring up items:

### By Barcode Scanner
1. The **Find/Scan Item** field is auto-focused by default on page load and after every sale.
2. Scan the item's barcode.
3. The item immediately appears in the cart with quantity `1`.
4. Scanning the same barcode again increments the quantity to `2`.

### By Name or Category Search
1. Type a few characters of the product name, SKU, or category into the search box.
2. The autocomplete dropdown displays matching products along with real-time stock levels.
3. Use the keyboard arrow keys and press **Enter** to add the item to the cart.

### Adjusting Quantities & Pricing Inline
- **Change Quantity**: Edit the **Qty** box in the cart row and press Enter.
- **Price Override**: If permitted by employee permissions, edit the **Price** field directly.
- **Line-item Discount**: Enter a percentage discount (e.g. `10` for 10% off) or a fixed amount in the **Disc %** box.
- **Remove Item**: Click the delete icon to remove a line item from the cart.

---

## 3. Supported Payment Methods

OSPOS natively supports a wide spectrum of retail tender types:

| Payment Method | Description |
| :--- | :--- |
| **Cash** | Standard cash payment. Calculates exact change due automatically. |
| **Debit Card** | Debit card terminal transaction. Prompts for terminal approval reference number. |
| **Credit Card** | Credit card transaction. Prompts for terminal approval reference number. |
| **Due (Store Credit)** | Charges the purchase to the customer's open account balance (requires attached customer). |
| **Check** | Check payment with check number tracking. |
| **UPI** | Unified Payment Interface (automatically enabled when store country is India). |
| **Bank Transfer** | Direct wire / electronic funds transfer. |
| **Digital Wallet** | Mobile wallets (Apple Pay, Google Pay, WeChat Pay, Alipay). |
| **Gift Card** | Redeem pre-issued store gift cards by card number. |
| **Reward Points** | Redeem customer loyalty points for an instant dollar discount. |
| **Cash / Credit Deposit** | Available in Work Order mode to take partial down payments before service begins. |

:::tip[Customizable Payment Button Order]
In **Store Config** $\rightarrow$ **Payment Options**, you can customize the order in which payment buttons appear (e.g. `Cash, Debit, Credit` vs `Credit, Debit, Cash`).
:::

---

## 4. Split Tender (Multiple Payment Types)

OSPOS supports multiple tender types on a single sale (e.g., paying partially with cash and partially with a credit card).

### Example: Split Payment (Cash + Card)
Total Sale: **$100.00**

1. Customer hands you $40 in cash.
2. Select **Cash**, enter `40.00`, and click **Add Payment** (<kbd>ALT</kbd> + <kbd>6</kbd>).
3. The cart updates to show:
   - Total: $100.00
   - Paid: $40.00
   - **Amount Due: $60.00**
4. Customer pays the remaining $60 by Card.
5. Select **Credit Card**, enter `60.00`, enter the card terminal approval code, and click **Add Payment**.
6. The Amount Due reaches `$0.00`, and the **Complete Sale** button activates!

---

## 5. Suspending & Resuming Sales

If a customer steps away or places items on hold:
1. Click **Suspend Sale** (<kbd>ALT</kbd> + <kbd>3</kbd>).
2. Enter an optional reference note (e.g. *"John - running to car"*).
3. The register clears immediately so you can serve the next customer.
4. To resume, click **Suspended Sales** (<kbd>ALT</kbd> + <kbd>4</kbd>), find the ticket, and click **Unsuspend**.

---

## 6. Completing the Sale & Receipts

1. Click **Complete Sale** (<kbd>ALT</kbd> + <kbd>7</kbd>).
2. The transaction is committed to the database:
   - Real-time stock counts are deducted.
   - Cashup totals are updated.
   - Loyalty points or account balances are recorded.
3. The receipt dialog opens:
   - **Print Receipt**: Sends formatted receipt to your printer.
   - **Email Receipt**: Emails a PDF receipt to the customer's email address.
   - **Auto-Return**: If configured, OSPOS automatically redirects back to a fresh register after `print_delay_autoreturn` seconds!
