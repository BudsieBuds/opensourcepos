---
title: Barcode Scanners (1D / 2D QR)
description: Connect, program, and use handheld USB, wireless, and presentation barcode scanners with OSPOS.
---

Open Source Point of Sale supports virtually every barcode scanner on the market. Scanners operate as **USB HID Keyboard Wedge** devices, meaning they require **zero drivers** and work out-of-the-box on Windows, Linux, macOS, Android, and Raspberry Pi.

---

## 1. Scanner Types & Form Factors

| Type | Reading Capability | Best For |
| :--- | :--- | :--- |
| **1D Handheld Scanner** | Standard linear barcodes (UPC-A, EAN-13, Code 128, Code 39). | Standard retail counters, clothing, groceries, books. |
| **2D Area Imager** | 1D barcodes + 2D codes (QR Codes, DataMatrix, PDF417). Reads from smartphone screens. | Stores accepting digital coupons, mobile loyalty passes, and event ticketing. |
| **Wireless / Bluetooth** | Cordless scanning with charging cradle or Bluetooth pairing. | Large items, lumber yards, garden centers, inventory stocktaking in warehouse aisles. |
| **Hands-Free Presentation** | Omnidirectional stationary scanner mounted on the checkout counter. | High-throughput supermarkets, busy convenience stores. |

---

## 2. How Scanners Work: Keyboard Wedge Mode

When you plug in a USB scanner:
1. The operating system detects it as a standard USB keyboard.
2. When you scan a product barcode (e.g. `012345678905`), the scanner instantly "types" the numbers into whatever input box is currently active on your screen.
3. In OSPOS, the **Find/Scan Item** field in the Sales register is automatically focused on page load and after every completed transaction.

---

## 3. Essential Scanner Configuration: The "Enter" Key Suffix

:::important[Critical Scanner Setup Step]
For seamless hands-free cashier operation, your scanner **must send an Enter key (Carriage Return / CR)** immediately after reading a barcode. This automatically submits the item into the shopping cart without the cashier touching the keyboard or mouse!
:::

Most scanners ship from the factory with this enabled, but if your scanned items do not automatically enter the cart:

1. Locate the **Quick Start Guide** or user manual that came in your scanner's box.
2. Find the programming section labeled **Suffix Configuration** or **Carriage Return / Enter Key**.
3. Scan the programming barcode labeled **"Add CR Suffix"** or **"Add Enter Key"**.

*(For Zebra / Motorola scanners like LS2208 or DS2208, scan: `Scan Options` $\rightarrow$ `<DATA><SUFFIX>` $\rightarrow$ `Enter Key`).*

---

## 4. Barcode Symbology Support

OSPOS natively generates and reads:
- **EAN-13 / EAN-8**: Standard European and international retail barcodes.
- **UPC-A / UPC-E**: Standard North American retail barcodes.
- **Code 128**: High-density alphanumeric barcode. Best for internal inventory SKUs, customer IDs, and gift cards.
- **Code 39**: Industrial alphanumeric code.
- **QR Codes**: 2D codes for mobile payments, digital invoices, and website product lookups.

---

## 5. Printing Barcode Labels from OSPOS

OSPOS can generate and print barcode sticker labels for all your products:

1. Navigate to **Items**.
2. Select the checkbox next to the items you want to print labels for.
3. Click the **Generate Barcodes** button at the top of the table.
4. Choose your label sheet template (e.g., standard Avery 5160 30-label sheets, jewelry butterfly labels, or continuous thermal label rolls).
5. Print to your desktop laser printer or dedicated thermal label printer (Zebra, Brother, Dymo).

