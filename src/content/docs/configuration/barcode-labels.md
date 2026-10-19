---
title: Barcode Label Generation & Printing
description: Design and print adhesive barcode price tags and shelf labels using sheet templates or dedicated thermal printers.
---

Open Source Point of Sale can generate and print barcode price stickers for products, shelf tags for retail displays, and serial number labels.

---

## 1. Supported Label Printing Methods

1. **Standard Desktop Printer (Sheet Labels)**:
   - Uses standard Letter or A4 adhesive sticker sheets (e.g. Avery 5160, 5163, Herma, or L7160).
   - Works with any standard office laser or inkjet printer.
2. **Dedicated Thermal Label Printers (Roll Labels)**:
   - Direct thermal label printers (Zebra ZD410/ZD420, Brother QL series, TSC, Munbyn).
   - Fast, continuous roll printing with zero ink or toner costs.

---

## 2. Generating Labels from Inventory

### Printing for Selected Items
1. Navigate to **Items**.
2. Filter or search for the products you need labels for.
3. Check the selection boxes next to the target items.
4. Click the **Generate Barcodes** button at the top of the table.

### Printing Labels Directly Upon Receiving Stock
When new inventory shipments arrive at your store:
1. In **Receivings**, finish receiving the purchase order.
2. Click **Print Barcodes**.
3. OSPOS automatically generates the exact number of barcode stickers corresponding to the quantities received in that delivery!

---

## 3. Label Layout Configuration

Navigate to **Store Config** $\rightarrow$ **Barcode**:

You can configure what information appears on each printed barcode sticker:

- **Store Name**: Prints your shop name across the top.
- **Item Name**: Product title (auto-sized to fit the label width).
- **Barcode Symbology**:
  - `Code 128`: Best for alphanumeric SKUs.
  - `EAN-13` / `UPC-A`: Standard numeric retail barcodes.
- **Retail Price**: Displays the selling price prominently with your currency symbol.
- **Label Dimensions**:
  - Width and Height (in inches or millimeters).
  - Labels per row (e.g., `3` columns for standard Avery 5160).
  - Margins and padding (to calibrate alignment with die-cut sticker sheets).

---

## 4. Printer Calibration Tips

- **Turn Off "Fit to Page"**: In the browser print dialog, always set **Scale** to `100%` or `Actual Size`. If "Fit to Printable Area" is checked, the browser will shrink the labels slightly, causing each subsequent row on the sticker sheet to drift out of alignment.
- **Set Margins to "None"**: In Chrome/Firefox print settings, set **Margins** to `None` to prevent the browser from injecting top/bottom header dates and page numbers.
- **Thermal Roll Pitch**: On dedicated thermal printers (like Zebra), ensure your printer driver's media settings are set to **"Die-Cut Labels with Gap"** so the printer's optical sensor detects where each label begins and ends.

