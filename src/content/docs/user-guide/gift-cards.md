---
title: Gift Cards Management
description: Issue, load, track, and redeem store gift cards in Open Source Point of Sale.
---

Open Source Point of Sale includes a built-in **Gift Cards** management system. You can issue digital or physical plastic gift cards to customers, top up card balances, and accept them as tender at checkout.

---

## 1. Creating and Issuing Gift Cards

To issue a new gift card:

1. Navigate to **Gift Cards** in the main navigation.
2. Click **+ New Gift Card**.
3. Fill in the card parameters:
   - **Gift Card Number**: Scan a pre-printed barcode from a physical plastic gift card, or enter an alphanumeric code (e.g. `GC-104928`). If left blank, OSPOS can generate a unique code.
   - **Value / Balance**: The dollar or currency amount loaded onto the card (e.g. `$50.00`).
   - **Customer**: Optionally attach the card to a specific customer profile.
4. Click **Submit**.

:::tip[Pre-Printing Plastic Gift Cards]
You can order custom plastic barcode gift cards from any card printer with standard Code 128 barcodes. When a customer purchases a gift card at the register, the cashier simply scans the card barcode into the **Gift Card Number** field to activate and load funds!
:::

---

## 2. Selling Gift Cards at the Register

When a customer wants to buy a gift card:
1. In the **Sales** register, add the **Gift Card** item or ring up the newly created card number.
2. Accept payment from the purchaser (Cash, Card, Check).
3. Complete the sale. The gift card is now active and ready for redemption.

---

## 3. Redeeming a Gift Card for Purchases

When a shopper presents a gift card to pay for merchandise:

1. Ring up the items in the **Sales** register as usual.
2. In the payment selector panel on the right, select **Gift Card** from the payment method dropdown.
3. In the input box, scan or type the **Gift Card Number** and click **Add Payment**.
4. OSPOS verifies the available balance:
   - **If the card covers the full amount**: The sale is covered and ready to complete.
   - **If the card has a partial balance** (e.g. Cart is $60, Gift Card has $25): OSPOS deducts the $25 from the card balance and prompts the cashier for the remaining $35 balance via another payment method (split tender).
5. Click **Complete Sale**. The redeemed amount is deducted from the gift card balance in the database.

---

## 4. Recharging Gift Card Balances

Customers can add additional funds to an existing card at any time:

1. Navigate to **Gift Cards**.
2. Search for the card number or customer name.
3. Click the **Edit** icon.
4. Increase the **Value** field by the top-up amount.
5. Save the updated balance.

