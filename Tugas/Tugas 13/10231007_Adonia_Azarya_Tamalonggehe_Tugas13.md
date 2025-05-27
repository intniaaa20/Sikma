# Laporan Progres Mingguan - [SIKMA]
**Kelompok**: [3]

**Anggota**
    
    -Adonia Azarya Tamalonggehe (10231007)
    -Betran (10231023)
    -Debora Intania Subekti (10231029)
    -Incha Raghil (10231043)


**Mitra**: [Warung Pak Jhon]

**Pekan ke-**: [13]

**Tanggal**: [10/05/2025]

### Github SIKMA : https://github.com/intniaaa20/Sikma
### Figma SIKMA : https://www.figma.com/design/0lLAy1gRWl3SUQgvryOyKi/SIKMA?node-id=0-1&t=kr0uYpjr4UzalfBe-1

## Progress Summary
Pada Pekan 13 , fokus utama adalah melanjutkan pengembangan fitur inti aplikasi SIKMA (Sistem Informasi Catering Makanan) serta membangun admin panel sederhana. admin panel telah dibuat sebagai dashboard untuk mengelola data secara efisien, termasuk menu, pesanan, dan pelanggan. Visualisasi data sederhana juga telah ditambahkan untuk memberikan wawasan cepat tentang kinerja sistem, seperti grafik penjualan harian atau statistik pesanan.

## Accomplished Tasks
- **Implementasi fitur inti #4**
- **Pembuatan admin panel sederhana (sederhana)**


--- 

## Fitur Order
---

### **1. Halaman "Daftar Pesanan Saya"**
![alt text](<Screenshot 2025-05-10 010240.png>)
- **Deskripsi**: Tampilan halaman **Daftar Pesanan Saya**, yang menampilkan riwayat pesanan pengguna.
- **Fitur Utama**:
  - Kolom utama: **Nomor Pesanan (#)**, **Tanggal Pesanan**, **Total Harga**, dan **Status Pesanan**.
  - Status pesanan saat ini ditandai sebagai **Done**, menunjukkan bahwa pesanan telah selesai.
  - Tombol **Lihat** untuk melihat detail pesanan lebih lanjut.

- **Tujuan**: Memberikan pelanggan visibilitas lengkap tentang pesanan mereka, termasuk status terkini dan opsi untuk memeriksa detail pesanan.

---

### **2. Halaman Checkout**
![alt text](<Screenshot 2025-05-10 010257.png>)

- **Deskripsi**: Halaman **Checkout**, tempat pengguna mengonfirmasi informasi pesanan sebelum melakukan pembayaran.
- **Fitur Utama**:
  - **Alamat Pengiriman**: Form input untuk alamat pengantaran.
  - **Tanggal Pengiriman**: Input tanggal pengiriman (opsional).
  - **Pesan untuk Penjual**: Kolom untuk catatan tambahan (opsional).
  - **Opsi Pengiriman**: Pilihan antara Gojek atau Shopee Food.
  - **Metode Pembayaran**: Dropdown untuk memilih metode pembayaran.
  - **Rincian Pembayaran**: Menampilkan daftar item pesanan dan total harga.
  - Tombol **Buat Pesanan** untuk menyelesaikan transaksi.

- **Tujuan**: Mengumpulkan semua data penting dari pengguna (alamat, tanggal, catatan, dll.) sebelum pesanan diproses oleh sistem.

---

### **3. Halaman Metode Pembayaran (Midtrans)**
![alt text](<Screenshot 2025-05-10 010318.png>)
- **Deskripsi**: Pop-up halaman pembayaran menggunakan **Midtrans API**, yang menampilkan berbagai metode pembayaran. Integrasi Midtrans API dilakukan untuk menyediakan berbagai metode pembayaran seperti GoPay , Virtual Account , dan Credit/Debit Card dalam aplikasi SIKMA. Backend dikonfigurasi menggunakan Midtrans SDK untuk mengirim data transaksi (total harga, order ID, dll.) ke Midtrans saat pengguna memilih metode pembayaran. Callback URL diatur untuk menerima notifikasi status pembayaran (sukses, pending, atau gagal) dan mencatatnya di database. Hal ini memastikan proses transaksi berjalan lancar, aman, dan tercatat secara real-time.

- **Fitur Utama**:
  - **Metode Pembayaran**:
    - **GoPay/GoPay Later**: Opsi pembayaran instan atau nanti.
    - **Virtual Account**: Pilihan bank seperti BCA, Mandiri, BNI, dll.
    - **Credit/Debit Card**: Kartu kredit/debit seperti Visa, Mastercard, JCB, dll.
    - **Google Pay**: Alternatif pembayaran digital.
  - Total pembayaran ditampilkan (**Rp 45.000**) serta waktu batas pembayaran (**Choose within 23:59:51**).

- **Tujuan**: Memungkinkan pengguna memilih metode pembayaran sesuai preferensi mereka, dengan integrasi ke layanan pembayaran eksternal (Midtrans) untuk memastikan proses transaksi aman dan fleksibel.

---

## **Dashboard Admin**
---

### **1. Dashboard Utama**
![alt text](<Screenshot 2025-05-10 010104.png>)
- **Deskripsi**: Halaman utama admin panel, yang menampilkan informasi penting secara ringkas.
- **Fitur Utama**:
  - Tampilan dashboard dengan elemen-elemen seperti jumlah menu, pesanan, promosi, ulasan, dan pengguna.
  - Statistik bulanan (Monthly) untuk memberikan gambaran umum tentang kinerja sistem.
  - Navigasi ke halaman lainnya melalui menu sidebar (Menus, Orders, Promos, Reviews, Users).

---

### **2. Halaman Menus**
![alt text](<Screenshot 2025-05-10 010109.png>)
![alt text](<Screenshot 2025-05-10 010116.png>)
- **Deskripsi**: Halaman ini digunakan untuk mengelola daftar menu makanan.
- **Fitur Utama**:
  - Daftar menu dengan kolom: **Nama Menu**, **Harga**, **Status Ketersediaan (Is Available)**, dan **Gambar Menu**.
  - Tombol **Edit** untuk memperbarui detail menu.
  - Opsi pencarian (**Search**) dan filter berdasarkan kategori atau status.
  - Fitur tambahan seperti **Tambah Menu Baru (New Menu)**.

---

### **3. Halaman Orders (Pesanan)**
![alt text](<Screenshot 2025-05-10 010128.png>) 
![alt text](<Screenshot 2025-05-10 010123.png>)
- **Deskripsi**: Halaman ini digunakan untuk melihat dan mengelola pesanan pelanggan.
- **Fitur Utama**:
  - Daftar pesanan dengan kolom: **ID Pesanan**, **Total Harga**, **Status Pesanan**, dan **Tanggal Pengiriman**.
  - Tombol **Edit** untuk memperbarui status pesanan (misalnya, dari "Pending" menjadi "Done").
  - Opsi pencarian (**Search**) untuk mencari pesanan berdasarkan ID atau tanggal.
  - Fitur tambahan seperti **Tambah Pesanan Baru (New Order)**.

---

### **4. Halaman Users (Pengguna)**
![alt text](<Screenshot 2025-05-10 010140.png>)
- **Deskripsi**: Halaman ini digunakan untuk mengelola akun pengguna (pelanggan dan admin).
- **Fitur Utama**:
  - Daftar pengguna dengan kolom: **Nama Pengguna**, **Email**, **Peran (Role)**, dan **Status Blokir (Is Blocked)**.
  - Tombol **Edit** untuk memperbarui data pengguna, seperti peran atau status blokir.
  - Opsi pencarian (**Search**) untuk mencari pengguna berdasarkan nama atau email.
  - Fitur tambahan seperti **Tambah Pengguna Baru (New User)**.

---

### **5. Halaman Promos (Promosi)**
![alt text](<Screenshot 2025-05-10 010149.png>)
- **Deskripsi**: Halaman ini digunakan untuk membuat dan mengelola promosi.
- **Fitur Utama**:
  - Formulir untuk membuat promosi baru, termasuk:
    - Judul promosi (**Title**).
    - Deskripsi promosi (**Description**).
    - Path poster promosi (**Poster Path**).
    - Rentang waktu promosi (**Start Date** dan **End Date**).
  - Tidak ada promosi yang aktif saat ini (menunjukkan bahwa fitur ini masih dalam tahap awal pengembangan).

---

### **6. Halaman Reviews (Ulasan)**
![alt text](<Screenshot 2025-05-10 010154.png>)
- **Deskripsi**: Halaman ini digunakan untuk melihat ulasan pelanggan.
- **Fitur Utama**:
  - Saat ini belum ada ulasan yang tersedia (menunjukkan bahwa fitur ini masih dalam tahap awal pengembangan).
  - Ketika ulasan tersedia, halaman ini akan menampilkan daftar ulasan dengan detail seperti rating, komentar, dan tanggal ulasan.

---

### **7. Fitur Umum Admin Panel**
![alt text](<Screenshot 2025-05-10 010201.png>)
- **Navigasi Sidebar**: Menu navigasi di sebelah kiri yang memungkinkan admin beralih antara halaman-halaman utama (Dashboard, Menus, Orders, Promos, Reviews, Users).
- **Tombol Edit dan Delete**: Setiap entri memiliki tombol **Edit** untuk memperbarui data dan **Delete** untuk menghapus entri jika diperlukan.
- **Pencarian dan Filter**: Semua halaman utama mendukung pencarian dan filter untuk mempermudah administrasi data.
- **Desain Responsif**: Antarmuka dirancang agar dapat diakses dengan baik di berbagai perangkat (desktop, tablet, dan smartphone).

---

### **Ringkasan**
Admin panel sederhana telah dibuat untuk membantu mitra (Warung Pak Jhon) mengelola berbagai aspek operasional aplikasi SIKMA, termasuk menu makanan, pesanan, pengguna, promosi, dan ulasan. Setiap halaman memiliki fitur dasar seperti pencarian, edit, dan delete, serta tampilan yang intuitif untuk memastikan pengelolaan data menjadi lebih efisien. Meskipun beberapa fitur seperti **Promos** dan **Reviews** masih dalam tahap awal pengembangan, struktur dasar admin panel sudah cukup solid untuk mendukung operasional harian Warung Pak Jhon.


## Challenges & Solutions
- **Challenge 1**: Kesulitan pengaplikasian sistemnya. Kita coba run di laptop lain tapi nggak bisa, Jadi masih usaha buat run di laptop lain, tapi sampai sekarang masih belum bisa jadi mau dicoba lagi 
- **Solution**: -

- **Challenge 2**: Pada minggu ini kami sudah mencoba untuk membuat visualisasi data pada dashboard admin, namun sayangnya kami belum berhasil memasukkan visualisasi data dalam bentuk diagram tersebut ke dalam dashboard admin
- **Solution**: -

## Next Week Plan
- **Penyempurnaan seluruh fitur**
- **Bugfixing**
- **Usability testing**
- **Persiapan deployment (jika diperlukan)**
- **Visualisai data sederhana**
- **Demo progress ke mitra**

## Contributions
- **Incha Raghil (Project Manager & UI/UX Designer)**: menentukan layout,desain layout,dan alur sistem
- **Debora Intania Subekti (Backend Developer)**: Membuat fitur #4,membuat Dashboard Admin sederhana 
- **Adonia Azarya Tamalonggehe (QA & DevOps)**: Menyusun Markdown dan memastikan desain sistem sesuai dengang yang ada di figma
- **Betran (Frontend Developer)**: Membuat fitur #4 (order),membuat Dashboard Admin sederhana