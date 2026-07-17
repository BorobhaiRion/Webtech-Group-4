# 🛒 E-Store — Webtech Group 4

A full-featured e-commerce web application built with **vanilla PHP**, **MySQL**, and **vanilla JavaScript**. This project was developed as part of the Web Technologies lab course and includes user authentication, product management, shopping cart, order processing, and an admin dashboard.

---

## ✨ Features

### 👤 User Features
- **User Registration & Login** — Secure sign-up and sign-in with password hashing
- **Remember Me** — Persistent login via token-based cookie authentication
- **Profile Management** — Update name, email, phone, and shipping addresses
- **Password Change** — Update password securely with current password verification
- **Product Browsing** — Browse all products with product detail pages
- **Search & Filter** — Search products by name and filter by category (AJAX-powered)
- **Shopping Cart** — Add products, update quantities, remove items (AJAX for add-to-cart)
- **Checkout** — Select from saved or enter a new shipping address; choose payment method (Cash on Delivery / Credit Card)
- **Order History** — View all past orders with status badges
- **Order Confirmation** — Order summary after successful placement

### 🛠️ Admin Features
- **Admin Dashboard** — Overview of total products and categories
- **Product Management** — Add, edit, and toggle availability of products
- **Category Management** — Add, edit, and delete categories (supports parent-child hierarchy)
- **Low Stock Alerts** — Visually highlights products with stock ≤ 5
- **Image Upload** — Upload product images with validation (JPEG/PNG, max 3 MB)

### 🔌 API Endpoints
| Endpoint | Method | Description |
|----------|--------|-------------|
| `api/products.php?action=search&q=...` | GET | Search products by name |
| `api/products.php?action=filter&category_id=...` | GET | Filter products by category |
| `api/cart.php?action=add` | POST | Add a product to the cart |
| `api/toggle_availability.php` | POST | Toggle product availability (admin only) |

---

## 🗄️ Database Schema

The database (`shop_db`) consists of 6 tables:

| Table | Description |
|-------|-------------|
| `users` | Customers and admins (name, email, phone, password, role, shipping addresses, remember token) |
| `categories` | Product categories with optional parent category (self-referencing FK) |
| `products` | Products linked to categories (name, description, price, stock, image, availability) |
| `orders` | Customer orders (total, status, shipping address, payment method) |
| `order_items` | Line items within an order (product, quantity, unit price) |
| `reviews` | Product reviews with ratings 1–5 (linked to users and products) |

See [`schema.sql`](./schema.sql) for the full DDL.

---

## 🏗️ Project Structure

```
├── api/                          # AJAX API endpoints
│   ├── cart.php                  #   Cart operations (add)
│   ├── products.php              #   Search & filter products
│   └── toggle_availability.php   #   Toggle product availability
├── config/
│   └── helpers.php               #   Session, flash messages, validation, auth helpers
├── controllers/                  # Business logic layer
│   ├── AdminController.php       #   Product & category CRUD
│   ├── CartController.php        #   Cart add/update/remove
│   ├── LoginController.php       #   Login with Remember Me
│   ├── OrderController.php       #   Order placement
│   ├── ProductController.php     #   Product search/filter
│   ├── ProfileController.php     #   Profile & password update
│   └── RegisterController.php    #   User registration
├── models/
│   └── db.php                    #   Database class with all queries
├── public/
│   ├── assets/
│   │   ├── css/
│   │   │   └── style.css         #   Application stylesheet
│   │   └── js/
│   │       └── main.js           #   Front-end interactivity (AJAX)
│   └── uploads/
│       └── products/             #   Uploaded product images
├── views/                        # PHP templates (pages)
│   ├── header.php                #   Shared header & navigation
│   ├── footer.php                #   Shared footer & scripts
│   ├── index.php                 #   Home page (product grid)
│   ├── login.php                 #   Login form
│   ├── register.php              #   Registration form
│   ├── profile.php               #   User profile & order history
│   ├── cart.php                  #   Shopping cart
│   ├── checkout.php              #   Checkout page
│   ├── product_detail.php        #   Single product view
│   ├── order_confirmation.php    #   Order success page
│   ├── admin_dashboard.php       #   Admin panel
│   ├── admin_product_form.php    #   Add/edit product form
│   └── admin_category_form.php   #   Add/edit category form
├── schema.sql                    # Database schema (DDL)
└── README.md                     # This file
```

---

## ⚙️ Installation

### Prerequisites
- PHP 7.4+ with `mysqli` extension enabled
- MySQL 5.7+ or MariaDB 10.3+
- A web server (Apache, Nginx, or PHP's built-in server)
- Write permissions for the image uploads directory

### Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-org/Webtech-Group-4.git
   cd Webtech-Group-4
   ```

2. **Set up the database**
   - Create a database named `shop_db`
   - Import the schema:
     ```bash
     mysql -u root -p shop_db < schema.sql
     ```

3. **Configure the database connection**
   Edit [`models/db.php`](./models/db.php) and update the credentials if needed:
   ```php
   private $host = "localhost";
   private $user = "root";
   private $password = "";
   private $dbname = "shop_db";
   ```

4. **Serve the application**

   Using PHP's built-in server (from the project root):
   ```bash
   php -S localhost:8000
   ```
   Then open `http://localhost:8000/views/index.php` in your browser.

   > **Note:** The views are in the `views/` directory. The controllers and API are accessed from there. The `public/` directory holds static assets (CSS, JS, images).

5. **Create the uploads directory**
   ```bash
   mkdir -p public/uploads/products
   ```
   Make sure the directory is writable by your web server process.

6. **Create an admin user** (optional)
   Register a new account at `/views/register.php`, then manually set the role to `admin` in the database:
   ```sql
   UPDATE users SET role = 'admin' WHERE email = 'your@email.com';
   ```

---

## 🧪 Usage

| URL | Description |
|-----|-------------|
| `/views/index.php` | Product listing with search & category filter |
| `/views/product_detail.php?id=N` | Single product page |
| `/views/cart.php` | View & manage cart |
| `/views/checkout.php` | Place an order |
| `/views/login.php` | Sign in |
| `/views/register.php` | Create an account |
| `/views/profile.php` | Update profile, change password, view orders |
| `/views/logout.php` | Sign out and clear session |
| `/views/admin_dashboard.php` | Admin panel (requires admin role) |
| `/views/admin_product_form.php` | Add / edit a product |
| `/views/admin_category_form.php` | Add / edit a category |

---

## 🧑‍💻 Tech Stack

| Layer | Technology |
|-------|------------|
| **Backend** | PHP (vanilla, no framework) |
| **Database** | MySQL with `mysqli` |
| **Frontend** | HTML5, CSS3, Vanilla JavaScript |
| **AJAX** | XMLHttpRequest (native) |
| **Auth** | `password_hash()` / `password_verify()`, session-based |
| **Required PHP Extensions** | `mysqli` |
| **Image Uploads** | Server-side validation with `move_uploaded_file()` |

---

## 🧠 Known Limitations

- **Remember Me token** — The `db.php` model includes an `updateRememberToken()` method, but the login controller does not persist the token to the database on login. Cookie-based sessions work for the current browser session but won't survive a server restart or cookie clearing.
- **Product deletion** — Products with existing order items cannot be deleted (prevented at the database layer).
- **Reviews** — The reviews table and schema exist, but the review submission form and listing are not yet fully implemented.
- **Responsive design** — The UI uses table-based layouts and may not render optimally on mobile devices.

---

## 👥 Contributors

- **ZarinAnjum** — Admin dashboard, product & category management, availability toggle, API endpoints
- **BorobhaiRion / Borobhai_rion** — User authentication (login/register), profile management, logout, helpers, DB model
- **Musfiq** — E-commerce features, integration, merge management

---

## 📄 License

This project was created for educational purposes as part of a Web Technologies lab course.
