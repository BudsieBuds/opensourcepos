---
title: Receiving, Suppliers & Stock Transfers
description: Manage vendors, purchase orders, receiving new inventory shipments, and inter-location transfers.
---

The **Receivings** module handles purchasing and stock replenishment. It tracks which suppliers you buy from, updates wholesale cost prices, increases on-hand inventory levels, and transfers stock between locations.

---

## 1. Managing Suppliers

Before receiving stock, set up your vendors:

1. Click **Suppliers** in the main navigation.
2. Click **+ New Supplier**.
3. Fill in the vendor profile:
   - **Company Name**: e.g., *Acme Wholesale Distributors Ltd.*
   - **Agency / Contact Person**: Name of your account representative.
   - **Account Number**: Your customer ID with the supplier.
   - **Tax ID**: Supplier's VAT or GST registration number.
   - **Email and Phone**: Used for emailing purchase orders directly.
4. Click **Submit**.

---

## 2. Receiving New Inventory Shipments

When a shipment arrives at your loading dock or store counter:

1. Click **Receivings** in the main navigation.
2. Ensure the mode is set to **Receive** (top left dropdown).
3. Select your **Stock Location** (where the inventory is physically being placed, e.g. *Main Warehouse* or *Retail Store*).
4. Select the **Supplier** from the right-hand panel.
5. Add items to the receiving order by scanning barcodes or typing item names.
6. Verify and update:
   - **Quantity Received**: The number of units in the delivery.
   - **Cost Price**: What you were invoiced per unit. (Updating the cost price updates your inventory valuation and profit calculations).
7. Select the payment method used to pay the supplier (e.g. *Cash*, *Check*, *Bank Transfer / Due*).
8. Click **Complete Receiving**.

:::note[Immediate Stock Update & Weighted Average Costing]
Upon completing the receiving order, the quantities are immediately added to your on-hand stock count.

If **Calculate Average Price (Receiving)** is enabled in **Store Config** $\rightarrow$ **General**, OSPOS automatically recalculates the product's inventory cost price using a weighted average formula:

$$\text{New Cost Price} = \frac{(\text{Items Received} \times \text{Invoice Price}) + (\text{Current Stock} \times \text{Existing Cost Price})}{\text{Current Stock} + \text{Items Received}}$$

This ensures your profit margins and accounting valuations remain mathematically accurate even when wholesale supplier prices fluctuate between deliveries.
:::

---

## 3. Returning Goods to Suppliers

If merchandise arrives damaged, defective, or incorrect:

1. Open **Receivings**.
2. Switch the mode dropdown from **Receive** to **Return**.
3. Select the supplier.
4. Scan or add the items being sent back.
5. The quantities will appear as negative numbers.
6. Click **Complete Receiving**.
7. Inventory counts are reduced accordingly, and a return receipt is generated for your credit memo records.

---

## 4. Requisitions (Inter-Location Stock Transfers)

If you operate multiple locations (such as a *Central Warehouse* and *Register 1*, or *Main Store* and *Event Kiosk*), use **Requisitions** to transfer inventory between them without creating financial sales transactions:

1. In **Receivings**, switch the mode dropdown to **Requisition**.
2. Select:
   - **Source Location**: The location sending the stock (e.g. *Central Warehouse*).
   - **Destination Location**: The location receiving the stock (e.g. *Downtown Counter*).
3. Scan or enter the items and quantities being moved.
4. Click **Complete Requisition**.
5. OSPOS performs a zero-dollar transfer:
   - Deducts the quantity from the Source Location.
   - Adds the quantity to the Destination Location.
   - Generates a transfer manifest slip for the transport driver.

