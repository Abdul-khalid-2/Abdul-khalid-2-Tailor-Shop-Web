# Tailor Shop App — Project Plan for Claude Code
# Laravel 12 | PHP 8.2 | MySQL | Blade | Tailwind | Alpine.js

---

## THE KEY CONCEPT

Customer → can have multiple Orders
Order → belongs to ONE person, can have multiple Suits (different colors)
Suit → one color/style inside an order (e.g. Green suit, Red suit)
Measurements → stored once per Order (all suits in one order = same body)
Tailor → assigned at Order level, tracks all work + payments

### Real Example:
Ahmed comes to shop.
- Order 1 (For Self): 3 suits → Green, Red, Blue — one measurement set
- Order 2 (For Bilal his son): 5 suits → Green, Red, Blue, Yellow, White — separate measurements

---

## WHAT TO REMOVE FROM EXISTING CODE

DELETE these migration files (not needed):
- create_order_items_table
- create_fabrics_table
- create_fabric_transactions_table
- create_discounts_table
- create_expenses_table
- create_payments_table

REMOVE from models: OrderItem, Fabric, FabricTransaction, Discount, Expense, Payment

REMOVE from routes/web.php: any routes for fabrics, payments, expenses, discounts

---

## DATABASE — TABLES TO CREATE

### TABLE: customers
- id (BIGINT PK)
- name (VARCHAR 150, required)
- phone (VARCHAR 20, unique, required)
- address (TEXT nullable)
- notes (TEXT nullable)
- branch_id (FK branches nullable)
- created_by (FK users nullable)
- timestamps + softDeletes

### TABLE: orders
- id (BIGINT PK)
- order_number (VARCHAR unique) — format ORD-YYYY-0001
- customer_id (FK customers, restrict)
- tailor_id (FK tailors nullable, set null)
- branch_id (FK branches, restrict)
- status_id (FK order_statuses, default 1)
- order_date (DATE)
- delivery_date (DATE nullable)
- actual_delivery_date (DATE nullable)
- order_label (VARCHAR 100 nullable) — e.g. "For Self", "For Bilal"
- total_suits (INT default 0)
- total_amount (DECIMAL 12,2 default 0)
- advance_paid (DECIMAL 12,2 default 0)
- balance_due (DECIMAL 12,2 default 0)
- tailor_fee_total (DECIMAL 12,2 default 0)
- tailor_fee_paid (DECIMAL 12,2 default 0)
- tailor_fee_balance (DECIMAL 12,2 default 0)
- notes (TEXT nullable)
- created_by (FK users nullable)
- updated_by (FK users nullable)
- timestamps + softDeletes

### TABLE: suits
- id (BIGINT PK)
- order_id (FK orders, cascade delete)
- color (VARCHAR 80) — e.g. Green, Navy Blue
- quantity (INT default 1)
- stitching_charge (DECIMAL 10,2 default 0)
- button_charge (DECIMAL 10,2 default 0)
- other_charge (DECIMAL 10,2 default 0)
- other_charge_note (VARCHAR 200 nullable)
- suit_total (DECIMAL 10,2 default 0) — auto: (stitch+btn+other)*qty
- notes (TEXT nullable)
- sort_order (INT default 0)
- timestamps

### TABLE: measurements
- id (BIGINT PK)
- order_id (FK orders, unique, cascade)
- length (DECIMAL 5,1 nullable)
- shoulder (DECIMAL 5,1 nullable)
- chest (DECIMAL 5,1 nullable)
- waist (DECIMAL 5,1 nullable)
- hip (DECIMAL 5,1 nullable)
- sleeve (DECIMAL 5,1 nullable)
- collar (DECIMAL 5,1 nullable)
- trouser_length (DECIMAL 5,1 nullable)
- trouser_waist (DECIMAL 5,1 nullable)
- thigh (DECIMAL 5,1 nullable)
- bottom_opening (DECIMAL 5,1 nullable)
- notes (TEXT nullable)
- timestamps

### TABLE: tailors
- id (BIGINT PK)
- name (VARCHAR 150)
- phone (VARCHAR 20)
- cnic (VARCHAR 20 nullable)
- address (TEXT nullable)
- joining_date (DATE nullable)
- specialty (ENUM: shalwar_kameez, sherwani, all — default all)
- status (ENUM: active, on_leave — default active)
- branch_id (FK branches nullable)
- total_orders_assigned (INT default 0)
- total_suits_assigned (INT default 0)
- orders_completed (INT default 0)
- orders_pending (INT default 0)
- total_fee_earned (DECIMAL 12,2 default 0)
- total_fee_received (DECIMAL 12,2 default 0)
- total_fee_balance (DECIMAL 12,2 default 0)
- notes (TEXT nullable)
- timestamps + softDeletes

### TABLE: order_status_logs
- id (BIGINT PK)
- order_id (FK orders)
- from_status_id (FK order_statuses nullable)
- to_status_id (FK order_statuses)
- changed_by (FK users nullable)
- notes (TEXT nullable)
- created_at (TIMESTAMP)

---

## MODELS

### Order Model
Relationships:
- customer() → belongsTo Customer
- tailor() → belongsTo Tailor (nullable)
- branch() → belongsTo Branch
- status() → belongsTo OrderStatus, FK: status_id
- suits() → hasMany Suit, ordered by sort_order
- measurement() → hasOne Measurement
- statusLogs() → hasMany OrderStatusLog
- createdBy() → belongsTo User, FK: created_by

Scopes:
- scopePending → where status name = Pending
- scopeInProgress → where status name = In Progress
- scopeReady → where status name = Ready
- scopeOverdue → delivery_date < today AND status NOT IN [Delivered, Cancelled]

Methods:
- isOverdue(): bool
- recalculate(): recalculates total_suits, total_amount, balance_due, tailor_fee_balance then saves

Boot:
- creating: auto-generate order_number = 'ORD-' + year + '-' + zero-padded count

### Suit Model
Boot:
- saving: suit_total = (stitching_charge + button_charge + other_charge) * quantity
- saved: $this->order->recalculate()
- deleted: $this->order->recalculate()

### Tailor Model
Method syncStats():
- total_orders_assigned = orders()->count()
- total_suits_assigned = orders()->sum('total_suits')
- orders_completed = orders where status=Delivered, count()
- orders_pending = orders where status not in [Delivered,Cancelled], count()
- total_fee_earned = orders()->sum('tailor_fee_total')
- total_fee_received = orders()->sum('tailor_fee_paid')
- total_fee_balance = earned - received
- then save()

Call syncStats() after: order assigned to tailor, order completed, tailor payment recorded.

### Customer Model
- hasMany Orders
- getTotalOrdersAttribute() → orders()->count()
- getLastVisitAttribute() → orders()->max('order_date')

---

## CONTROLLERS

### OrderController methods:
- index() — paginate 20, search by order_number/customer name/phone, filter by status_id
- pending() — scopePending, sorted by delivery_date ASC
- inProgress() — scopeInProgress
- ready() — scopeReady
- overdue() — scopeOverdue
- create() — pass: customers list, active tailors list, order_date default today
- store() — DB::transaction: create Order + Suits (loop) + Measurement + StatusLog + call tailor->syncStats()
- show() — eager load: customer, tailor, suits, measurement, statusLogs, status
- edit() — same data as create
- update() — DB::transaction: update Order + Suits + Measurement + recalculate()
- updateStatus(Request, Order) — update status, create StatusLog, if Delivered set actual_delivery_date, call tailor->syncStats()
- recordTailorPayment(Request, Order) — add to tailor_fee_paid, recalculate tailor_fee_balance, call tailor->syncStats()
- recordCustomerPayment(Request, Order) — add to advance_paid, recalculate balance_due
- destroy() — soft delete, only if status is Pending or Cancelled

### CustomerController:
- index() — search by name/phone, paginate 20
- create/store/edit/update/destroy — standard CRUD
- show() — customer info + all orders paginated

### TailorController:
- index() — list with: name, phone, status, active orders count, total_fee_balance
- create/store/edit/update/destroy — CRUD
- show() — personal info + 4 work stat cards + 3 payment stat cards + active orders table + history table
- toggleStatus() — switch active/on_leave

### DashboardController:
- index():
  - pendingCount, inProgressCount, readyCount, overdueCount
  - overdueList (with customer + tailor, take 10)
  - todayDeliveries (delivery_date = today, with customer)
  - recentOrders (last 10)

---

## ROUTES (routes/web.php)

All routes inside auth + verified middleware group:

// Dashboard
GET /dashboard → DashboardController@index

// Customers
GET    /customers              → CustomerController@index
GET    /customers/create       → CustomerController@create
POST   /customers              → CustomerController@store
GET    /customers/{id}         → CustomerController@show
GET    /customers/{id}/edit    → CustomerController@edit
PUT    /customers/{id}         → CustomerController@update
DELETE /customers/{id}         → CustomerController@destroy

// Orders
GET    /orders                 → OrderController@index
GET    /orders/pending         → OrderController@pending
GET    /orders/in-progress     → OrderController@inProgress
GET    /orders/ready           → OrderController@ready
GET    /orders/overdue         → OrderController@overdue
GET    /orders/create          → OrderController@create
POST   /orders                 → OrderController@store
GET    /orders/{id}            → OrderController@show
GET    /orders/{id}/edit       → OrderController@edit
PUT    /orders/{id}            → OrderController@update
PATCH  /orders/{id}/status     → OrderController@updateStatus
POST   /orders/{id}/tailor-payment   → OrderController@recordTailorPayment
POST   /orders/{id}/customer-payment → OrderController@recordCustomerPayment
DELETE /orders/{id}            → OrderController@destroy

// Tailors
GET    /tailors                → TailorController@index
GET    /tailors/create         → TailorController@create
POST   /tailors                → TailorController@store
GET    /tailors/{id}           → TailorController@show
GET    /tailors/{id}/edit      → TailorController@edit
PUT    /tailors/{id}           → TailorController@update
PATCH  /tailors/{id}/toggle    → TailorController@toggleStatus
DELETE /tailors/{id}           → TailorController@destroy

---

## VIEWS NEEDED

Sidebar links (5 only): Dashboard | Orders | Customers | Tailors | Settings

### dashboard/index.blade.php
- 4 stat cards: Pending (yellow), In Progress (blue), Ready (green), Overdue (red)
- Overdue Orders table: Order#, Customer, Tailor, Delivery Date, Days Overdue
- Today's Deliveries table: Customer, Phone, Suits Count, Balance Due
- Recent 10 Orders list

### orders/index.blade.php
- Search bar (by order# or customer name/phone)
- Status filter tabs or dropdown
- Table: Order#, Customer, Order Label, Suits, Total, Balance, Status badge, Delivery Date, Actions

### orders/create.blade.php & edit.blade.php
- Customer searchable input (live search by name or phone → dropdown)
- Order Label text input
- Order Date + Delivery Date
- Tailor dropdown (active only)
- Tailor Fee input
- Advance Paid input
- SUIT REPEATER (Alpine.js):
  - Each row: Color | Qty | Stitching | Buttons | Other | Note | Row Total (auto) | Remove
  - Add Suit button
  - Min 1 row always
- MEASUREMENTS section (collapsible):
  - Toggle button to show/hide
  - Grid: length, shoulder, chest, waist, hip, sleeve, collar, trouser_length, trouser_waist, thigh, bottom_opening, notes
  - All optional
- SUMMARY (live auto-calc):
  - Total Amount, Advance Paid, Balance Due, Tailor Fee Balance

### orders/show.blade.php
- Order header: number, label, customer (clickable), dates, status badge
- Tailor section: name, phone, fee total, fee paid, fee balance + Record Tailor Payment button
- Suits table: Color | Qty | Stitching | Buttons | Other | Total — grand total row
- Customer payment: Total, Advance, Balance + Record Customer Payment button
- Measurements: clean grid
- Status log: timeline
- Action buttons: Edit, Update Status, Print

### customers/index.blade.php
- Search by name or phone
- Table: Name, Phone, Total Orders, Last Visit, Branch, Actions

### customers/show.blade.php
- Customer info block
- Orders table: Order#, Label, Suits, Total, Balance, Status, Date

### tailors/index.blade.php
- Table: Name, Phone, Status badge, Active Orders (badge), Total Suits, Fee Balance, Actions

### tailors/show.blade.php
- Personal info card
- 4 work stat cards: Total Orders | Total Suits | Completed | Pending
- 3 payment cards: Fee Earned | Fee Received | Balance (red if >0)
- Active orders table
- Order history table (paginated)

---

## STATUS COLORS (use same everywhere)
- Pending → yellow/amber badge
- In Progress → blue badge
- Ready → green badge
- Delivered → gray badge
- Cancelled → red badge
- Overdue → red text + warning icon
- Balance Due > 0 → orange text
- Tailor Fee Balance > 0 → red text

---

## UI/UX RULES
- Sidebar: 5 links only (Dashboard, Orders, Customers, Tailors, Settings)
- No sub-menus
- Large buttons with text labels
- Search bar on every list page
- Auto-calculate amounts in forms (Alpine.js)
- Confirmation dialog before delete
- Flash success/error message after every action
- Mobile responsive
- Print view for order detail (no sidebar)
