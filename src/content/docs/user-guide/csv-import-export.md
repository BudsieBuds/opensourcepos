---
title: CSV Bulk Import & Export Specification
description: Complete specification for bulk importing and exporting items, categories, and inventory via CSV.
---

Open Source Point of Sale includes a high-capacity CSV import and export tool. You can migrate existing inventory catalogs from spreadsheets, bulk update retail prices, and export transaction data for analysis.

---

## 1. CSV File Requirements

- **File Encoding**: **UTF-8** (Crucial: Excel on Windows often defaults to ANSI or Windows-1252, which corrupts non-English characters and symbols).
- **Delimiter**: Comma (`,`).
- **Enclosure**: Double quotes (`"`) around text fields containing commas or whitespace.
- **Header Row**: The first row **must** contain exact column names recognized by OSPOS.

---

## 2. Column Specification Table

| Column Header | Data Type | Required? | Description & Example |
| :--- | :--- | :---: | :--- |
| **`Item Name`** | String (255) | **YES** | Product name. *Example: `"Whole Milk 1L"`* |
| **`Barcode`** | String (255) | Optional | Unique barcode or SKU. If blank, OSPOS generates one. *Example: `"012345678905"`* |
| **`Category`** | String (255) | **YES** | Product classification. Auto-created if it does not exist. *Example: `"Dairy"`* |
| **`Cost Price`** | Decimal (15,2) | **YES** | Wholesale purchase cost. *Example: `1.85`* |
| **`Unit Price`** | Decimal (15,2) | **YES** | Retail selling price before/including tax. *Example: `3.49`* |
| **`Tax 1 Name`** | String (255) | Optional | Tax label. *Example: `"Sales Tax"` or `"VAT"`* |
| **`Tax 1 Percent`** | Decimal (15,2) | Optional | Tax percentage rate. *Example: `8.25`* |
| **`Quantity`** | Decimal (15,2) | Optional | Starting on-hand stock for default location. *Example: `50`* |
| **`Reorder Level`** | Decimal (15,2) | Optional | Low stock alert threshold. *Example: `10`* |
| **`Description`** | Text | Optional | Extended product notes or ingredients. |
| **`Allow Alt Description`** | Integer (0 or 1) | Optional | `1` = cashier can edit description at register. |
| **`Is Serialized`** | Integer (0 or 1) | Optional | `1` = prompts for serial number at checkout. |

---

## 3. Sample CSV File Template

You can copy and save this text directly as `sample_import.csv`:

```csv
Item Name,Barcode,Category,Cost Price,Unit Price,Tax 1 Name,Tax 1 Percent,Quantity,Reorder Level,Description,Allow Alt Description,Is Serialized
"Fairtrade Colombian Ground Coffee 250g","074812345601","Beverages",4.20,8.99,"VAT",20.00,45,10,"100% Arabica dark roast",0,0
"Earl Grey Loose Leaf Tea 100g","074812345602","Beverages",2.50,5.50,"VAT",20.00,30,8,"Bergamot infused black tea",0,0
"Artisan Ceramic Coffee Mug","074812345603","Merchandise",3.00,9.95,"VAT",20.00,20,5,"Dishwasher safe handmade mug",0,0
"Store Gift Box Packaging","","Packaging",0.40,1.50,"VAT",20.00,100,25,"Recycled kraft paper box",0,0
"Digital Barista Scale with Timer","074812345605","Equipment",18.00,34.99,"VAT",20.00,12,3,"0.1g accuracy scale",0,1
```

---

## 4. Bulk Updating Existing Items

The CSV import tool can also be used to update existing items in bulk:

1. Go to **Items** $\rightarrow$ **Export CSV**.
2. Open the file in your spreadsheet editor (Excel, LibreOffice Calc, or Google Sheets).
3. Update prices, descriptions, or reorder levels.
   :::caution[Do Not Alter Barcodes or Item IDs]
   OSPOS matches existing products by **Barcode** or internal **Item ID**. As long as the barcode or ID matches, OSPOS will **update** the existing product rather than creating a duplicate!
   :::
4. Save the spreadsheet as a CSV file with **UTF-8 encoding**.
5. Go to **Items** $\rightarrow$ **Import CSV** and submit.

---

## 5. Troubleshooting Import Errors

- **Error: "Invalid CSV file format"**: Ensure text fields with commas (like `"Widgets, Inc."`) are wrapped in double quotes.
- **Error: "Duplicate Barcode"**: Two rows in your spreadsheet contain the same barcode value. Every product must have a unique barcode or leave it blank.
- **Accented or foreign characters look corrupted (`Ã©` instead of `é`)**: The file was saved in ANSI or Windows-1252. In Excel, choose **Save As** $\rightarrow$ **CSV UTF-8 (Comma delimited) (*.csv)**.

