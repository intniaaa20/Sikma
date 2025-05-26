# SIKMA - Sistem Informasi Katering Makanan

Sistem aplikasi Laravel untuk pemesanan makanan, pengelolaan menu, promo bundle, dan integrasi pembayaran Midtrans.

---

## Cara Penggunaan & Instalasi Project

### 1. Clone & Install Dependency

```powershell
git clone <repo-anda>
cd Sikma
composer install
npm install
```

### 2. Copy & Edit Environment

```powershell
copy .env.example .env
```

Edit file `.env` sesuai konfigurasi database dan Midtrans Anda.

### 3. Generate Key

```powershell
php artisan key:generate
```

### 4. Migrasi Database

```powershell
php artisan migrate
```

### 5. Jalankan Seeder (User, Menu, Promo, dst)

```powershell
php artisan db:seed
```

Seeder akan otomatis mengisi data contoh user, menu, dan promo bundle.

### 6. Compile Asset Frontend (Vite)

```powershell
npm run dev
```

### 7. Jalankan Server Laravel

```powershell
php artisan serve
```

Akses aplikasi di http://127.0.0.1:8000

---

## Data Seeder

-   **UserSeeder**: Admin & Customer default (admin@example.com / customer@example.com, password: password)
-   **MenuSeeder**: Contoh menu (Ayam Bakar, Nasi Goreng, Es Teh Manis)
-   **PromoSeeder**: Bundle Ayam Bakar + Nasi Goreng (diskon Rp 5.000), Diskon Es Teh Manis (Rp 1.000)

---

## Dokumentasi API (Midtrans)

### Membuat Snap Token

`POST /api/payment/midtrans/token`

**Body:**

```json
{
    "order_id": "ORDER-12345",
    "gross_amount": 25000,
    "customer": {
        "first_name": "Budi",
        "email": "budi@email.com",
        "phone": "08123456789"
    }
}
```

**Response:**

```json
{
    "success": true,
    "snap_token": "...",
    "redirect_url": "https://app.sandbox.midtrans.com/snap/v2/vtweb/..."
}
```

### Notifikasi Pembayaran (Webhook)

`POST /api/payment/midtrans/notification`

**Body:**

```json
{
  "transaction_status": "settlement",
  "order_id": "ORDER-12345",
  ...
}
```

---

## User Manual (Panduan Pengguna)

### 1. Menambah Item ke Keranjang

-   Pilih menu dan tambahkan ke keranjang.
-   Untuk promo bundle, pastikan semua item bundle dimasukkan dengan jumlah sesuai.

### 2. Melihat Keranjang

-   Bundle promo tampil satu baris ringkasan jika aktif.
-   Harga menu tetap normal, diskon hanya di subtotal/total.

### 3. Checkout

-   Pilih item yang ingin dipesan (bisa centang/uncentang bundle).
-   Pada ringkasan pembayaran, bundle tampil satu baris dengan harga final setelah diskon.

### 4. Melihat Riwayat Pesanan

-   Jika pesanan mengandung bundle, akan tampil satu baris ringkasan bundle dan label "Promo Bundle: Sudah termasuk diskon".
-   Harga yang tampil adalah harga final setelah diskon.

---

## Catatan

-   Untuk menambah data lain, edit/tambah file seeder di `database/seeders/` lalu jalankan `php artisan db:seed`.
-   Untuk pengembangan, gunakan branch terpisah dan pull request.
-   Untuk Pembelian Menggunakan Midtrans masi ada kendala

---

## _Project ini masih dalam tahap pengembangan dan masih banyak yang harus ditambahkan._
