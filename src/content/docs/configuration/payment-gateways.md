---
title: Payment Processing & Card Terminals
description: Set up credit/debit card processing using standalone payment terminals or integrated payment providers.
---

Accepting credit, debit, and contactless mobile payments (Apple Pay, Google Pay) in Open Source Point of Sale can be accomplished using **Standalone Terminals** or **Integrated Gateway Solutions**.

---

## 1. Standalone Payment Terminals (Recommended)

In most brick-and-mortar retail and hospitality stores, the cleanest and most cost-effective method is using a **Standalone EMV Card Terminal** provided by your bank or merchant processor (such as Verifone, Ingenico, PAX, SumUp, or Zettle).

```
   Cashier                  Customer                       Bank
 ┌─────────┐              ┌──────────┐                 ┌──────────┐
 │  OSPOS  │ Ring up $45  │  EMV /   │ Tap Apple Pay   │ Merchant │
 │ Counter │─────────────>│ Terminal │────────────────>│ Acquirer │
 └─────────┘              └──────────┘                 └──────────┘
```

### Checkout Workflow:
1. Ring up the items on the OSPOS Sales register.
2. Tell the customer the total due (e.g. `$45.00`).
3. Customer taps their phone or inserts their chip card into your card machine.
4. Once the card terminal beeps with **"Approved"**:
   - In OSPOS, select **Credit Card** as the payment method.
   - Click **Add Payment**, then **Complete Sale**.

### Why Most Retailers Prefer Standalone:
- **Zero PCI-DSS Compliance Scope**: Credit card numbers never touch the POS computer, network router, or database. Card data stays 100% isolated on the encrypted terminal.
- **Freedom of Processor**: You can switch banks or merchant processors whenever you negotiate better transaction fee rates without having to modify your POS software.
- **No Monthly Gateway Fees**: Avoids third-party software bridge fees.

---

## 2. Integrated Payment Gateways (Stripe Terminal, etc.)

For businesses that prefer the transaction amount to be pushed automatically to the reader screen without the cashier re-typing the amount:

- **Supported Readers**: Smart smart-readers supporting cloud-based terminal protocols (e.g., Stripe BBPOS WisePOS E, WisePad 3).
- **Communication**: The OSPOS server communicates with the payment provider's API over HTTPS, dispatching the charge request to the physical reader connected to the store's Wi-Fi network.
- **Webhook Resolution**: When the customer completes the chip or PIN verification, the gateway returns an approval token back to OSPOS, completing the checkout automatically.

---

## 3. Configuring Allowed Payment Methods

Navigate to **Store Config** $\rightarrow$ **Payment Options**:

You can enable or disable specific payment buttons on the register to keep the cashier screen simple:

- `Cash`: Enabled
- `Credit / Debit Card`: Enabled
- `Check`: Enabled or Disabled
- `Gift Card`: Enabled
- `Due (Store Credit)`: Enabled (for trusted account customers)
- `Voucher / Promotion`: Enabled

---

## 4. End-of-Day Terminal Reconciliation

At the end of each business day:
1. Print the **Daily Batch Settlement Summary** from your physical credit card terminal.
2. In OSPOS, open **Reports** $\rightarrow$ **Sales by Payment Type** for today's date.
3. Verify that the **Credit Card** total in OSPOS matches the total settled on your card terminal batch slip:
   $$\text{OSPOS Card Total} = \text{Terminal Settled Batch Total}$$
4. File the terminal settlement slip with your daily [Cashup](/user-guide/cashups-and-expenses/) report for accounting.

