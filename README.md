# TKCafe – QR Menu Ordering System

TKCafe is a web-based QR menu ordering system designed to simplify the dine-in and takeaway process for restaurants and cafés. The system includes both a **customer interface** and an **admin dashboard**.

## Features

### Customer Side
- Scan QR to access the menu
- Place orders with Dine-In / Takeaway options
- Browse by categories (Standard, Signature, Set Meals)
- Add items to cart
- Choose quantity & customizations

### Admin Side
- Admin login authentication
- Dashboard with total sales & orders overview
- Manage orders (Pending, Preparing, Completed)
- View detailed order info in popup
- Manage table availability
- Monitor 7-day sales chart

## Tools
- PHP (core logic)
- MySQL (database)
- HTML/CSS/JavaScript
- Chart.js for sales graph
- XAMPP (for local server)

## 📂 How to Run

1. Clone the repo: https://github.com/NurinNasya/TKCafe.git
2. Import `tkcafe.sql` into your MySQL.
3. Place the folder in `htdocs` (XAMPP).
4. Start Apache & MySQL via XAMPP.
5. Visit: http://localhost/TKCafe/


### Admin Login (Default)
Username: admin
Password: tkcafe123

## Project Structure
TKCafe/
├── Controller/
├── Libraries/
├── Model/
├── public/
├── Views/
├── db.php
├── error.log
└── index.php