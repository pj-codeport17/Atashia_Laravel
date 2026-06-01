# Daily Journal — Laravel Web Application

A full-featured daily journaling web app built with **Laravel 12**, **Bootstrap 5**, and **Chart.js**. It demonstrates authentication, CRUD operations, dashboard reporting, session handling, toast notifications, and production-ready web hosting setup.

## Features

| Feature | Implementation |
|---------|----------------|
| **Authentication** | Login, registration, logout with session-based auth |
| **CRUD** | Create, read, update, delete journal entries |
| **Dashboard** | Line chart (entries over time), doughnut chart (mood distribution), stats cards |
| **UI** | Bootstrap 5, custom warm journal theme, responsive sidebar |
| **Sessions** | Laravel session driver, remember-me, flash toasts |
| **Toasts** | Bootstrap toast notifications on success/error/info |

## Requirements

- PHP 8.2+
- Composer
- SQLite (default) or MySQL for production hosting

## Quick Start (Local)

```bash
cd DailyJournal
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```

Open [http://127.0.0.1:8000](http://127.0.0.1:8000)

### Demo account

| Email | Password |
|-------|----------|
| `demo@dailyjournal.test` | `password` |

## Web Hosting (cPanel / Shared Hosting)

1. Upload all project files to your host (or deploy via Git).
2. Point the domain **document root** to the `public/` folder.
3. Copy `.env.example` to `.env` and configure:

```env
APP_NAME="Daily Journal"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_user
DB_PASSWORD=your_password

SESSION_DRIVER=database
SESSION_LIFETIME=120
```

4. Run on the server (SSH or host terminal):

```bash
composer install --optimize-autoloader --no-dev
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

5. Set folder permissions: `storage/` and `bootstrap/cache/` writable by the web server.

## Project Structure

```
app/
  Http/Controllers/
    Auth/          LoginController, RegisterController
    DashboardController.php
    JournalEntryController.php
  Models/
    JournalEntry.php, User.php
resources/views/
  auth/            login, register
  dashboard/       charts & stats
  journal/         CRUD views
  layouts/         app, guest
  partials/        sidebar, toasts
public/css/app.css  Custom journal theme
```

## Routes

| Method | URI | Description |
|--------|-----|-------------|
| GET | `/login` | Login form |
| POST | `/login` | Authenticate |
| GET | `/register` | Registration form |
| POST | `/register` | Create account |
| POST | `/logout` | End session |
| GET | `/dashboard` | Charts & statistics |
| GET/POST | `/journal` | List / create entries |
| GET/PUT/DELETE | `/journal/{id}` | View / edit / delete |

## Design Note

The UI follows a warm minimalist **Daily Journal** aesthetic (cream background, terracotta accents, Playfair Display headings, sidebar navigation). If you have access to the [Figma design file](https://www.figma.com/make/0jxO1lt65WWoTXoMl74POF/Design-Daily-Journal), you can fine-tune colors and spacing in `public/css/app.css` to match pixel-perfect specs.

## License

MIT
