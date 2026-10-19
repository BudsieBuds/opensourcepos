---
title: Reports, Analytics & Exports
description: Generate business intelligence reports for sales, inventory valuation, taxes, profit margins, and CSV export.
---

Open Source Point of Sale provides a suite of reporting tools to track business performance, identify top-selling products, audit inventory valuation, and prepare tax filings.

---

## 1. Report Categories

Navigate to **Reports** in the main navigation. Reports are grouped into three primary display formats:

| Format | Description |
| :--- | :--- |
| **Summary Reports** | Aggregated totals grouped by key dimensions (e.g., total sales grouped by category, day, or payment method). |
| **Detailed Reports** | Transaction-level drilldowns showing every individual line item, cashier timestamp, invoice number, and tax rate. |
| **Graphical Reports** | Visual trend charts (bar charts, line graphs) for visual sales velocity and revenue trends. |

---

## 2. Core Business Reports

### Sales Reports
- **Sales by Date**: Daily, weekly, monthly, or custom date range sales breakdown. Displays gross revenue, net revenue, taxes collected, and cost of goods sold (COGS).
- **Sales by Category**: Identifies your most profitable departments (e.g. *Beverages* vs *Food* vs *Merchandise*).
- **Sales by Item**: Ranks products by units sold and revenue generated. Essential for deciding which products to restock or discontinue.
- **Sales by Employee**: Audits cashier productivity, total transactions handled, and commissions.
- **Sales by Customer**: Tracks spending totals for your top VIP customers.
- **Sales by Payment Type**: Reconciles card transactions against your merchant processing terminal batch, cash deposits against bank slips, and checks.

### Inventory Reports
- **Low Inventory Report**: Lists all products currently at or below their configured **Reorder Level**, along with recommended reorder quantities and supplier details.
- **Inventory Valuation**: Calculates the total capital tied up in inventory:
  $$\text{Total Cost Value} = \sum (\text{Qty on Hand} \times \text{Cost Price})$$
  $$\text{Total Retail Value} = \sum (\text{Qty on Hand} \times \text{Retail Price})$$
  $$\text{Potential Gross Margin} = \text{Total Retail Value} - \text{Total Cost Value}$$
- **Inventory Movements / Audit Log**: Shows every single addition, subtraction, transfer, and physical count adjustment made to an item over time, along with the employee responsible and the reason code.

### Tax & Accounting Reports
- **Taxes Summary**: Breaks down total collected taxes by tax rate and tax jurisdiction. Crucial for filing monthly or quarterly state sales tax or VAT returns.
- **India GST Report**: Detailed breakdown of CGST, SGST, and IGST by HSN/SAC codes for GSTR-1 preparation.
- **Discounts Report**: Audits all line-item and cart-level discounts applied by cashiers to detect unauthorized margin erosion.
- **Expenses Report**: Itemizes operational expenses by category, payee, and payment method.

---

## 3. Filtering & Date Parameters

Every report allows granular filtering:

- **Date Range**: Quick presets (*Today*, *Yesterday*, *Last 7 Days*, *This Month*, *Last Month*, *This Year*) or custom calendar date pickers.
- **Location Filter**: Run reports across all store locations or filter to a single register or warehouse branch.
- **Sale Type**: Filter between standard *Sales*, *Returns*, *Estimates*, or *Work Orders*.

---

## 4. Exporting & Sharing Data

- **CSV / Excel Export**: Every report includes a one-click **Export to CSV** button. You can open the raw data directly in Microsoft Excel, Google Sheets, or import it into accounting software like QuickBooks, Xero, or Odoo.
- **Printable PDF**: Generates a clean, paginated PDF with your store logo and header, formatted for standard letter or A4 paper.

