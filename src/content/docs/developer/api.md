---
title: REST API & Integrations
description: Integrate Open Source Point of Sale with external eCommerce stores, ERPs, and custom mobile applications.
---

Open Source Point of Sale provides REST API endpoints to synchronize inventory, fetch transactions, and manage customers from external software systems (such as WooCommerce, Shopify, custom mobile apps, or enterprise ERPs).

---

## 1. Authentication

API requests require authentication using an **API Key** passed in the HTTP request headers:

```http
GET /api/v1/items HTTP/1.1
Host: pos.yourstore.com
Authorization: Bearer YOUR_API_TOKEN_HERE
Accept: application/json
```

Generate and manage API keys under **Store Config** $\rightarrow$ **API Tokens**.

---

## 2. Core Endpoints

All responses are returned as standard `application/json`.

### Items & Inventory

#### `GET /api/v1/items`
Retrieve a paginated list of catalog items.

```json
{
  "total": 150,
  "page": 1,
  "per_page": 25,
  "data": [
    {
      "item_id": 42,
      "name": "Ethiopian Yirgacheffe 500g",
      "item_number": "890123456789",
      "category": "Coffee",
      "cost_price": "8.50",
      "unit_price": "16.00",
      "quantity": 34,
      "reorder_level": 10
    }
  ]
}
```

#### `GET /api/v1/items/{id_or_barcode}`
Lookup an item by database ID or scanned barcode.

#### `PATCH /api/v1/items/{id}/stock`
Update the physical quantity on hand for a stock location (e.g. following an online eCommerce order fulfillment):

```json
{
  "location_id": 1,
  "quantity_change": -1,
  "reason": "WooCommerce Order #1042"
}
```

---

### Customers

#### `GET /api/v1/customers`
Search customers by name, phone number, or email.

#### `POST /api/v1/customers`
Create a new customer profile from an external signup form.

---

### Sales & Invoices

#### `GET /api/v1/sales`
Query completed sales by date range, cashier, or customer ID.

#### `POST /api/v1/sales`
Submit an external order to be recorded in OSPOS and deduct inventory.

