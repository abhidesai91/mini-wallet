## Mini Wallet — Real‑Time Money Transfer (Laravel 12 + Vue 3)

A full‑stack mini wallet demonstrating secure, atomic money transfers with instant UI updates. The app uses database transactions for integrity, Laravel Broadcasting (Pusher) for real‑time events, Vue 3 for the SPA, and Tailwind CSS for styling.

### Highlights
- Atomic transfers with clear consistency rules
- Real‑time balance/transaction updates via Laravel Echo + Pusher
- Queue worker for event broadcasting and background jobs
- Modern frontend: Vue 3, Vite, Tailwind CSS 4
- Clean, testable Laravel 12 backend with Sanctum

---

## Tech Stack
- Backend: Laravel 12, PHP 8.2, Sanctum, Pusher PHP Server
- Frontend: Vue 3, Vue Router, Vite 7, Tailwind CSS 4, Laravel Echo + pusher-js
- Tooling: PHPUnit, Laravel Pint, Laravel Pail, concurrently

---

## Prerequisites
- PHP >= 8.2 and Composer
- Node.js >= 18 and npm
- Database: MySQL or SQLite
- Pusher account (for real‑time broadcasting)

---

## Quick Start (one command)
From the project root after installing dependencies and configuring .env:

- Start everything together (server, queue worker, logs, Vite):
  - composer run dev

> The dev script runs php artisan serve, queue:listen, pail (logs), and Vite concurrently.

---

## Setup

1) Clone and install dependencies
- git clone <your-repo-url>
- cd mini-wallet
- composer install
- npm install

2) Environment configuration
- cp .env.example .env
- php artisan key:generate
- Edit .env and set at least the following:

Database (choose one)
- MySQL
  - DB_CONNECTION=mysql
  - DB_HOST=127.0.0.1
  - DB_PORT=3306
  - DB_DATABASE=your_db_name
  - DB_USERNAME=your_db_user
  - DB_PASSWORD=your_db_password
- SQLite (quick start)
  - DB_CONNECTION=sqlite
  - Ensure database/database.sqlite exists (it is included/created by composer scripts)

Broadcasting (Pusher)
- BROADCAST_DRIVER=pusher
- PUSHER_APP_ID=your_pusher_app_id
- PUSHER_APP_KEY=your_pusher_app_key
- PUSHER_APP_SECRET=your_pusher_app_secret
- PUSHER_APP_CLUSTER=your_pusher_cluster
- PUSHER_HOST= (usually leave empty)
- PUSHER_PORT=443
- PUSHER_SCHEME=https

Vite/Echo (must match Pusher values)
- VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
- VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

3) Database
- Run migrations: php artisan migrate
- Optionally seed (if seeders are available): php artisan db:seed

4) Run the app
  - php artisan serve
  - npm run dev

Open the app in your browser at the URL printed by php artisan serve (default http://127.0.0.1:8000).

---