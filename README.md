# De'Pallet Cafe Project
A web-based integrated information system for a multi-stall foodcourt business, covering order management, table reservations, simple delivery services, simple payment validation, and sales reporting.

## Overview

De'Pallet Cafe is a foodcourt concept operating food stalls and beverage stall under a centralized management model. This system was built to digitalize and streamline the entire business operation from customer ordering to owner-level financial reporting, replacing previously manual, paper-based workflows.
 
The system is designed for a target demographic of 18–55 year old users and supports multiple service modes: dine-in (via QR code), table reservation with pre-ordering, and delivery.

## Tech Stack
 
| Layer | Technology |
|---|---|
| Frontend | Blade + Tailwind CSS |
| Backend | Laravel (PHP) |
| Database | MySQL |
> *Note: To be updated during development phase*

## Getting Started (Development)
  
### 1. Clone Repository
 
```bash
git clone https://github.com/your-username/depallet-cafe.git
cd depallet-cafe
```
 
### 2. Install Dependencies
 
```bash
# Install PHP dependencies
composer install
 
# Install JS dependencies
npm install
```
 
### 3. Konfigurasi Environment
 
```bash
# Salin file environment
cp .env.example .env
```
 
Buka file `.env`, lalu sesuaikan bagian berikut:
 
```env
APP_NAME="De'Pallet Cafe"
APP_URL=http://localhost:8000
 
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=depallet
```

### 4. Generate Application Key
 
```bash
php artisan key:generate
```

### 5. Setup Database
 
```bash
# Buat database bernama 'depallet' di MySQL terlebih dahulu
# lalu jalankan migration
php artisan migrate
 
# Seed data awal (role, stall, akun default)
php artisan db:seed
```
 
Kalau mau reset database dari awal:
 
```bash
php artisan migrate:fresh --seed
```
> ⚠️ `migrate:fresh` akan **menghapus semua data** di database lokal dan mengisinya ulang dari seeder.
 
### 6. Jalankan Development Server
 
Buka **dua terminal** secara bersamaan:
 
```bash
# Terminal 1 — Laravel backend
php artisan serve
```
 
```bash
# Terminal 2 — Vite (hot reload Tailwind & JS)
npm run dev
```
 
Aplikasi akan berjalan di `http://localhost:8000`.
