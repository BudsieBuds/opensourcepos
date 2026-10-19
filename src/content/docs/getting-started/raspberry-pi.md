---
title: Raspberry Pi & Single-Board Computers
description: Turn a Raspberry Pi 4 or 5 into a compact, dedicated in-store POS register station.
---

A Raspberry Pi (Pi 4 or Pi 5 with 2GB+ RAM) or compatible single-board computer (Orange Pi, Libre Computer) makes an affordable, ultra-compact, and energy-efficient POS terminal for physical retail counters and food trucks.

---

## Hardware Requirements

- **Raspberry Pi 4 Model B (2GB, 4GB, or 8GB)** or **Raspberry Pi 5**
- High-end microSD card (Class 10 A2) or USB 3.0 SSD (strongly recommended for database reliability and write speed)
- Official Raspberry Pi USB-C Power Supply
- Touchscreen display (e.g. Official 7" Touch Display, HDMI Touch monitor, or standard monitor)
- USB or Network Thermal Receipt Printer
- USB Handheld Barcode Scanner

---

## 1. Operating System Setup

1. Use the **Raspberry Pi Imager** to flash **Raspberry Pi OS (64-bit)** (Debian Bookworm) onto your SSD or SD card.
2. In the OS customization settings:
   - Configure hostname (e.g. `ospos-register-1`)
   - Enable SSH
   - Configure your local Wi-Fi or Ethernet settings
3. Boot the Pi and update all packages:
   ```bash
   sudo apt update && sudo apt upgrade -y
   ```

---

## 2. Deploying with Docker (Recommended)

Docker Compose is the easiest way to run OSPOS on the Raspberry Pi:

```bash
# Install Docker and Compose
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh
sudo usermod -aG docker $USER
newgrp docker

# Create OSPOS directory
mkdir ~/ospos && cd ~/ospos
curl -O https://raw.githubusercontent.com/opensourcepos/opensourcepos/master/docker-compose.yml
touch .env

# Start OSPOS
docker compose up -d
```

The arm64 multi-arch Docker image will download and initialize automatically.

---

## 3. Configuring Kiosk Mode (Auto-Boot into POS)

To turn the Raspberry Pi into a dedicated appliance that boots directly into the POS register in fullscreen mode without desktop distractions:

### Step 1: Install Kiosk Dependencies

```bash
sudo apt install -y unclutter xdotool
```
*(Unclutter hides the mouse cursor when idle; great for touchscreens).*

### Step 2: Create Kiosk Autostart Script

Create a start script:

```bash
mkdir -p ~/.config/autostart
nano ~/.config/autostart/pos-kiosk.desktop
```

Add the following configuration:

```ini
[Desktop Entry]
Type=Application
Name=POS Kiosk
Exec=/home/pi/start-kiosk.sh
X-GNOME-Autostart-enabled=true
```

Create the `/home/pi/start-kiosk.sh` script:

```bash
nano ~/start-kiosk.sh
chmod +x ~/start-kiosk.sh
```

Paste:

```bash
#!/bin/bash
# Disable screen blanking and power saving
xset s off
xset s noblank
xset -dpms

# Hide mouse cursor after 3 seconds of inactivity (perfect for touchscreen)
unclutter -idle 3 -root &

# Wait for OSPOS server container to be reachable
while ! curl -s http://localhost > /dev/null; do
    sleep 2
done

# Launch Chromium in Fullscreen Kiosk Mode
chromium-browser \
  --noerrdialogs \
  --disable-infobars \
  --kiosk \
  --incognito \
  --check-for-update-interval=31536000 \
  --disable-pinch \
  --overscroll-history-navigation=0 \
  http://localhost
```

Reboot the Raspberry Pi:

```bash
sudo reboot
```

Your Raspberry Pi will now automatically boot directly into the Open Source Point of Sale register interface!

---

## 4. Hardware Connectivity on Raspberry Pi

- **USB Receipt Printers**: Linux recognizes most USB ESC/POS printers as `/dev/usb/lp0`. See the [Thermal Receipt Printers](/hardware/receipt-printers/) guide for direct raw printing.
- **USB Barcode Scanners**: Standard USB scanners operate as "keyboard wedge" devices (`/dev/input/event*`) and require zero drivers. When scanned, characters are automatically typed into whatever input field is focused.
- **Secondary Customer Display**: You can connect a second HDMI monitor (micro-HDMI port 2 on Pi 4/5) for customer-facing checkout subtotals and marketing graphics.

