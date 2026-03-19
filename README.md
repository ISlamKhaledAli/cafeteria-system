# ☕ Premium Cafeteria Management System

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

A robust, secure, and elegantly designed web-based cafeteria management system built with **Native PHP (OOP)** following the **MVC Architecture**. This system streamlines the ordering process for users and provides a comprehensive, analytics-driven dashboard for administrators.

---

## ✨ Key Features

### 🛒 For Users (Customers)

- **Modern UI/UX:** Premium glassmorphism design with smooth animations.
- **Smart Ordering:** Asynchronous (AJAX) cart system using JavaScript `fetch` and `localStorage`.
- **Dynamic Menu:** Live-filtering for products based on categories and real-time search.
- **Order History:** Detailed view of past orders, statuses, and receipts with smooth collapse animations.

### 🛡️ For Administrators

- **Analytics Dashboard:** Real-time statistics, revenue tracking, and top-selling products.
- **Order Management:** Live order tracking and status updates via SweetAlert2 confirmations.
- **Inventory Control:** Full CRUD operations for Products, Categories, and Rooms.
- **User Management:** Role-based access control (Admin/User) with secure profile picture uploads.

---

## 🏗️ Architecture & Security Highlights

As the lead architect on this project, several enterprise-level patterns and security measures were implemented:

- **MVC Pattern:** Strict separation of concerns (Models for DB logic, Views for UI, Controllers for business logic).
- **Singleton Database Connection:** Optimized database connections using `PDO` to prevent resource exhaustion.
- **Data Tampering Prevention:** Cart prices are recalculated securely on the backend; never trusting client-side data.
- **Secure File Uploads:** Validating file MIME types using `finfo` (not just extensions) to prevent malicious shell uploads.
- **SQL Injection Protection:** Utilizing `PDO Prepared Statements` and parameter binding across all queries.
- **Password Security:** Utilizing PHP's native `password_hash()` and `password_verify()`.

---

## 🚀 Installation & Setup

Follow these instructions to get the project up and running on your local machine.

### Prerequisites

- XAMPP, MAMP, or any local server stack.
- PHP >= 8.0
- MySQL / MariaDB

### Steps

1. **Clone the repository:**
   ```bash
   git clone [https://github.com/yourusername/cafeteria-system.git](https://github.com/yourusername/cafeteria-system.git)
   ```
