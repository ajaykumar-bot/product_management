# Laravel Passport API Starter

This is a Laravel 12 API starter project using **Laravel Passport** for authentication. It includes a basic setup with user login, and protected routes.

---

## Requirements

-   PHP 8.3
-   Composer
-   Laravel 12
-   MySQL

## 🚀 Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/ajaykumar-bot/product_management.git
cd product_management
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Create Environment File

```bash
cp .env.example .env
```

Configure your database and other credentials in `.env`.

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Run Migrations

```bash
php artisan migrate
```

### 6. Generate passport keys

```bash
php artisan passport:keys
```

### 7. Create personal access clien

```bash
php artisan passport:client --personal
```

This will:

-   Generate encryption keys for Passport.
-   Create personal access and password grant clients.
-   Store them in the `oauth_clients` table.

> ⚠️ If you run `php artisan migrate:refresh` in the future, you'll need to rerun `passport:client --personal`.

### 8. start the server

```bash
php artisan serve
```
