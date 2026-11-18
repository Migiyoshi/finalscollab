# OSCA Records System

PHP + MySQL web app for managing senior citizen records and payouts (Office of Senior Citizens Affairs, Barangay Mayondon).

## Features
- Login / sign-up (bcrypt-hashed passwords, PHP sessions)
- Dashboard with live counts (total, added this month, added this week) and recent registrations
- Senior citizen list with search and pension-status filter
- Add-senior form with client-side validation (age ≥ 60, PH mobile format) and server-side age calculation

## Tech stack
PHP 8 (PDO), MySQL/MariaDB, vanilla JS, CSS, Bootstrap Icons. Runs on XAMPP.

## Project structure
```
osca-records-system/
├── login.html           # login / sign-up page (entry point)
├── Dashboard.php        # dashboard
├── list.php             # senior list
├── add.php              # add-senior form
├── saved.php            # "saved successfully" confirmation
├── reports.php          # filterable report + print
├── api/                 # JSON endpoints
│   ├── auth_login.php
│   ├── auth_signup.php
│   └── insert_senior.php
├── includes/
│   └── db.php           # shared PDO connection
├── assets/
│   ├── css/             # login, dashboard, list, add, saved
│   ├── js/              # auth.js, add.js
│   └── img/             # mayondon.png (hall photo), mayondonlogo.png (seal)
└── database/
    └── schema.sql
```

## Setup (XAMPP)
1. Clone into `C:\xampp\htdocs\osca-records-system`.
2. Start **Apache** and **MySQL** in the XAMPP Control Panel.
3. In phpMyAdmin, import `database/schema.sql`.
4. Adjust credentials in `includes/db.php` if yours differ (defaults: `root`, empty password).
5. Open `http://localhost/osca-records-system/login.html`.

## Known TODOs
- Protect pages with `$_SESSION['user_id']` checks (and add a logout script that destroys the session).
- Remove the plain-text password fallback in `api/auth_login.php` before production.
- "Change Status" dropdowns on the list/dashboard don't save to the database yet.
- Reports page has inline styles; move them into `assets/css/`.
