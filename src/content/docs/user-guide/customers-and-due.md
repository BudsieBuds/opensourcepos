---
title: Customers, Loyalty & Store Credit (Due)
description: Manage customer relationships, credit limits, accounts receivable (Due tracking), and loyalty reward points.
---

Open Source Point of Sale includes a customer management module designed for tracking repeat shoppers, managing wholesale/B2B accounts, running loyalty point programs, and extending store credit via **Due accounts**.

---

## 1. Customer Profiles & Information

Navigate to **Customers** $\rightarrow$ **+ New Customer**:

- **Basic Information**: First name, last name, company name, email, phone number, and physical address.
- **Tax ID**: For B2B clients who require their VAT ID, GSTIN, or Tax Registration Number printed on receipts and invoices.
- **Tax Exempt**: Toggle on if the customer is a certified tax-exempt organization (e.g. schools, charities, government agencies, wholesale re-sellers). All taxes will automatically be waived at checkout.
- **Discount %**: Assign an automatic permanent discount percentage to VIP or wholesale clients (e.g. 10% off all purchases).
- **Credit Limit**: The maximum allowable unpaid balance for store credit accounts.

---

## 2. Store Credit & Accounts Receivable ("Due" Payments)

Many retail and wholesale businesses allow regular customers or contractors to take merchandise on credit and pay their bill at the end of the week or month. In OSPOS, this is handled via the **Due** payment method.

### Ringing Up a Sale on Account (Due)
1. In the **Sales** register, select the customer (required for Due sales).
2. Scan the items into the cart.
3. In the payment selector, choose **Due**.
4. Click **Add Payment**, then **Complete Sale**.
5. The transaction completes without cash changing hands:
   - Physical inventory is deducted.
   - The invoice total is added to the customer's outstanding **Account Balance**.
   - If the sale exceeds the customer's configured **Credit Limit**, OSPOS blocks the transaction and warns the cashier.

---

## 3. Receiving Payments on Due Accounts

When the customer returns to settle or pay down their outstanding balance:

### Method A: From the Sales Register
1. In the **Sales** register, select the customer.
2. The customer's current outstanding balance is displayed (e.g., *"Balance Due: $150.00"*).
3. Do not add any items to the cart.
4. Select the payment method they are using to pay (e.g., **Cash** or **Credit Card**).
5. Enter the payment amount and click **Add Payment**.
6. Click **Complete Sale**.
7. OSPOS generates a payment receipt and reduces the customer's balance accordingly.

### Method B: From the Customer Management Screen
1. Go to **Customers**.
2. Find the customer and click the **Pay Due** icon.
3. Enter the payment amount, payment type, and optional notes (e.g. check number).
4. Submit the payment and print the account receipt.

---

## 4. Loyalty Reward Points & Customer Packages

OSPOS features an automated customer loyalty rewards system based on **Customer Reward Packages** (`ospos_customers_packages`):

### Setting Up Reward Packages
1. Navigate to **Store Config** $\rightarrow$ **Customer Rewards**.
2. Check **Customer Reward Enable**.
3. Create your loyalty tiers by defining package names and reward point percentages:
   - *Bronze Tier*: **1%** points rebate per transaction
   - *Silver Tier*: **2%** points rebate per transaction
   - *Gold / VIP Tier*: **5%** points rebate per transaction
4. Click **Submit** to save.

### Enrolling Customers in a Reward Package
1. Go to **Customers** and edit a customer profile.
2. Select their tier from the **Rewards Package** dropdown.
3. Save the profile.

### How Points Accrue on Transactions
Whenever a customer attached to a reward package completes a purchase:

$$\text{Points Earned} = \frac{\text{Sale Total} \times \text{Package Points Percent}}{100}$$

For example, a customer on a 5% Gold package spending $120.00 earns **6.00 Reward Points**.

### Redeeming Points at the Register
1. In the **Sales** register, select the customer.
2. The register displays the customer's **Rewards Package** and current **Available Points**.
3. When tendering the sale, select **Reward Points** from the payment method dropdown.
4. Enter the amount of points to apply toward the total balance.
5. Click **Add Payment** and **Complete Sale**. The redeemed points are subtracted from the customer's available balance in real time.


