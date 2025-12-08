# Laravel Hotel Management System

A comprehensive Hotel Management System built with Laravel, designed to streamline hotel operations including reservations, room management, and staff administration.

<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
    </a>
</p>

<p align="center">
    <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
    <img src="https://img.shields.io/badge/PHP-8.2%2B-777BB4" alt="PHP Version">
    <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20" alt="Laravel Version">
</p>

## About

The **Laravel Hotel Management System** is a robust web application tailored for the hospitality industry. It empowers hotel managers, receptionists, and staff to efficiently manage rooms, floors, and guest reservations. With a focus on user experience and administrative control, it features role-based access control, real-time metrics, and a seamless booking flow for clients.

## Key Features

-   **Role-Based Access Control (RBAC)**: Distinct panels for Admins, Managers, Receptionists, and Clients using `spatie/laravel-permission`.
-   **Room & Floor Management**: Complete CRUD operations for managing hotel infrastructure.
-   **Reservation System**: Streamlined booking process for clients with real-time room availability.
-   **User Management**: Admin tools to manage staff and client accounts, including banning capabilities.
-   **Payment Integration**: Stripe integration for secure payment processing.
-   **Interactive Dashboard**: Data-driven dashboards for admins and managers using Inertia.js and Vue.
-   **Modern Frontend**: Built with Vue 3, Tailwind CSS, and Shadcn UI for a polished, responsive interface.

## Technology Stack

-   **Backend**: [Laravel 12](https://laravel.com)
-   **Frontend**: [Vue 3](https://vuejs.org), [Inertia.js](https://inertiajs.com), [Tailwind CSS](https://tailwindcss.com)
-   **Database**: MySQL / SQLite
-   **Authentication**: Laravel Breeze / Sanctum
-   **Utilities**: Spatie Permissions, Maatwebsite Excel, Stripe PHP

## Prerequisites

Before setting up the project, ensure you have the following installed:

-   [PHP](https://www.php.net/downloads) >= 8.2
-   [Composer](https://getcomposer.org/)
-   [Node.js](https://nodejs.org/) & NPM
-   [MySQL](https://www.mysql.com/) (or use SQLite)

## Installation Guide

Follow these steps to get the project running locally:

### 1. Clone the Repository
```bash
git clone https://github.com/yourusername/laravel-hotel-managment-system.git
cd laravel-hotel-managment-system
```

### 2. Install Dependencies
Install PHP and JavaScript dependencies:
```bash
composer install
npm install
```

### 3. Environment Setup
Copy the example environment file and configure your database settings:
```bash
cp .env.example .env
```
Update `.env` with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotel_management
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate App Key
```bash
php artisan key:generate
```

### 5. Database Migration & Seeding
Run migrations and seed the database with default roles and an admin user:
```bash
php artisan migrate --seed
```
*Note: This will verify the `AdminSeeder` and `RoleSeeder` are executed correctly.*

### 6. Run the Application
Start the local development server and build assets:
```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

Visit `http://localhost:8000` in your browser.

## Default Credentials

The application comes with a pre-configured admin account (seeded via `AdminSeeder`):

-   **Email**: `admin@admin.com`
-   **Password**: `123456`
-   **Role**: Admin

> [!IMPORTANT]
> Please change these credentials immediately after deployment or in a production environment.

## Screenshots

*(Placeholder for screenshots of the Dashboard, Reservation Flow, and Room Management views)*

## License

The Laravel framework and this project are open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
