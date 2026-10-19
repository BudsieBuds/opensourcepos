---
title: Item Attributes & Custom Variants
description: Define custom product attributes like size, color, brand, vintage, or expiry dates for specialized retail.
---

Not all retail inventory fits into standard product fields. An apparel shop needs to track **Size** and **Color**, a wine merchant needs **Vintage** and **Region**, and a specialty grocer needs **Expiration Dates** and **Dietary Flags**.

Open Source Point of Sale provides an extensible **Item Attributes** system that lets you create custom metadata fields for your inventory.

---

## 1. Defining Attribute Types

Navigate to **Store Config** $\rightarrow$ **Attributes** (or **Items** $\rightarrow$ **Attributes**):

Click **+ New Attribute** to configure a custom field:

1. **Attribute Name**: e.g., `Size`, `Color`, `Brand`, `Vintage`, `Expiration Date`, or `Technical Specs`.
2. **Definition Type**:
   - **`GROUP`**: A container header used to group related attributes together into a visual block or fieldset (e.g. *"Specifications"* or *"Apparel Sizing"*).
   - **`DROPDOWN`**: A controlled selection list of predefined values (e.g., `Small`, `Medium`, `Large`, `XL`). Prevents spelling mistakes and standardizes filtering.
   - **`DECIMAL`**: Exact numeric values (e.g., ABV percentage, engine displacement, dimensions).
   - **`DATE`**: Calendar date picker (ideal for food expiration or manufacturer warranty end dates).
   - **`TEXT`**: Freeform alphanumeric string entry (e.g., custom model numbers or technician notes).
   - **`CHECKBOX`**: Boolean toggle flag (`1` or `0`, e.g., `Gluten Free`, `Organic`, `Hazardous Material`).

---

## 2. Granular Visibility & Search Flags

Each attribute can be individually controlled across four key touchpoints:

| Flag | Meaning | Use Case |
| :--- | :--- | :--- |
| **Show in Items** | Displays on the Item create/edit form | Back-office catalog management. |
| **Show in Sales** | Appears on the live counter register cart line | Cashier view (e.g., garment size or warranty term). |
| **Show in Receivings** | Displays when receiving stock shipments from vendors | Verifying expiry dates or batch numbers on delivery. |
| **Show in Search** | Indexes the attribute for cashier autocomplete lookup | Searching `"Navy L"` matches products with Color=Navy and Size=L. |

---

## 3. Setting Up Pre-defined Dropdown Values

For `DROPDOWN` attributes (like `Size` or `Color`), add your allowable options:

- **Size**: `XS`, `S`, `M`, `L`, `XL`, `XXL`
- **Color**: `Black`, `White`, `Navy Blue`, `Heather Gray`, `Crimson`
- **Condition**: `New in Box`, `Open Box`, `Refurbished`, `Used`

---

## 4. Assigning Attributes to Products

Once attributes are defined, they appear on every item edit form:

1. Go to **Items** and edit an existing product or create a new one.
2. Open the **Attributes** tab.
3. Select or enter values for the relevant attributes:
   - *Size*: `Large`
   - *Color*: `Navy Blue`
   - *Brand*: `Patagonia`
   - *Expiry*: `2027-12-31`
4. Click **Submit** to save.

---

## 5. Searching and Register Operations

Item attributes are fully indexed in search:

- **Register Autocomplete**: Cashiers can search directly by attribute. For example, typing `"Polo Navy L"` will instantly match the navy blue, size Large polo shirt.
- **Inventory Filtering**: Filter the item management table by specific attributes to see all products matching a size, brand, or seasonal collection.
- **Reporting**: Generate inventory reports grouped by attribute to analyze which colors or sizes have the highest sales velocity.

