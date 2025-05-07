<p align="center">
  <span style="font-size: 120px; position: relative; display: inline-block;">
    <i class="fas fa-utensils" style="color: #4CAF50; position: absolute; top: -5px; left: -5px; opacity: 0.3;"></i>
    <i class="fas fa-utensils" style="color: #0288D1;"></i>
  </span>
  <br>
  <span style="font-size: 60px; font-weight: 700; background: linear-gradient(135deg, #0288D1, #4CAF50); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; color: transparent;">OctoPOS</span>
</p>

<h1 align="center">Restaurant Point of Sale System</h1>

<p align="center">
  <img src="https://img.shields.io/badge/version-3.4.2-blue" alt="Version" />
  <img src="https://img.shields.io/badge/license-MIT-green" alt="License" />
  <img src="https://img.shields.io/badge/php-8.1-777BB4?logo=php" alt="PHP 8.1" />
  <img src="https://img.shields.io/badge/laravel-10.x-FF2D20?logo=laravel" alt="Laravel 10.x" />
  <img src="https://img.shields.io/badge/tailwindcss-3.x-38B2AC?logo=tailwindcss" alt="Tailwind CSS" />
</p>

<p align="center">
  A modern, efficient, and user-friendly point of sale system designed specifically for restaurants.
</p>

## ✨ Features

OctoPOS is a comprehensive restaurant management system that offers multiple interfaces tailored to different user roles:

### 🍽️ For Servers
- **Table Management**: View table status (available, occupied, reserved) in real-time
- **Order Taking**: Easily add items to orders with a visual menu interface
- **Payment Processing**: Handle various payment methods (cash, credit card, meal vouchers)
- **Receipt Generation**: Print or send digital receipts to customers

### 👨‍💼 For Managers
- **Reservation Management**: Track and manage table reservations
- **Staff Scheduling**: Organize employee shifts efficiently
- **Menu & Inventory Management**: Update menu items and track stock
- **Financial Reporting**: Access detailed sales reports and analytics
- **Table Layout Customization**: Customize restaurant floor plans

### 🧑‍💻 For Restaurant Owners
- **Multi-Restaurant Support**: Manage multiple establishments from one account
- **Performance Analytics**: View comprehensive business performance metrics
- **System Configuration**: Customize the application to your specific needs

### 👨‍🍳 For Customers
- **Online Reservations**: Book tables online with time slot selection
- **Digital Menu Access**: View interactive menus with descriptions and prices
- **Loyalty Program**: Earn and redeem points through the integrated loyalty system
- **Invoice History**: Access previous dining experiences and receipts

## 🚀 Getting Started

### Prerequisites
- PHP ^8.1
- Composer
- Node.js & NPM
- MySQL or PostgreSQL database

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/HamzaBraik01/OctoPOS.git
   cd OctoPOS
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install front-end dependencies**
   ```bash
   npm install
   ```

4. **Set up environment file**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure your database in the .env file**
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=octopos
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Run migrations and seed the database**
   ```bash
   php artisan migrate --seed
   ```

7. **Compile assets**
   ```bash
   npm run dev
   ```

8. **Start the application**
   ```bash
   php artisan serve
   ```

Visit `http://localhost:8000` in your browser to access the application.

## 🔍 System Architecture

OctoPOS is built on the Laravel framework with a clean, modular architecture:

- **Backend**: Laravel 10.x with RESTful API endpoints
- **Frontend**: Tailwind CSS for styling, JavaScript for interactivity
- **Authentication**: Laravel Sanctum & JWT for API authentication
- **PDF Generation**: Uses barryvdh/laravel-dompdf for receipt and report generation

## 📊 Database Schema

The system uses a relational database with the following main entities:
- Restaurants
- Users (Owners, Managers, Servers, Customers)
- Tables
- Menus & Dishes
- Orders & Order Items
- Reservations
- Payments & Invoices

## 🧪 Testing

Run the test suite with:
```bash
php artisan test
```

## 📱 Responsive Design

OctoPOS is built with a responsive design that works across devices:
- Desktop interfaces for management and administrative tasks
- Tablet-optimized interfaces for servers and kitchen staff
- Mobile responsive customer-facing pages for reservations and feedback

## 🔐 Security

OctoPOS implements industry-standard security practices:
- Role-based access control
- Data encryption at rest and in transit
- CSRF protection
- Input validation and sanitization
- Regular security updates

## 🛠️ Customization

The system can be customized in various ways:
- Restaurant themes and branding
- Menu categories and layouts
- Receipt templates and content
- User permission settings
- Notification preferences

## 📄 License

OctoPOS is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 📞 Support

For support, feature requests, or bug reports, please open an issue on our GitHub repository or contact us at support@octopos.com.

## 🤝 Contributing

We welcome contributions to OctoPOS! Please see our [Contributing Guidelines](CONTRIBUTING.md) for more information.

---

<p align="center">
  <sub>© 2025 OctoPOS. All rights reserved.</sub><br>
  <sub>Last updated: May 7, 2025</sub>
</p>
