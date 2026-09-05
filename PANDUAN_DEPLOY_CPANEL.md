# 📘 Panduan Lengkap Deploy RZ Portal Client ke cPanel

Panduan ini untuk mengaktifkan project **RZ Portal Client** di subdomain **`portalclient.rzdigitalcreative.my.id`**.

---

## 📋 Ringkasan Info Project
* **Subdomain**: `portalclient.rzdigitalcreative.my.id`
* **Folder cPanel**: `/home/rzdigita/repositories/rz-portalclient`
* **Document Root**: `repositories/rz-portalclient/public`
* **Database**: MySQL cPanel

---

## 🚀 Langkah 1: Buat Database MySQL di cPanel

1. Di cPanel, buka menu **`MySQL® Databases`** (di bagian Databases).
2. **Buat Database Baru**:
   - Di bagian *Create New Database*, ketik nama DB, misal: `portal`
   - Klik **Create Database**.  
   *(Nama lengkap database akan menjadi: `rzdigita_portal`)*
3. **Buat User Database Baru**:
   - Scroll ke bagian *MySQL Users > Add New User*.
   - Username: `portal_user`
   - Password: Buat password yang kuat (contoh: `PortalSecret2026!#`)
   - Klik **Create User**.  
   *(Nama lengkap user akan menjadi: `rzdigita_portal_user`)*
4. **Hubungkan User ke Database**:
   - Scroll ke bagian *Add User To Database*.
   - Pilih User: `rzdigita_portal_user`
   - Pilih Database: `rzdigita_portal`
   - Klik **Add**.
   - Centang opsi **ALL PRIVILEGES** ➡️ klik **Make Changes**.

---

## 🌐 Langkah 2: Buat Subdomain (Jika Belum)

1. Di cPanel, buka menu **`Domains`**.
2. Klik **Create A New Domain**:
   - **Domain**: `portalclient.rzdigitalcreative.my.id`
   - **Share document root**: **Hapus centang (Uncheck)**
   - **Document Root**: `repositories/rz-portalclient/public`
3. Klik **Submit**.
4. Aktifkan toggle **Force HTTPS Redirect** ke posisi **On**.

---

## ⚙️ Langkah 3: Setup File `.env` di cPanel

1. Di **File Manager cPanel**, buka folder:
   `/home/rzdigita/repositories/rz-portalclient/`
2. Buat file baru bernama **`.env`** (atau edit jika sudah ada).
3. Isi dengan konfigurasi berikut (sesuaikan nama DB dan password yang dibuat di Langkah 1):

```ini
APP_NAME="RZ Portal Klien"
APP_ENV=production
APP_KEY=base64:MF7F5ue8hStSRbzLPck1rp9qe2jzJhoaB5zXpMlF80w=
APP_DEBUG=false
APP_TIMEZONE=Asia/Jakarta
APP_URL=https://portalclient.rzdigitalcreative.my.id

APP_LOCALE=id
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=id_ID

APP_MAINTENANCE_DRIVER=file

# ====== AKUN ADMIN PORTAL ======
ADMIN_NAME="Owner RZ Digital"
ADMIN_EMAIL=rzcompanyidn@gmail.com
ADMIN_PASSWORD="12345678"

BCRYPT_ROUNDS=12
LOG_CHANNEL=stack
LOG_STACK=single
LOG_LEVEL=error

# ====== DATABASE MYSQL CPANEL ======
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rzdigita_db_rz_portalclient
DB_USERNAME=rzdigita_db_rzdigitalcreative
DB_PASSWORD="LE9P@rUVe84mXhV"

SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false

CACHE_STORE=database
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=local
BROADCAST_CONNECTION=log

# ====== EMAIL NOTIFIKASI CPANEL SMTP ======
MAIL_MAILER=smtp
MAIL_SCHEME=smtps
MAIL_HOST=mail.rzdigitalcreative.my.id
MAIL_PORT=465
MAIL_USERNAME=company@rzdigitalcreative.my.id
MAIL_PASSWORD=@kebersamaanf0nsi13
MAIL_FROM_ADDRESS="company@rzdigitalcreative.my.id"
MAIL_FROM_NAME="RZ Digital Creative"

# Catatan Operasional:
# Konfigurasi WhatsApp Gateway (Flustra), Rekening BCA, Barcode QRIS,
# dan Notifikasi Admin tersinkronisasi otomatis dari database CRM / CompanySetting,
# tanpa perlu membuka atau mengedit file .env ini lagi.
```
4. Klik **Save Changes**.

---

## 📦 Langkah 4: Upload `vendor.zip` & `public_assets.zip`

File zip sudah disiapkan di folder komputer Anda (`d:\Project - Rz digital creative\rz - portal-client\`):

1. **Upload `vendor.zip`**:
   - Di File Manager, masuk ke `/home/rzdigita/repositories/rz-portalclient/`
   - Upload file **`vendor.zip`** ➡️ lalu klik kanan **Extract**.
2. **Upload `public_assets.zip`**:
   - Di File Manager, masuk ke `/home/rzdigita/repositories/rz-portalclient/public/`
   - Upload file **`public_assets.zip`** ➡️ lalu klik kanan **Extract**.

---

## ⚡ Langkah 5: Jalankan Migrasi & Database Seeder (Otomatis)

Karena tidak ada akses terminal SSH, jalankan migrasi database lewat skrip helper ini:

1. Di File Manager, buka folder:
   `/home/rzdigita/repositories/rz-portalclient/public/`
2. Buat file baru bernama **`migrate.php`**.
3. Isi dengan kode berikut:

```php
<?php
use Illuminate\Support\Facades\Artisan;

define('LARAVEL_START', microtime(true));
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

echo "<h2>Menjalankan Migrasi & Seed Database RZ Portal...</h2>";

try {
    // 1. Migrate Database
    Artisan::call('migrate', ['--force' => true]);
    echo "<p style='color:green'>✔ Migrasi Database: " . nl2br(Artisan::output()) . "</p>";

    // 2. Seed Database (Akun Admin)
    Artisan::call('db:seed', ['--force' => true]);
    echo "<p style='color:green'>✔ Seed Admin: " . nl2br(Artisan::output()) . "</p>";

    // 3. Storage Link
    Artisan::call('storage:link');
    echo "<p style='color:green'>✔ Storage Link: " . nl2br(Artisan::output()) . "</p>";

    echo "<h3 style='color:green'>BERHASIL! Silakan hapus file migrate.php ini demi keamanan.</h3>";
} catch (\Exception $e) {
    echo "<p style='color:red'>ERROR: " . $e->getMessage() . "</p>";
}
```
4. Simpan file.
5. Buka di browser:  
   👉 **`https://portalclient.rzdigitalcreative.my.id/migrate.php`**
6. Setelah muncul pesan sukses, **HAPUS** file `migrate.php` tersebut.

---

## 🔑 Login Default Admin
Setelah berhasil, buka `https://portalclient.rzdigitalcreative.my.id` lalu login:
* **Email**: `rztechdevidn@gmail.com`
* **Password**: `12345678` *(segera ganti setelah login)*
