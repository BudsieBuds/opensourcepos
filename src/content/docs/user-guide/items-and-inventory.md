---
title: Items & Inventory Management
description: Managing products, serialized items, multi-location stock, CSV bulk import, and physical stocktaking.
---

Open Source Point of Sale provides an inventory management system capable of tracking physical products, non-stock services, serialized items, and multi-location warehouses.

---

## 1. Stock Types & Item Classification

When creating a product in **Items** $\rightarrow$ **+ New Item**, OSPOS differentiates between inventory tracking and item behavior:

### Stock Type (`stock_type`)
- **Stock Item (`HAS_STOCK`)**: Physical goods tracked per stock location. Deducted when sold, replenished when received.
- **Non-Stock / Service (`HAS_NO_STOCK`)**: Services, digital goods, labor hours, and fees that never run out of inventory.

### Item Type (`item_type`)
- **Standard (`ITEM`)**: A regular standalone product.
- **Kit (`ITEM_KIT`)**: A composite bundle made up of individual components (see [Item Kits](/user-guide/item-kits/)).
- **Amount Entry (`ITEM_AMOUNT_ENTRY`)**: Prompts the cashier to enter the dollar amount at checkout (useful for open-price items, custom alterations, or variable weighings).
- **Temporary (`ITEM_TEMP`)**: Ad-hoc products created for one-off sales without polluting the permanent catalog.

### Serial Tracking & Multi-Pack Packaging
- **Serialized (`is_serialized`)**: Prompts the cashier to enter or scan a unique serial number each time the item is sold (recorded on the receipt and invoice for warranty audits).
- **Multi-Packs (`multi_pack_enabled`)**: Link a wholesale pack (e.g. *"6-Pack"* or *"Case of 24"*) to an individual loose unit (`low_sell_item`). When the multi-pack is sold, OSPOS automatically deducts the equivalent quantity from single-item inventory.

---

## 2. Product Fields Explained

- **Item Number (Barcode / SKU)**: The barcode scanned at checkout. If left blank, OSPOS can generate a unique barcode.
- **Item Name**: The primary product title displayed on register and receipts.
- **Category**: Product department (e.g. *Beverages*, *Apparel*, *Hardware*). Can be configured as a dropdown or free-text field in store settings.
- **Cost Price**: Wholesale purchase cost per unit. Used to calculate gross profit margins and inventory valuation.
- **Unit Price (Retail Price)**: The selling price to the customer.
- **Tax Category**: Assigns standard tax rates, reduced rates, or tax-exempt status to the item.
- **Reorder Level**: The minimum inventory threshold. When stock falls below this level, the item appears on the **Low Inventory Report**.
- **Receiving Quantity**: Default order packaging multiplier (e.g., 12 units per carton).
- **Allow Alt Description**: Permits cashiers to customize or add notes to the item description during a sale.

---

## 3. Multi-Location Stock Allocation

If your business operates multiple sales registers, backroom stockrooms, or regional branches:

1. In the Item edit modal, open the **Stock** tab.
2. You will see an entry for every active **Stock Location** configured in your store.
3. You can set independent:
   - **Quantity on Hand** per location
   - **Reorder Levels** per location
4. When ringing up sales, the register deducts stock from the cashier's active stock location.

---

## 4. Bulk Import & Export via CSV

When setting up a new store or importing catalogs with hundreds or thousands of SKUs:

### Exporting Current Catalog
1. Navigate to **Items**.
2. Click **Export CSV** (or Excel).
3. Download the `.csv` file. This is also the best template for formatting bulk imports.

### Importing New Items
1. Click **Import CSV**.
2. Download the sample CSV template to ensure your column headers match exactly:
   ```csv
   Item Name,Barcode,Category,Cost Price,Unit Price,Tax 1 Name,Tax 1 Percent,Quantity,Reorder Level,Description
   "Arabica Coffee Beans 1kg","789123456789","Beverages",12.50,22.00,"Sales Tax",8.00,50,10,"Fresh roasted beans"
   "Espresso Mug Ceramic","789123456790","Merchandise",3.00,8.50,"Sales Tax",8.00,100,20,"OSPOS branded mug"
   ```
3. Choose your file and click **Submit**.
4. OSPOS validates the data and imports all products, creating categories and stock counts automatically.

---

## 5. Stocktaking (Physical Inventory Audits)

Periodic physical stock counts ensure your system inventory matches what is actually sitting on your shelves.

1. Navigate to **Items** $\rightarrow$ **Inventory** (or **Stocktake**).
2. Filter by category, supplier, or location.
3. Count the physical items on your shelves.
4. Enter the counted physical quantity in the **Counted** column.
5. OSPOS calculates the **Variance**:
   $$\text{Variance} = \text{Counted Quantity} - \text{System Expected Quantity}$$
6. Enter an adjustment reason (e.g. *"Monthly count"*, *"Damaged during transit"*, *"Theft / Shrinkage"*).
7. Submit the audit. OSPOS adjusts inventory counts and logs the adjustment for auditing and tax compliance.

