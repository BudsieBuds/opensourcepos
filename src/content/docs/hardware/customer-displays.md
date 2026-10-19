---
title: Customer-Facing Secondary Displays
description: Set up customer-facing checkout screens, secondary monitors, and customer display views in OSPOS.
---

Customer displays provide transparency at the checkout counter by showing line items as they are rung up, live tax calculations, subtotal balances, and change due.

---

## 1. Dual-Monitor Customer Checkout Display

The modern standard for retail stores is a customer-facing display powered by a secondary monitor or tablet connected to the register workstation.

### How to Configure Dual-Monitor Display:
1. Connect a second monitor to your register PC (via HDMI, DisplayPort, or USB-C) and angle it toward the customer.
2. In your operating system display settings, choose **Extend these displays** (do not select duplicate/mirror).
3. Open a second browser window and navigate to the customer display view.
4. Drag the window to the customer-facing monitor and press **F11** to toggle full-screen mode.
5. As the cashier scans items on the primary screen, the customer monitor displays the itemized cart, prices, and savings in real time.

---

## 2. Upcoming WebShells Secondary Display

The OSPOS development community is actively developing the **WebShells Secondary Display** integration:
- Includes dedicated customer animations, cart updates, and full-screen promotional image and video slideshows when the register is idle.
- Automatic pairing between cashier registers and remote tablets or secondary screens over local WebSockets.

---

## 3. Traditional 2-Line VFD Pole Displays

Traditional 2-line $\times$ 20-character fluorescent pole displays (Logic Controls, Posiflex, Epson) communicate via **RS-232 Serial** or **USB Virtual COM Port**:
- Baud rate is typically `9600`, 8 data bits, no parity, 1 stop bit (`9600-8-N-1`).
- Line 1 displays the item description.
- Line 2 displays the quantity and price, or the final change due upon sale completion.
