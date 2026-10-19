---
title: First Steps & Store Setup
description: Initial setup checklist after logging in to Open Source Point of Sale for the first time.
---

Welcome to Open Source Point of Sale! Once you have installed OSPOS and logged in for the first time, follow this checklist to configure your business profile, taxation, localization, and first inventory items.

---

## 1. Initial Login & Change Default Password

Open your browser and navigate to your OSPOS URL (e.g. `http://localhost` or `https://pos.yourstore.com`).

Default administrative login:
- **Username**: `admin`
- **Password**: `pointofsale`

:::caution[Security Action Required]
Never leave the default credentials on a live system! Anyone with network access can log in and view sensitive sales and customer data.
:::

1. Click on **Employees** in the top navigation bar.
2. Find the row for `admin` (Administrator) and click the **Edit** (pencil) icon.
3. Scroll down to the **Login Information** section.
4. Enter a new, secure password in **Password** and confirm it in **Password Again**.
5. Update the **First Name**, **Last Name**, and **Email** to your real contact details.
6. Click **Submit** to save.

---

## 2. Configure Store Information

Navigate to **Store Config** (the gear icon or menu in the top bar):

1. **Company Name**: Your legal or trade business name (appears on receipts, invoices, and browser tabs).
2. **Company Logo**: Upload your store logo (PNG, JPG, or SVG). This appears on printed and emailed receipts and quotes.
3. **Address, Phone, and Email**: Displayed on receipt headers and customer invoices.
4. **Website**: Your store's website URL.
5. **Return Policy**: The policy printed at the bottom of every receipt (e.g. *"Returns accepted within 14 days with original receipt in unworn condition"*).

---

## 3. Localization, Currency & Timezone

In **Store Config**, scroll to the **Localization** section:

- **Timezone**: Select your local timezone (e.g. `America/New_York`, `Europe/London`, `Asia/Tokyo`).
  :::important[Correct Timezone is Critical]
  Sales transactions, cashup till closings, and daily sales reports depend on the correct timezone to group transactions by the actual calendar day.
  :::
- **Language**: Select your primary UI language (English, Spanish, French, German, Dutch, Portuguese, Arabic, Hindi, etc.).
- **Currency Symbol**: Enter your currency sign (`$`, `€`, `£`, `₹`, `¥`, `R$`, etc.).
- **Currency Side**: Choose whether the currency symbol appears before (`$10.00`) or after (`10.00 €`) the number.
- **Decimal Separator**: Choose `.` (dot) or `,` (comma) based on your country's conventions.
- **Thousands Separator**: Choose `,`, `.`, or space.
- **Number of Decimals**: Typically `2` for most currencies (or `0` for currencies like JPY/KRW).

---

## 4. Set Up Stock Locations

OSPOS supports multi-location stock tracking. If your store has multiple registers, a stockroom, or a warehouse:

1. In **Store Config**, find **Stock Locations**.
2. By default, you have a primary location (e.g., `default` or `stock_location_1`).
3. Rename it to a clear, meaningful name, such as `Main Counter`, `Retail Floor`, or `Warehouse`.
4. You can add additional locations (e.g., `Backroom Storage`, `Kitchen Fridge`) as needed.

---

## 5. Configure Tax Rates

Set up your local sales tax or VAT so that items calculate tax properly during checkout:

1. Navigate to **Store Config** $\rightarrow$ **Taxes**.
2. Select your tax mode:
   - **Sales Tax** (Tax added on top of the item price at checkout, standard in the US/Canada).
   - **VAT / Inclusive Tax** (Tax already included in the retail price on the shelf, standard in Europe/UK/Australia).
   - **India GST** (Specialized CGST, SGST, IGST with HSN codes).
3. Set your default **Tax Rate %** (e.g. `8.25` or `20.00`).
4. Click **Submit** to apply.

---

## 6. Add Your First Product

Now you're ready to add inventory!

1. Click on **Items** in the top navigation bar.
2. Click the **+ New Item** button.
3. Fill in the details:
   - **Item Name**: e.g., `Organic Dark Roast Coffee 250g`
   - **Barcode / Item Number**: Scan a barcode with your scanner or type a unique SKU. (If left blank, OSPOS can auto-generate one).
   - **Category**: e.g., `Beverages`
   - **Cost Price**: What you paid for the product (used to calculate profit margins).
   - **Retail Price**: What the customer pays before (or including) tax.
   - **Quantity**: Starting physical inventory count for your stock location.
   - **Reorder Level**: Threshold at which OSPOS alerts you that stock is running low.
4. Click **Submit**.

---

## 7. Run a Test Sale

1. Click on **Sales** in the top navigation bar to open the POS register.
2. Type the item name or scan the barcode into the **Find/Scan Item** box and press Enter.
3. The item will appear in your register cart with its price and tax calculated.
4. In the **Payment** section on the right, select **Cash** and enter the amount tendered (e.g. `$20.00`).
5. Click **Add Payment**, then click **Complete Sale**.
6. The receipt dialog will pop up showing the invoice breakdown, change due, and receipt print preview.

Congratulations! Your Open Source Point of Sale store is operational and ready for business.

