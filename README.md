# Mishkat Nour Small Task

Modern Laravel + Vue 3 + Vite project.

## Features

- **Categories CRUD** 
- **Products CRUD** 
- **Public Shop Page**  
  - View all products  with filters
  - Responsive design (Tailwind )
- Minimal clean welcome/landing page
- Vue 3 + Composition API + TypeScript
- Vite for fast frontend development
- Axios for API calls
- Laravel API routes + Sanctum for SPA authentication

## Tech Stack

- **Backend**: Laravel 11/12 • PHP 8.2+
- **Frontend**: Vue 3 • Vite • TypeScript (optional) • Tailwind CSS • Shadcn/vue
- **Database**: MySQL
- **HTTP Client**: Axios
- **State Management**: Pinia (optional)
- **Authentication**: Laravel Sanctum + Vue SPA

### 1. Clone the repository
bash
git clone https://github.com/yourusername/mishkat-nour-shop.git

cd mishkat-nour-shop

### 2. Install PHP dependencies
composer install
### 3. Install frontend dependencies (using pnpm)
pnpm install | npm install

pnpm run build | npm run build
### 4. Copy environment file & configure
cp .env.example .env

Edit .env file and configure:

APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1

DB_PORT=3306

DB_DATABASE=mishkat_nour

DB_USERNAME=root

DB_PASSWORD=

### 5. Generate application key
php artisan key:generate
### 6. Run database migrations + seed
php artisan migrate --seed

php artisan db:seed --class=CategorySeeder

php artisan db:seed --class=ProductSeeder

The seeder will create some sample categories and products

### 7. Start the servers
Terminal 1 – Laravel backend

php artisan serve

Terminal 2 – Vite frontend (hot-reload)

pnpm run dev | npm run dev

Now open your browser:

Backend + SPA: http://localhost:8000

### 8. (Optional) Build for production
pnpm run build | npm run build

# Clear all caches
php artisan optimize:clear

# Re-run migrations + seed fresh
php artisan migrate:fresh --seed

# Run tests (if you added any)
php artisan test

# Api Ref.
There is a postman collection provided for api routes

Made with ❤️ in Giza, Egypt
