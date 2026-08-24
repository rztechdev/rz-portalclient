# RZ Portal (rz-portalclient)

Platform Sistem Manajemen Operasional Terpadu & Orkestrasi Proyek resmi **RZ Digital Creative**.

- **Portal Klien**: [https://portalclient.rzdigitalcreative.my.id](https://portalclient.rzdigitalcreative.my.id)
- **Website Profil Agensi**: [https://rzdigitalcreative.my.id](https://rzdigitalcreative.my.id)

---

## 🚀 Deskripsi Proyek
**RZ Portal** dirancang untuk menyatukan tiga pilar utama operasional agensi:
1. **Pelacakan Kepatuhan SLA & Tiket Kendala IT** secara otomatis dan real-time.
2. **Delegasi Tugas Tim Teknis & Kolaborasi Proyek (Papan Kanban)**.
3. **Repositori Dokumen Proyek & Dasbor Monitoring Eksekutif**.

---

## 🔑 Fitur Utama
* **Role-Based Access Control (RBAC)**: Otentikasi multi-peran untuk CEO / Direktur, Project Manager (PM), Tim Teknis, dan Klien.
* **SLA Tracking & Live Timer**: Penghitung durasi penyelesaian tiket otomatis tanpa pelaporan manual.
* **Dasbor Monitoring**: Analisis performa kerja tim dan kepuasan pelanggan secara real-time.
* **Dark Mode & Responsive UI**: Tampilan antarmuka modern dengan dukungan tema gelap / terang otomatis.

---

## 🛠️ Stack Teknologi
* **Framework**: Laravel 12
* **Styling**: Tailwind CSS v4 & Google Material Symbols
* **Interaktivitas**: Alpine.js
* **Build Tool**: Vite
* **Database**: MySQL / SQLite

---

## 📦 Instalasi & Menjalankan Lokal

```bash
# Clone repository
git clone https://github.com/rztechdev/rz-portalclient.git

# Masuk ke direktori
cd rz-portalclient

# Install PHP dependencies
composer install

# Install JS dependencies
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Jalankan migrasi & seeder
php artisan migrate --seed

# Build frontend assets
npm run build
# Atau untuk mode dev
npm run dev

# Jalankan server
php artisan serve
```

---

&copy; 2026 RZ Digital Creative. All rights reserved.

