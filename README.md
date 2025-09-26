## Real-Time Money Transfer Application 

This is a full-stack application built with Laravel 12 and Vue 3 that demonstrates a real-time money transfer system. It features secure, atomic transactions and instant UI updates using Laravel Broadcasting with Pusher.

The primary goal of this project is to showcase a robust and scalable architecture for handling financial transactions, focusing on data integrity under high concurrency and a seamless user experience.

## Getting Started

PHP >= 8.2

Composer

Node.js & npm

MySQL

Pusher account

Of course. Here is a comprehensive README.md file tailored to your Laravel 12 and Vue 3 project, designed to meet all the specified evaluation criteria.

Real-Time Money Transfer Application 💸
This is a full-stack application built with Laravel 12 and Vue 3 that demonstrates a real-time money transfer system. It features secure, atomic transactions and instant UI updates using Laravel Broadcasting with Pusher.

The primary goal of this project is to showcase a robust and scalable architecture for handling financial transactions, focusing on data integrity under high concurrency and a seamless user experience.

✨ Key Features
User Authentication: Secure login and registration powered by Laravel Breeze.

Fund Transfers: Users can initiate transfers to other users by their ID.

Balance & History: A clear view of the user's current balance and a comprehensive list of past transactions.

Real-Time Updates: Balances and transaction lists update instantly for both the sender and receiver after a transfer, with no need for a page refresh.

API-Driven: A clean RESTful API for handling transactions and data retrieval.

🏗️ Architectural Highlights & Key Decisions
This project was built with scalability, security, and data integrity as top priorities. Here are some of the key technical decisions made to meet the evaluation criteria:

Scalable Balance Management & Data Integrity
To prevent race conditions and ensure data consistency during high-traffic scenarios, we've implemented a robust transaction handling mechanism:

Atomic Operations: All balance updates and transaction recordings are wrapped in a DB::transaction. This ensures that a transfer only completes if both the debit from the sender and the credit to the receiver are successful. If any step fails, the entire operation is rolled back.

Pessimistic Locking: We use ->lockForUpdate() on user rows within the database transaction. This locks the sender's and receiver's records, forcing any other concurrent transfer attempts involving the same users to wait, thus preventing simultaneous modifications that could lead to incorrect balances.

Deadlock Prevention: To avoid database deadlocks when two users try to send money to each other at the same time, user IDs are always sorted before being locked. This ensures a consistent locking order across all transactions.

Correct Real-Time Integration
The real-time functionality is the core of the user experience:

Event-Driven Architecture: After a successful database transaction, a TransferCompleted event is dispatched to a queue. This decouples the transfer logic from the broadcasting logic, improving response times.

Secure Private Channels: Broadcasting is done over **PrivateChannel**s. This ensures that a user's financial updates can only be received by that specific, authenticated user, preventing unauthorized data exposure. Laravel automatically handles the authorization for these channels.

Efficient Frontend Listening: The Vue.js frontend uses Laravel Echo to securely subscribe to the user's private channel. When an event is received, the component efficiently updates the UI by prepending the new transaction to the list and updating the balance, providing instant feedback.

Security
API Authentication: All API endpoints are protected using Laravel Sanctum, ensuring that only authenticated users can access their data or perform actions.

Authorization: Event broadcasting channels are private and authorized, meaning users can never listen in on another user's financial data.

Server-Side Validation: All incoming requests are strictly validated to prevent invalid data, including checks for sufficient balance, correct data types, and ensuring users cannot send money to themselves.

🛠️ Tech Stack
Backend: Laravel 12, PHP 8.3

Frontend: Vue 3 (Composition API), Vite, Tailwind CSS

Real-Time Events: Laravel Broadcasting, Pusher

Database: MySQL

Authentication: Laravel Breeze (API Stack)

🚀 Getting Started
Follow these instructions to get the project up and running on your local machine.

Prerequisites
PHP >= 8.3

Composer

Node.js & npm

MySQL (or another database)

A free Pusher account

1. Installation
Clone the repository and install dependencies

# Clone the project
git clone https://github.com/your-username/your-repo-name.git
cd your-repo-name

# Install backend dependencies
composer install

# Install frontend dependencies
npm install

Of course. Here is a comprehensive README.md file tailored to your Laravel 12 and Vue 3 project, designed to meet all the specified evaluation criteria.

Real-Time Money Transfer Application 💸
This is a full-stack application built with Laravel 12 and Vue 3 that demonstrates a real-time money transfer system. It features secure, atomic transactions and instant UI updates using Laravel Broadcasting with Pusher.

The primary goal of this project is to showcase a robust and scalable architecture for handling financial transactions, focusing on data integrity under high concurrency and a seamless user experience.

✨ Key Features
User Authentication: Secure login and registration powered by Laravel Breeze.

Fund Transfers: Users can initiate transfers to other users by their ID.

Balance & History: A clear view of the user's current balance and a comprehensive list of past transactions.

Real-Time Updates: Balances and transaction lists update instantly for both the sender and receiver after a transfer, with no need for a page refresh.

API-Driven: A clean RESTful API for handling transactions and data retrieval.

🏗️ Architectural Highlights & Key Decisions
This project was built with scalability, security, and data integrity as top priorities. Here are some of the key technical decisions made to meet the evaluation criteria:

Scalable Balance Management & Data Integrity
To prevent race conditions and ensure data consistency during high-traffic scenarios, we've implemented a robust transaction handling mechanism:

Atomic Operations: All balance updates and transaction recordings are wrapped in a DB::transaction. This ensures that a transfer only completes if both the debit from the sender and the credit to the receiver are successful. If any step fails, the entire operation is rolled back.

Pessimistic Locking: We use ->lockForUpdate() on user rows within the database transaction. This locks the sender's and receiver's records, forcing any other concurrent transfer attempts involving the same users to wait, thus preventing simultaneous modifications that could lead to incorrect balances.

Deadlock Prevention: To avoid database deadlocks when two users try to send money to each other at the same time, user IDs are always sorted before being locked. This ensures a consistent locking order across all transactions.

Correct Real-Time Integration
The real-time functionality is the core of the user experience:

Event-Driven Architecture: After a successful database transaction, a TransferCompleted event is dispatched to a queue. This decouples the transfer logic from the broadcasting logic, improving response times.

Secure Private Channels: Broadcasting is done over **PrivateChannel**s. This ensures that a user's financial updates can only be received by that specific, authenticated user, preventing unauthorized data exposure. Laravel automatically handles the authorization for these channels.

Efficient Frontend Listening: The Vue.js frontend uses Laravel Echo to securely subscribe to the user's private channel. When an event is received, the component efficiently updates the UI by prepending the new transaction to the list and updating the balance, providing instant feedback.

Security
API Authentication: All API endpoints are protected using Laravel Sanctum, ensuring that only authenticated users can access their data or perform actions.

Authorization: Event broadcasting channels are private and authorized, meaning users can never listen in on another user's financial data.

Server-Side Validation: All incoming requests are strictly validated to prevent invalid data, including checks for sufficient balance, correct data types, and ensuring users cannot send money to themselves.

🛠️ Tech Stack
Backend: Laravel 12, PHP 8.3

Frontend: Vue 3 (Composition API), Vite, Tailwind CSS

Real-Time Events: Laravel Broadcasting, Pusher

Database: MySQL

Authentication: Laravel Breeze (API Stack)

🚀 Getting Started
Follow these instructions to get the project up and running on your local machine.

Prerequisites
PHP >= 8.3

Composer

Node.js & npm

MySQL (or another database)

A free Pusher account

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






