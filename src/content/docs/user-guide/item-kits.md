---
title: Item Kits & Product Bundles
description: Create bundled products, combo meals, and assembly packages that automatically deduct component inventory.
---

An **Item Kit** is a composite product made up of one or more individual inventory items. When an Item Kit is sold at the register, OSPOS automatically deducts the individual component items from your inventory in real time.

Common examples include:
- **Retail Bundles**: A "Grooming Gift Set" containing 1 bottle of shampoo, 1 razor, and 1 shaving cream.
- **Restaurant Combos**: A "Lunch Combo" containing 1 burger, 1 french fries, and 1 soda.
- **Hardware Packages**: A "Mounting Kit" containing 4 bolts, 4 anchors, and 1 steel bracket.
- **Service Packages**: An "Oil Change Package" containing 5 quarts of motor oil, 1 oil filter, and 1 hour of labor.

---

## 1. Creating an Item Kit

1. In the top navigation menu, click **Item Kits**.
2. Click the **+ New Item Kit** button.
3. Enter the kit information:
   - **Item Kit Name**: e.g., *Summer BBQ Party Pack*
   - **Barcode / Item Number**: Scan or assign a barcode to the kit so cashiers can ring up the entire bundle with a single scan.
   - **Category**: e.g., *Promotions* or *Gift Sets*
   - **Description**: Detailed customer description.

---

## 2. Adding Component Items to the Kit

In the **Items** section of the Item Kit form:

1. Search for a product by name or barcode.
2. Select the item and specify the **Quantity** required for one kit:
   - *Example*: `Burger Patty` $\rightarrow$ Quantity: `1`
   - *Example*: `French Fries` $\rightarrow$ Quantity: `1`
   - *Example*: `Can of Soda` $\rightarrow$ Quantity: `1`
3. Click **Add Item** to attach it to the kit.
4. Repeat for all components in the bundle.

---

## 3. Price Options & Kit Discounts

Item Kits support flexible pricing and discounting directly on the kit edit form:

### Kit Discount
You can apply a bundle-level discount:
- **Percent**: e.g., `10%` off the total kit price.
- **Fixed Amount**: e.g., `$5.00` off the combined total.

### Price Options (`price_option`)
Configure how the kit interacts with component unit prices:

| Price Option | Description | Best For |
| :--- | :--- | :--- |
| **Kit and Components** (`PRICE_ALL`) | Calculates price from component sum, while displaying both kit and individual component prices. | Assemblies and service packages where customers see individual component costs. |
| **Kit Only** (`PRICE_KIT`) | Overrides all component prices with a single fixed bundle price. | Holiday gift packs and promotional combo meals with fixed package pricing. |
| **Kit and Stock** (`PRICE_KIT_ITEMS`) | Sum of stock item components with stock-level pricing rules applied. | Custom manufacturing or variable-stock kits. |

---

## 4. How Inventory Works for Kits

:::important[Automatic Component Deduction]
Item Kits do **not** maintain a separate standalone inventory count. Instead, inventory is tracked at the component item level.
:::

When a cashier sells **1 Item Kit**:
- Component Item A inventory: decreased by its kit quantity
- Component Item B inventory: decreased by its kit quantity
- Component Item C inventory: decreased by its kit quantity

If any component item is out of stock, OSPOS will warn the cashier that component inventory is insufficient.

---

## 5. Receipt Print Options (`print_option`)

You can control how item kits appear on receipts given to customers:

| Print Option | Receipt Presentation |
| :--- | :--- |
| **All** (`PRINT_ALL`) | Prints the Kit title line, followed by every individual component item name and quantity indented underneath. |
| **Priced Only** (`PRINT_PRICED`) | Prints the Kit title line, but only itemizes components that have a unit price greater than zero (hiding free/zero-cost items). |
| **Kit Only** (`PRINT_KIT`) | Prints strictly the main Kit title and bundle total, completely hiding the internal component item list from the customer. |


