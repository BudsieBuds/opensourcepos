---
title: Printer & Cash Drawer Troubleshooting
description: Diagnose thermal receipt printing issues, margins, garbled text, and cash drawer failures.
---

Thermal receipt printers and cash drawers are mechanical hardware devices that require precise configuration. This guide resolves the most frequent printing and drawer issues.

---

## 1. Printer Feeds Paper, But Nothing Is Printed (Blank Paper)

### Cause: Thermal Paper Roll Loaded Backwards
Thermal receipt paper is coated with heat-sensitive chemical pigment on **only one side**. If the roll is inserted upside down, the thermal print head heats the non-reactive paper backing, producing blank paper.

### Solution
1. Open the printer cover.
2. Remove the paper roll and flip it over so the paper unrolls from the **bottom** (feeding upward toward the tear bar).
3. Close the lid and print a test receipt.
4. *Quick Test*: Scratch the paper surface with your fingernail. The side with the thermal coating will leave a dark black streak.

---

## 2. Printer Prints Garbage / Hieroglyphs / Random Characters

### Cause
- **Serial Connection**: Baud rate mismatch (e.g., printer is set to 9600 baud, but software is communicating at 115200 baud).
- **Network / USB ESC/POS**: Wrong character code page selected (e.g. attempting to print Cyrillic or Chinese characters using `PC437` USA character map).

### Solution
1. Print a hardware diagnostic self-test from the printer:
   - Turn off the printer.
   - Hold down the **FEED** button while switching power ON.
   - Keep holding FEED for 3 seconds, then release.
   - The printer prints a self-test showing its current baud rate and supported code pages.
2. In **Store Config** $\rightarrow$ **Receipt**, match the configured **Character Set** to your printer's supported code page (e.g. `PC437`, `PC850`, `WPC1252`, or `UTF-8`).

---

## 3. Text Is Cut Off on the Right Side

### Cause
Your printer uses **58mm (2-inch)** paper, but OSPOS is configured for standard **80mm (3-inch)** paper width.

### Solution
1. Navigate to **Store Config** $\rightarrow$ **Receipt**.
2. Locate **Paper Width** or **Characters per Line**.
3. Change width from `80mm` (48 characters) to `58mm` (32 characters).
4. Save and test print.

---

## 4. Cash Drawer Does Not Kick Open

### Diagnostic Checklist:
1. **Check the Physical Key**: Ensure the key in the front of the cash drawer is turned to the **Vertical (Electronic / Unlocked)** position. If turned horizontally, the drawer is manually locked and the solenoid cannot slide open.
2. **Check the Cable Port**: Ensure the 6-pin modular cable is plugged into the printer's **DK (Drawer Kick)** port, not an Ethernet LAN or Serial port.
3. **Verify Printer Driver Settings**:
   - In Windows, open **Printer Properties** $\rightarrow$ **Device Settings**.
   - Ensure **Cash Drawer** is set to **Open Before Printing** or **Open After Printing**.
4. **Listen for the Solenoid Click**:
   - When a cash sale completes, listen closely to the cash drawer.
   - If you hear a click but the drawer doesn't slide open, a coin or bill is jammed behind the drawer tray.
   - If you hear no click, verify the cable connections and printer drawer kick settings in OSPOS.

