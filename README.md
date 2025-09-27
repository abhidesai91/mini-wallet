## Real-Time Money Transfer Application 

This is a full-stack application built with Laravel 12 and Vue 3 that demonstrates a real-time money transfer system. It features secure, atomic transactions and instant UI updates using Laravel Broadcasting with Pusher.

The primary goal of this project is to showcase a robust and scalable architecture for handling financial transactions, focusing on data integrity under high concurrency and a seamless user experience.

## Getting Started

PHP >= 8.2

Composer

Node.js & npm

MySQL

Pusher account



## Tech Stack
Backend: Laravel 12, PHP 8.2

1. Installation
Clone the repository and install dependencies.

Bash

# Clone the project
git clone https://github.com/your-username/your-repo-name.git
cd your-repo-name

# Install backend dependencies
composer install

# Install frontend dependencies
npm install

2. Environment Configuration
Create your .env file and configure it.

# Copy the example environment file
cp .env.example .env

# Generate a new application key
php artisan key:generate

Next, open the .env file and update the following variables with your credentials:

# .env

# --- Database Connection ---
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

# --- Broadcasting with Pusher ---
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_pusher_app_id
PUSHER_APP_KEY=your_pusher_app_key
PUSHER_APP_SECRET=your_pusher_app_secret
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=your_pusher_cluster

# --- Vite Configuration for Frontend ---
# This must match your Pusher App Key and Cluster
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

3. Database

Run the database migrations to create the necessary tables and seed the database with some sample users and transactions.

## Run Migration
php artisan migrate

4. Running the Application

php artisan serve

npm run dev






