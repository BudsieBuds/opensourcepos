---
title: Cash Drawers
description: Connect, configure, and troubleshoot automatic cash drawers via receipt printer RJ11/RJ12 drawer kick ports.
---

Standard point-of-sale cash drawers do not connect directly to a computer via USB. Instead, they use a standard **6-pin RJ11 or RJ12 modular cable** that plugs directly into the back of your thermal receipt printer.

When a sale completes and the printer prints a ticket, the receipt printer sends an electrical pulse (12V or 24V) down this cable, releasing the internal spring latch and popping the cash drawer open.

---

## 1. Physical Wiring Setup

```
[POS Workstation] ──(USB / LAN)──> [Receipt Printer] ──(RJ11 / RJ12 Cable)──> [Cash Drawer]
```

1. Locate the **Drawer Kick (DK)** port on the back of your thermal receipt printer (it looks like a telephone jack, labeled *DK* or marked with a drawer symbol).
2. Connect one end of the RJ11/RJ12 cable to the printer's DK port.
3. Connect the other end to the bottom or rear connector of your cash drawer.
4. Insert the physical key into the lock on the front of the drawer and turn it to the **Unlocked / Vertical** position.
   :::caution[Key Position]
   If the physical key is in the locked horizontal position, the electronic solenoid will trigger, but the drawer will remain mechanically locked. Always leave keys in the vertical position during business hours.
   :::

---

## 2. Triggering the Drawer via the Printer Driver

Because OSPOS utilizes browser-based printing, the cash drawer kick is triggered by the receipt printer's native operating system driver whenever a print job executes:

### Windows Driver Configuration:
1. Open **Settings** $\rightarrow$ **Printers & Scanners**.
2. Select your thermal receipt printer and click **Manage** $\rightarrow$ **Printer Properties**.
3. Navigate to the **Device Settings** tab (or *Document Defaults* depending on printer manufacturer).
4. Locate the **Cash Drawer** setting:
   - **Cash Drawer 1**: Set to **Open Before Printing** (or *Open After Printing*).
   - **Pulse Duration**: Typically default (e.g. 50ms).
5. Click **Apply** and **OK**.

Whenever OSPOS completes a cash checkout and sends the receipt to the printer, the driver automatically kicks the cash drawer open.

---

## 3. Dedicated USB Cash Drawers

If your checkout counter uses a dedicated USB cash drawer (or a USB-to-RJ11 trigger dongle like Prolific or FTDI) instead of connecting through a receipt printer:
- The USB drawer installs a virtual COM port driver (e.g. `COM3` on Windows).
- Most USB drawers include a background utility or virtual print driver that triggers the solenoid on print events.

---

## 4. Troubleshooting Cash Drawer Failures

| Symptom | Cause | Solution |
| :--- | :--- | :--- |
| **Drawer does not open at all** | Key is in locked position | Turn key to vertical (electronic operation) position. |
| **Drawer does not open at all** | Cable in wrong printer port | Ensure the RJ11 cable is in the **DK** port, not the Ethernet LAN port. |
| **Solenoid clicks, but drawer doesn't slide** | Jammed bill or coin | A coin or folded bill has fallen behind the plastic till insert, blocking the slide mechanism. Remove the till insert and inspect the tray. |
| **Printer prints, but drawer ignored** | Driver property disabled | Verify in the Windows printer properties that "Cash Drawer: Open Before Printing" is enabled. |
| **Weak kick / does not latch** | Voltage mismatch (12V vs 24V) | Standard commercial drawers use 24V (supplied by thermal printers). Compact mobile drawers often require 12V. Verify voltage rating matches printer output. |
